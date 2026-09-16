<?php namespace App\Http\Controllers;

use Cx;
use Session;
use Request;
use DB;
use Carbon\carbon as Carbon;

class AdminCmsRequestTestingsController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "25";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_addmore = false;
        $this->button_edit = false;
        $this->button_delete = false;
        $this->button_detail = true;
        $this->button_show = false;
        $this->button_filter = false;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "request_testings";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = ["label"=>"Tgl. Dibuat","name"=>"created_at", "callback" => function ($x) {
        //     return \Carbon\carbon::parse($x->created_at)->format('d/M/Y H:i');
        // }];
        // $this->col[] = ["label"=>"Nomor","name"=>"document_no"];
        // $this->col[] = ["label"=>"Tgl. Surat","name"=>"date"];
        // $this->col[] = ["label"=>"No. Voucher","name"=>"voucher_id", "join" => "sert_voucher,document_no", "width" => "10%", "callback" => function ($q) {
        //     return $q->sert_voucher_document_no ?? '-';
        // }];
        // $this->col[] = ["label"=>"Pembuat","name"=>"id_sert_users", "join" => "sert_users,name", "width" => "15%"];
        // $this->col[] = ["label"=>"printable","name"=>"printable", "visible" => false];
        // $this->col[] = ["label"=>"Status","name"=>"status", "callback" => function ($q) {
        //     return "<b>{$q->status}</b>";
        // }, "width" => "10%"];
        # END FORM DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $id = Cx::getCurrentId();
        if (in_array(Request::segment(3), ['edit', 'detail'])) {
            $id = Request::segment(4);
            Session::put('current_row_id', $id);
        }
        $row = Cx::first($this->table, $id);
        $row = (in_array(Request::segment(3), ["edit", "edit-save", "detail"])) ? $row : null;
        
        $this->form = [];
        // $this->form[] = ["label"=>"Nomor", "type" => "text","name"=>"document_no", "validation"=>"required|string|max:255|unique:sert_surat_tugas,document_no"];
        // $this->form[] = ["label"=>"Tgl. Surat", "type" => "date","name"=>"date", "validation"=>"required|date_format:Y-m-d", "value" => now()->format('Y-m-d')];
        // $this->form[] = ["label"=>"Pilih Voucher","name"=>"voucher_id","type"=>"select","validation"=>"required|integer|exists:sert_voucher,id","datatable"=>"sert_voucher,document_no","datatable_where" => "status <> 'Lengkap' AND id_sert_users = " . CRUDBooster::myID(), "disabled" => (isset($row) ? true : false), "exception" => (isset($row) ? true : false)];
        
        // $this->form[] = ["label"=>"Dalam Rangka", "type" => "textarea","name"=>"rangka", "validation"=>"required|string|max:1000"];
        
        $testings = view('testings', compact('row'))->render();
        $this->form[] = ["label"=>"Daftar Pengujian","name"=>"testings","type"=>"custom","html"=>$testings];
        
        # END FORM DO NOT REMOVE THIS LINE

        $this->addaction = [];
        // $this->addaction[] = ["label"=>"","url"=>CRUDBooster::mainpath("docx/[id]"),"icon"=>"fa fa-print","color"=>"success", "showIf" => "[printable] == 1"];

        $this->table_row_color = [];
        $this->table_row_color[] = ['condition'=>"[status] == 'Lengkap'","color"=>"success"];
     
        $this->index_statistic = [];

        $this->load_js = [];
        
        $this->style_css = "
        .btn-purple, .btn-purple:hover {
            background-color: #8e44ad;
            border-color: #8e44ad;
            color: #fff;
        }
        ";

        // $users = DB::table('sert_users')->where('id_sert_privileges', '<>', 1)->get();
        // $this->script_js = "
        //     $(function(){
        //         $(document).on('click', '#checkAll', function() {
        //             $('.itemRow').prop('checked', this.checked);
        //         });
            
        //         $(document).on('click', '.itemRow', function() {
        //             if ($('.itemRow:checked').length == $('.itemRow').length) {
        //                 $('#checkAll').prop('checked', true);
        //             } else {
        //                 $('#checkAll').prop('checked', false);
        //             }
        //         });
            
        //         var count = $('.itemRow').length;
        //         $(document).on('click', '#addRows', function() {
        //             count++;
        //             var htmlRows = '';
        //             htmlRows += `
        //                 <tr>
        //                     <td>
        //                         <input class=\"itemRow\" type=\"checkbox\">
        //                     </td>
        //                     <td>
        //                         <select name=\"user[]\" id=\"user_`+ count + `\" class=\"form-control user\" required>
        //                             <option value=\"\">Pilih Peserta</option>
        //                             ";
                                    
        //                             foreach($users as $user) {
        //                                 $this->script_js .= "<option value=\"" .  $user->id . "\">" .  $user->name . " " .  $user->nip . " " .  $user->gol . "</option>";
        //                             }
                                    
        //                         $this->script_js .= "</select>
        //                     </td>
        //                     <td>
        //                         <input type=\"text\" name=\"lokasi[]\" id=\"lokasi_`+ count + `\" class=\"form-control lokasi\" autocomplete=\"off\" required>
        //                     </td>
        //                     <td>
        //                         <input type=\"text\" name=\"waktu[]\" id=\"waktu_`+ count + `\" class=\"form-control waktu\" autocomplete=\"off\" required>
        //                     </td>
        //                     <td>
        //                         <input type=\"tujuan\" name=\"tujuan[]\" id=\"tujuan_`+ count + `\" class=\"form-control tujuan\" autocomplete=\"off\" required>
        //                     </td>
        //                 </tr>
        //             `;
        //             $('#invoiceItem > tbody').append(htmlRows);
        //         });
            
        //         $(document).on('click', '#removeRows', function(){
        //             $('.itemRow:checked').each(function() {
        //                 $(this).closest('tr').remove();
        //             });
        //             $('#checkAll').prop('checked', false);
        //         });
        //     });   
        // ";

        $this->load_css = [];
    }


    public function actionButtonSelected($id_selected, $button_name)
    {
    }

    public function hook_query_index(&$query)
    {
        if (in_array(CRUDBooster::myPrivilegeId(), [3, 4, 5])) {
            // $query->where('sert_surat_tugas.id_sert_users', CRUDBooster::myId());
        }
    }

    public function hook_row_index($column_index, &$column_value)
    {
    }

    public function hook_before_add(&$postdata)
    {
        if (isset($postdata['rangka'])) {
            $postdata['rangka'] = $this->filter($postdata['rangka']);
        }

        if (isset($postdata['date'])) {
            $postdata['day_name'] = Carbon::parse($postdata['date'])->format('N');
            $postdata['day'] = Carbon::parse($postdata['date'])->format('j');
            $postdata['month'] = Carbon::parse($postdata['date'])->format('n');
            $postdata['year'] = Carbon::parse($postdata['date'])->format('Y');
        }
        
        $items = [];
        foreach($_POST['user'] as $key => $item) {
            $items[] = [
                'user' => $_POST['user'][$key],
                'lokasi' => $_POST['lokasi'][$key],
                'waktu' => $_POST['waktu'][$key],
                'tujuan' => $_POST['tujuan'][$key],
            ];
        }
        
        $postdata['datas'] = collect($postdata)->except('type', 'created_at', 'updated_at', 'id_sert_users')->toJson();
        $postdata['printable'] = 1;
        foreach ($postdata as $key => $val) {
            if (!in_array($key, ['datas', 'document_no', 'printable', 'date', 'updated_at', 'voucher_id'])) {
                unset($postdata[$key]);
            }
        }

        $postdata['status'] = "Lengkap";
        $postdata['peserta'] = json_encode($items);
        $postdata['id_sert_users'] = CRUDBooster::myID();
    }

    public function hook_after_add($id)
    {
        #Get ST
        $st = DB::table('sert_surat_tugas')->where('id', $id)->first();

        #Update Voucher
        DB::table('sert_voucher')->where('id', $st->voucher_id)->update([
            'surat_tugas_id' => $id
        ]);

        #Check Apakah Lengkap
        $voucher = DB::table('sert_voucher')->where('id', $st->voucher_id)->first();
        if($voucher->surat_tugas_id && $voucher->sppd_id) {
            DB::table('sert_voucher')->where('id', $st->voucher_id)->update([
                'status' => 'Lengkap'
            ]);
        }
    }

    public function hook_before_edit(&$postdata, $id)
    {
        if (isset($postdata['rangka'])) {
            $postdata['rangka'] = $this->filter($postdata['rangka']);
        }

        if (isset($postdata['date'])) {
            $postdata['day_name'] = Carbon::parse($postdata['date'])->format('N');
            $postdata['day'] = Carbon::parse($postdata['date'])->format('j');
            $postdata['month'] = Carbon::parse($postdata['date'])->format('n');
            $postdata['year'] = Carbon::parse($postdata['date'])->format('Y');
        }
        
        $items = [];
        foreach($_POST['user'] as $key => $item) {
            $items[] = [
                'user' => $_POST['user'][$key],
                'lokasi' => $_POST['lokasi'][$key],
                'waktu' => $_POST['waktu'][$key],
                'tujuan' => $_POST['tujuan'][$key],
            ];
        }
        
        $postdata['datas'] = collect($postdata)->except('type', 'created_at', 'updated_at', 'id_sert_users')->toJson();
        $postdata['printable'] = 1;
        foreach ($postdata as $key => $val) {
            if (!in_array($key, ['datas', 'document_no', 'printable', 'date', 'updated_at', 'voucher_id'])) {
                unset($postdata[$key]);
            }
        }

        $postdata['status'] = "Lengkap";
        $postdata['peserta'] = json_encode($items);
        $postdata['id_sert_users'] = CRUDBooster::myID();
    }

    public function filter($string)
    {
        $string = str_replace("<o:p>", "", $string);
        $string = str_replace("</o:p>", "", $string);
        $string = str_replace("<br>", "", $string);
        $string = str_replace("&nbsp;", "", $string);
        $string = str_replace(' class="MsoNormal"', "", $string);
        $string = str_replace(' lang="IN"', "", $string);
        $string = preg_replace('/style=(["\'])[^\1]*?\1/i', '', $string, -1);
        // $string = preg_replace( '/width=(["\'])[^\1]*?\1/i', '', $string, -1 );
        $string = str_replace(" >", ">", $string);
        $string = str_replace("\&quot;", "", $string);
        // $string = str_replace("<span>", "", $string);
        // $string = str_replace("</span>", "", $string);
        return $string;
    }

    public function hook_after_edit($id)
    {
        #Get ST
        $st = DB::table('sert_surat_tugas')->where('id', $id)->first();

        #Update Voucher
        DB::table('sert_voucher')->where('id', $st->voucher_id)->update([
            'surat_tugas_id' => $id
        ]);

        #Check Apakah Lengkap
        $voucher = DB::table('sert_voucher')->where('id', $st->voucher_id)->first();
        if($voucher->surat_tugas_id && $voucher->sppd_id) {
            DB::table('sert_voucher')->where('id', $st->voucher_id)->update([
                'status' => 'Lengkap'
            ]);
        }
    }

    public function hook_before_delete($id)
    {
    }

    public function hook_after_delete($id)
    {
    }

    public function getDayName($x)
    {
        $arr = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return $arr[$x-1];
    }

    public function getMonthName($x)
    {
        $arr = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $arr[$x-1];
    }

    public function getDocx($id)
    {
        $doc = Document::with('template')->find($id)->toArray();
        
        $new = [];
        $var = json_decode($doc['datas'], true);
        $dt = $var->date;

        $day = Carbon::parse($dt)->format('d');
        $month = $this->getMonthName(Carbon::parse($dt)->format('n'));
        $year = Carbon::parse($dt)->format('Y');
        $var['date'] = "$day $month $year";
        foreach ($var as $key =>$x) {
            $newKey = strtoupper($key);
            $new["$newKey"] = $x;

            if (strpos($key, 'total_') !== false && strpos($key, '_text') === false) {
                $var[$key] = number_format($x, 2, ',', '.');
            }

            if ($key == 'day_name') {
                $var[$key] = $this->getDayName($x);
            }

            if ($key == 'month') {
                $var[$key] = $this->getMonthName($x);
            }
        }
        
        $source = storage_path('app') . '/' . $doc['template']['file'];
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($source);
        foreach ($var as $key => $x) {
            if ($this->isHTML($x)) {
                $section = (new\PhpOffice\PhpWord\PhpWord())->addSection();
                $html = $x;
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
                $containers = $section->getElements();

                $templateProcessor->cloneBlock('htmlblock', count($containers), true, true);

                for ($i = 0; $i < count($containers); $i++) {
                    $templateProcessor->setComplexBlock('html#' . ($i+1), $containers[$i]);
                }
            } else {
                $templateProcessor->setValue($key, $x);
            }
        }

        $fileName = $doc['template']['name'] . '_' . str_replace('/', '-', $doc['document_no']) . '.docx';
        header("Content-Disposition: attachment; filename={$fileName}");
        $templateProcessor->saveAs('php://output');
    }

    public function isHTML($string)
    {
        if ($string != strip_tags($string)) {
            return true;
        } else {
            return false;
        }
    }

    public static function terbilang($number)
    {
        $number = str_replace('.', '', $number);

        if (! is_numeric($number)) {
            return 0;
        }

        $base    = array('nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
        $numeric = array('1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1);
        $unit    = array('kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
        $str     = null;

        $i = 0;

        if ($number == 0) {
            $str = 'nol';
        } else {
            while ($number != 0) {
                $count = (int)($number / $numeric[$i]);

                if ($count >= 10) {
                    $str .= static::terbilang($count) . ' ' . $unit[$i] . ' ';
                } elseif ($count > 0 && $count < 10) {
                    $str .= $base[$count] . ' ' . $unit[$i] . ' ';
                }

                $number -= $numeric[$i] * $count;

                $i++;
            }

            $str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
            $str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
            $str = preg_replace('/\s{2,}/', ' ', trim($str));
        }

        return $str;
    }

    public function getCities()
    {
        return Kabupaten::orderBy('id_sert_provinsis', 'asc')->get()->mapWithKeys(function ($q) {
            $city = ucwords(strtolower(str_replace("KOTA ", "", $q->name)));
            if (strpos($city, "Jakarta") !== false) {
                $value = [explode(" ", $city)[0] => explode(" ", $city)[0]];
            } else {
                $value = [$city => $city];
            }
            return $value;
        })->toArray();
    }
}
