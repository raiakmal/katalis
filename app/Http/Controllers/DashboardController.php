<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cx;
use Carbon;
use Carbon\CarbonPeriod;
use App\Charts\StatisticsChart;
use Balping\JsonRaw\Raw;
use App\Models\Lot;
use App\Models\Category;
use DB;
use App\Jobs\SendMail;


class DashboardController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function __construct()
    {
        $this->middleware('\crocodicstudio\crudbooster\middlewares\CBBackend')->except(['getWelcome', 'getMaklumatPelayanan', 'getJenisLayanan', 'getTarifPengujian']);
    }


    public function getIndex()
    {
        $data = [];
        $data['page_title'] = '<strong>Dashboard</strong>';
        // $data['categories'] = Category::where('status', 'Active')->get();
        
        $data['new_users'] = DB::table('cms_users')
            ->where([
                'id_cms_privileges' => 5,
                'status' => 'Inactive',

            ])
            ->get()
            ->count();

        $data['customers'] = DB::table('cms_users')
            ->where([
                'id_cms_privileges' => 5,
                'status' => 'Active',

            ])
            ->get()
            ->count();
        
        $data['users'] = DB::table('cms_users')
            ->where([
                'status' => 'Active',
            ])
            ->whereNotIn('id_cms_privileges', [1, 5, 6])
            ->get()
            ->groupBy('id_cms_privileges')
            ->map(function($q) {
                return $q->count();
            });

        $data['requests'] = DB::table('requests')
            ->where(function($q) {
                if(Cx::myPrivilegeId() == 5) {
                    $q->where('id_cms_users', Cx::myId());
                }
                if (Cx::me()->platform) {
                    $explode = explode(";", Cx::me()->platform);
                    $params = DB::table('parameters')
                        ->whereIn('type', $explode)
                        ->get()
                        ->pluck('type')
                        ->toArray();
                    $q->whereIn('type', $params);
                }
            })
            ->get()
            ->groupBy('status')
            ->map(function($q) {
                return $q->count();
            });

        
        $data['analyst_workloads'] = DB::table('cms_users')
            ->where([
                'id_cms_privileges' => 4,
                'status' => 'Active',
            ])
            ->where(function($q) {
                if(Cx::me()->platform) {
                    $explode = explode(";", Cx::me()->platform);
                    foreach($explode as $x) {
                        $q->orWhere('platform', 'LIKE', '%' . $x . '%');
                    }
                }
            })
            ->get()
            ->map(function($q) {
                $q->works = DB::table('analyst_tasks')
                    ->where('id_cms_analyst', $q->id)
                    ->get()
                    ->groupBy('status')
                    ->map(function($q) {
                        return $q->count();
                    });
                return $q;
            });

        $data['activities'] = DB::table('histories')
            ->where(function($q) {
                $x = DB::table('requests')
                    ->select('requests.id', 'requests.id_cms_users')
                    ->join('cms_users', 'requests.id_cms_users', 'cms_users.id')
                    ->where(function($q) {
                        if(Cx::myPrivilegeId() == 5) {
                            $q->where('id_cms_users', Cx::myId());
                        }

                        if (Cx::me()->platform) {
                            $explode = explode(";", Cx::me()->platform);
                            $lists = DB::table("parameters")->whereIn("type", $explode)->get()->pluck("type");
                            $q->whereIn('type', $lists);
                        }
                    })
                    ->get()
                    ->pluck('id');
                $q->whereIn('request_id', $x);

                
                if(in_array(Cx::myPrivilegeId(), [3])) {
                    $q->where('notes', 'NOT LIKE', '%baru%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($q) {
                if($q->id_cms_users == 0) {
                    $q->user_name = "System";
                    $q->user_company = "BPMPT";
                }
                else {
                    $user = DB::table('cms_users')->find($q->id_cms_users);
                    if($user) {
                        $q->user_name = $user->name;
                        $q->user_company = $user->company;
                        $q->user_role = DB::table('cms_privileges')->find($user->id_cms_privileges)->name;
                    }
                    else {
                        unset($q);
                    }
                }

                $q->document_no = DB::table('requests')->find($q->request_id)->document_no;
                $q->created_at = Carbon::parse($q->created_at)->translatedFormat('l, d/M/Y H:i');
                return $q;
            });

        if(Cx::myPrivilegeId() == 4) {
            $data['myWorks'] = DB::table('analyst_tasks')
                ->where('id_cms_analyst', Cx::myId())
                ->get()
                ->groupBy('status')
                ->map(function($q) {
                    return $q->count();
                });
        }
        
        if (request('debug')) {
            return response()->json($data);
        }
        
        return view('home', $data);
    }

    public function getWelcome()
    {
        return view('crudbooster::after_register');
    }

    public function getMaklumatPelayanan()
    {
        $data = Cx::getSetting('maklumat_pelayanan');
        return view('home-image-page', compact('data'));
    }

    public function getJenisLayanan()
    {
        $data = Cx::getSetting('jenis_layanan');
        return view('home-image-page', compact('data'));
    }

    public function getTarifPengujian()
    {
        $data = Cx::getSetting('tarif_pengujian');
        return view('home-image-page', compact('data'));
    }

    public function dailyStatisticChart()
    {
        $chart = new StatisticsChart;

        $chart->title('Pertumbuhan Pendapatan Hari Berjalan', 14, "#145984", 'bold', 'Roboto');

        $datas = [];
        $start = now()->format('Y-m-d 00:00:00');
        $end = now();
        $diff = $end->diffInHours($start);
        foreach (range(1, $diff) as $key => $time) {
            $start = sprintf("%02d", $key);
            $end = sprintf("%02d", $time);
            $hotel = mt_rand(10000000, 25000000);
            $restoran = mt_rand(5000000, 22000000);
            $parkir = mt_rand(5000000, 25000000);
            $hiburan = mt_rand(5000000, 25000000);
            $total = $hotel + $restoran + $parkir + $hiburan;
            $datas[] = [
                'whereStart' => now()->format("Y-m-d $start:00:00"),
                'whereEnd' => now()->format("Y-m-d $end:00:00"),
                'label' => now()->format("$end:00"),
                'hotel' => $hotel,
                'restoran' => $restoran,
                'parkir' => $parkir,
                'hiburan' => $hiburan,
                'total' => $total
            ];
        }

        $chart->labels(
            collect($datas)->pluck('label')
        );

        $chart
            ->dataset('Total', 'line', collect($datas)->pluck('total'))
            ->backgroundcolor("rgb(255, 99, 132)")
            ->fill(false)
            ->linetension(0)
            ->options([
                'borderWidth' => 5,
                'borderColor' => 'rgb(255, 99, 132)',
                'pointRadius' => 5,
                'pointHoverRadius' => 10,
                'pointStyle' => 'rect'
            ])
            ->dashed([5, 5]);

        $chart
            ->dataset('Hotel', 'bar', collect($datas)->pluck('hotel'))
            ->backgroundcolor("#0173b7")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ])
            ->color("#0173b7");

        $chart
            ->dataset('Restoran', 'bar', collect($datas)->pluck('restoran'))
            ->backgroundcolor("#dd4b39")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ])
            ->color("#dd4b39");

        $chart
            ->dataset('Parkir', 'bar', collect($datas)->pluck('parkir'))
            ->backgroundcolor("#01a65b")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ])
            ->color("#01a65b");

        $chart
           ->dataset('Hiburan', 'bar', collect($datas)->pluck('hiburan'))
           ->backgroundcolor("#f39c13")
           ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ])
            ->color("#f39c13");

        return $chart;
    }

    public function monthlyStatisticChart()
    {
        $chart = new StatisticsChart;

        $chart->title('Pertumbuhan Pendapatan Bulan Berjalan', 14, "#145984", 'bold', 'Roboto');

        $datas = [];
        $dates = CarbonPeriod::create(now()->startOfMonth(), now());
        foreach ($dates as $dt) {
            $hotel = mt_rand(100000000, 250000000);
            $restoran = mt_rand(50000000, 220000000);
            $parkir = mt_rand(50000000, 250000000);
            $hiburan = mt_rand(50000000, 250000000);
            $value = $hotel + $restoran + $parkir + $hiburan;
            $datas[] = [
                'date' => $dt->format('d/m/Y'),
                'value' => $value,
                'hotel' => $hotel,
                'restoran' => $restoran,
                'parkir' => $parkir,
                'hiburan' => $hiburan,
            ];
        }

        $chart->labels(
            collect($datas)->pluck('date')
        );

        $chart
            ->dataset('Total', 'line', collect($datas)->pluck('value'))
            ->backgroundcolor("rgb(255, 99, 132)")
            ->fill(false)
            ->linetension(0)
            ->options([
                'borderWidth' => 5,
                'borderColor' => 'rgb(255, 99, 132)',
                'pointRadius' => 5,
                'pointHoverRadius' => 10,
                'pointStyle' => 'rect'
            ])
            ->dashed([5, 5]);

        $chart
            ->dataset('Hotel', 'bar', collect($datas)->pluck('hotel'))
            ->backgroundcolor("#0173b7")
            ->color("#0173b7")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ]);

        $chart
            ->dataset('Restoran', 'bar', collect($datas)->pluck('restoran'))
            ->backgroundcolor("#dd4b39")
            ->color("#dd4b39")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ]);

        $chart
            ->dataset('Parkir', 'bar', collect($datas)->pluck('parkir'))
            ->backgroundcolor("#01a65b")
            ->color("#01a65b")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ]);

        $chart
           ->dataset('Hiburan', 'bar', collect($datas)->pluck('hiburan'))
           ->backgroundcolor("#f39c13")
            ->color("#f39c13")
            ->options([
                'barPercentage' => 0.50,
                'maxBarThickness' => 25,
            ]);

        return $chart;
    }

    public function yearlyStatisticChart()
    {
        $chart = new StatisticsChart;
        // $chart->options($this->chartOptions(), true);
        $chart->title('Monthly', 14, "#145984", 'bold', 'Roboto');
        $chart->barwidth(0.1);
        $chart->labels(['Jan', 'Feb', 'Mar']);
        $chart->dataset('Pertumbuhan Pendapatan Tahunan', 'bar', [30, 15, 44])
            ->color("#145984")
            ->backgroundcolor("#145984")
            ->fill(false)
            ->linetension(0);

        return $chart;
    }

    public function getLab()
    {
        $request = DB::table('requests')->find(1);
        $file = url($request->billing_file);
        $user = DB::table('cms_users')->find($request->id_cms_users);
        $size = number_format($request->size);
        $others = $request->unit_others;
        $unit = $request->unit;

        if($others) 
            $unit = $others . " (Lainnya)";

        $jumlah_sampel = "{$size} {$unit}";
        $jenis_pengujian = $request->type;
        $perkiraan = Carbon::parse($request->estimation_dt)->format('d/F/Y');
        $mail = [
            'email' => $user->email,
            'name' => $user->name,
            'document_no' => $request->document_no,
            'asal_sampel' => $user->company,
            'alamat' => $user->address,
            'nama_sampel' => $request->name,
            'jumlah_sampel' => $jumlah_sampel,
            'jenis_pengujian' => $jenis_pengujian,
            'perkiraan' => $perkiraan,
            'status' => 'Menunggu Pembayaran',
            'notes' => "Pelanggan yang terhormat, silahkan membayar biaya pengujian sesuai PP yang berlaku di bank mana saja dengan kode billing yang kami informasikan dan terbitkan pada dashboard KATALIS. Atau Anda dapat mengunduhnya melalui link berikut ini <a href='" . $file . "'>Klik Disini</a>.",
            'template' => 'new_updates_2',
        ];

        $job = new SendMail($mail);
        dispatch($job);
    }
}
