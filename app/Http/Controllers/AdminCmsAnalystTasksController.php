<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Cx;
use Carbon;
use Illuminate\Support\Facades\Route;

class AdminCmsAnalystTasksController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "100";
        $this->orderby = ["updated_at" => "desc", "created_at" => "desc"];
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = true;
        $this->button_delete = false;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "analyst_tasks";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label"=>"Tgl. Permohonan","name"=>"created_at", "callback" => function($q){
            return Carbon::parse($q->created_at)->translatedFormat("d/M/Y H:i");
        }];
        $this->col[] = ["label"=>"Tgl. Perkiraan Selesai Pengujian","name"=>"request_id", "callback" => function($q){
            $r = DB::table('requests')->find($q->request_id);
            return Carbon::parse($r->estimation_dt)->translatedFormat("D, d/M/Y");
        }];
        $this->col[] = ["label"=>"No. Permohonan","name"=>"request_id", "join" => "requests,document_no"];
        $this->col[] = ["label"=>"Analis Ditugaskan","name"=>"id_cms_analyst", "join" => "cms_users,name"];

        $this->col[] = ["label"=>"Parameter","name"=>"parameter", "callback_php" => '$row->parameter ?? "-"'];
        // $this->col[] = ["label"=>"Metode","name"=>"metode", "callback_php" => '$row->metode ?? "-"'];
        $this->col[] = ["label"=>"Mulai Diuji Pada","name"=>"ready_test_at", "callback" => function($q){
            return $q->ready_test_at ? Carbon::parse($q->ready_test_at)->translatedFormat("d/M/Y H:i") : "-";
        }];
        $this->col[] = ["label"=>"Selesai Diuji Pada","name"=>"finish_test_at", "callback" => function($q){
            return $q->finish_test_at ? Carbon::parse($q->finish_test_at)->translatedFormat("d/M/Y H:i") : "-";
        }];
        $this->col[] = ["label"=>"Lampiran","name"=>"attachment", "callback" => function($q){
            return $q->attachment ? "<a href='" . url($q->attachment) . "'>Unduh</a>" : "-";
        }];
        $this->col[] = ["label"=>"Pemroses Akhir","name"=>"id_cms_staff", "join" => "cms_users,name", "callback_php" => '$row->cms_users1_name??"-"'];
        $this->col[] = ["label"=>"Status","name"=>"status"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];   

        if(Cx::myPrivilegeId() == 2 && (!request('type') || request('type') != "handling") && request()->segment(3) == 'edit') {
            Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning");
        }

        if((request('type') || request('ref_parameter') == "type=handling") && in_array(request()->segment(3), ['edit', 'edit-save'])) {
            $this->form[] = ['label'=>'No. Permohonan','name'=>'request_id','type'=>'select2', "datatable" => "requests,document_no", 'disabled'=> true, 'exception' => true];
            $this->form[] = ['label'=>'Status Terakhir','name'=>'status','type'=>'text','disabled'=> true, 'exception' => true];
            $this->form[] = ['label'=>'File Lampiran','name'=>'attachment','type'=>'upload','validation'=>'required|mimes:pdf|max:3000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 3MB"];
        }
        else {
            $this->form[] = ['label'=>'No. Permohonan','name'=>'request_id','type'=>'select2', "datatable" => "requests,document_no", 'disabled'=> true, 'exception' => true];
            $this->form[] = ['label'=>'Tgl. Permohonan','name'=>'created_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s', "value" => now(), "exception" => true, "disabled" => true];
            $this->form[] = ['label'=>'Parameter','name'=>'parameter','type'=>'text'];
            // $this->form[] = ['label'=>'Metode','name'=>'metode','type'=>'text'];
            $this->form[] = ['label'=>'Mulai Diuji Pada','name'=>'ready_test_at','type'=>'text', 'callback_php' => '$row->ready_test_at ? Carbon::parse($row->ready_test_at)->translatedFormat("d/M/Y H:i") : "-"'];
            $this->form[] = ['label'=>'Selesai Diuji Pada','name'=>'finish_test_at','type'=>'text', 'callback_php' => '$row->finish_test_at ? Carbon::parse($row->finish_test_at)->translatedFormat("d/M/Y H:i") : "-"'];
            $this->form[] = ['label'=>'Lampiran','name'=>'attachment','type'=>'upload','validation'=>'required|mimes:pdf|max:3000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 3MB"];
            if(request()->segment(3) == "detail") {
                $this->form[] = ['label'=>'Status Terakhir','name'=>'status','type'=>'text','disabled'=> true, 'exception' => true];
            }
        }
        # END FORM DO NOT REMOVE THIS LINE

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key 	  = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class
        | @parent_columns = Sparate with comma, e.g : name,created_at
        |
        */
        $this->sub_module = array();


        /*
        | ----------------------------------------------------------------------
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color 	   = Default is primary. (primary, warning, succecss, info)
        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
        |
        */
        $this->addaction = array();

        if (Cx::myPrivilegeId() == 4) {
            $this->addaction[] = ['label'=>'Terima Tugas','url'=> Cx::mainpath('set-accept/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>"[status] == 'Analis telah didaftarkan serta menunggu tindakan Analis'", 'confirmation' => true];
        }

        if (Cx::myPrivilegeId() == 3) {
            $this->addaction[] = ['label'=>'Set Selesai','url'=> Cx::mainpath('edit/[id]?type=handling'),'icon'=>'fa fa-upload','color'=>'success','showIf'=>"[status] == 'Dalam Proses Pengujian'"];
        }
        $this->addaction[] = ['label'=>'Parameter Uji','url'=> Cx::mainpath('set-testings/[request_id]'),'icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status] <> 'Siap Diuji'"];

        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon 	   = Icon from fontawesome
        | @name 	   = Name of button
        | Then about the action, you should code at actionButtonSelected method
        |
        */
        $this->button_selected = array();

        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
        */
        $this->alert        = array();



        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
        */
        $this->index_button = array();



        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
        */
        $this->table_row_color = [];
        $this->table_row_color[] = ["condition" => "[status] == 'Analis telah didaftarkan serta menunggu tindakan Analis'", "color" => "warning"];
        $this->table_row_color[] = ["condition" => "[status] == 'Dalam Proses Pengujian'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Selesai Pengujian'", "color" => "success"];
        

        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
        */
        $this->index_statistic = array();



        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = "
        $(function(){
            $('.btn-edit').remove();
            $('input[name=submit]').val('Laporkan Telah Selesai');
        });
        ";


        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
        */
        $this->pre_index_html = null;



        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
        */
        $this->post_index_html = null;


        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();



        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
        */
        $this->style_css = null;



        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $this->load_css[] = asset("myfile.css");
        |
        */
        $this->load_css = array();
    }


    /*
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
    */
    public function actionButtonSelected($id_selected, $button_name)
    {
        //Your code here
    }


    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
    */
    public function hook_query_index(&$query)
    {
        if (Cx::myPrivilegeId() == 4) {
            $query->where($this->table . '.id_cms_analyst', Cx::myID());
        }

        if (Cx::myPrivilegeId() == 3) {
            $query->where(function($q) {
                // $q->whereIn($this->table . '.status', ["Diajukan", "Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Selesai Pengujian", "Selesai"]);

                $explode = explode(";", Cx::me()->platform);
                $lists = DB::table("parameters")->whereIn("type", $explode)->get()->pluck("type");
                $q->whereIn('type', $lists);
            });
        }

        // if (Cx::myPrivilegeId() == 2) {
        //     $query->where(function($q) {
        //         $q->whereIn('status', ["Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Selesai Pengujian", "Selesai"]);
        //     });
        // }
        $query->orderBy($this->table . '.updated_at', 'DESC');
        $query->orderBy($this->table . '.ready_test_at', 'ASC');
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
    */
    public function hook_row_index($column_index, &$column_value)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before add data is execute
    | ----------------------------------------------------------------------
    | @arr
    |
    */
    public function hook_before_add(&$postdata)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
    */
    public function hook_after_add($id)
    {
        //Your code here

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before update data is execute
    | ----------------------------------------------------------------------
    | @postdata = input post data
    | @id       = current id
    |
    */
    public function hook_before_edit(&$postdata, $id)
    {
        //Your code here
        if($postdata['attachment']) {
            $postdata['status'] = "Selesai Pengujian";
            $postdata['id_cms_staff'] = Cx::myId();
            $postdata['finish_test_at'] = now();
            
            $exists = DB::table('analyst_tasks')->find($id);
            $request = DB::table('requests')->find($exists->request_id);
            DB::table('histories')->insert([
                'id_cms_users' => Cx::myId(),
                'request_id' => $request->id,
                'notes' => "Selesai menguji parameter " . $exists->parameter
            ]);

            $all_testings = json_decode($request->testings);
            
            foreach ($all_testings as $key => $item) {
                if($item->parameter == $exists->parameter) {
                    $all_testings[$key]->attachment = $postdata['attachment'];
                    $all_testings[$key]->status = "Selesai Pengujian";
                }
            }

            DB::table('requests')->where('id', $exists->request_id)->update([
                'testings' => json_encode($all_testings),
                'updated_at' => now(),
            ]);
        }
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after edit public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_edit($id)
    {
        //Your code here
        #If semua sudah selesai maka set master menjadi Selesai Pengujian
        $exists = DB::table('analyst_tasks')->find($id);
        $request = DB::table('requests')->find($exists->request_id);
        $all_testings = json_decode($request->testings);
        $count_testings = collect($all_testings)->count();
        $count = 0;
        foreach ($all_testings as $key => $item) {
            if($item->status == "Selesai Pengujian") {
                $count++;
            }
        }

        if($count == $count_testings) {
            DB::table('requests')
                ->where('id', $exists->request_id)
                ->where('status', 'Dalam Proses Pengujian')
                ->update([
                    'status' => "Proses Pembuatan LHP",
                    'updated_at' => now(),
                ]);

            DB::table('histories')->insert([
                'id_cms_users' => 0,
                'request_id' => $request->id,
                'notes' => "Semua pengujian telah dilaporkan selesai oleh semua analis yang terlibat"
            ]);
        }
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command before delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_before_delete($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_delete($id)
    {
        //Your code here
    }



    //By the way, you can still create your own method in here... :)
    public function getSetTestings($id) 
    {
        // if($this->global_privilege==FALSE || $this->button_edit==FALSE) {    
        //     Cx::redirect(Cx::mainPath(), cbLang("denied_access"));
        // }
            
        $data = [];
        $data['page_title'] = 'Parameter Uji';
        $data['row'] = DB::table('requests')
            ->where('id', $id)
            ->first();
        
        if($data['row']) {
            if(Cx::myPrivilegeId() == 5 && $data['row']->id_cms_users != Cx::myId()) {
                Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning");
            } 

            $data['parameters'] = DB::table('parameters')
                ->where('type', $data['row']->type)
                ->where('status', "Active")
                ->get();

if(in_array($data['row']->status, [
    "Diajukan",
    "Siap Diuji",
    "Pra Pengujian",
    "Dalam Proses Pengujian",
    "Proses Pembuatan LHP",
    "LHP Selesai"
])) {

    $data['analysts'] = DB::table('cms_users')
        ->where('id_cms_privileges', 4)
        ->where('status', 'Active')
        ->get();
}
                
            return $this->view('testings', $data);
        }
        else {
            Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!","warning");
        }
    }

   

    public function getSetAccept($id) {
        $exists = DB::table('analyst_tasks')
            ->where('status', "Analis telah didaftarkan serta menunggu tindakan Analis")
            ->find($id);

        if ($exists) {
            if(Cx::myPrivilegeID() == 4) {
                DB::table('analyst_tasks')
                    ->where('status', "Analis telah didaftarkan serta menunggu tindakan Analis")
                    ->where('id', $id)
                    ->update([
                        'status' => 'Dalam Proses Pengujian',
                        'ready_test_at' => now(),
                        'updated_at' => now(),
                    ]);

                $request = DB::table('requests')->find($exists->request_id);
                $all_testings = json_decode($request->testings);
               
                
                foreach ($all_testings as $key => $item) {
                    if($item->parameter == $exists->parameter && $item->id_cms_analyst == Cx::myId()) {
                        $all_testings[$key]->status = "Dalam Proses Pengujian";
                    }
                }

                DB::table('requests')->where('id', $exists->request_id)->update([
                    'testings' => json_encode($all_testings),
                    'status' => 'Dalam Proses Pengujian',
                    'updated_at' => now(),
                ]);

                DB::table('histories')->insert([
                    'id_cms_users' => Cx::myId(),
                    'request_id' => $exists->request_id,
                    'notes' => "Menerima tugas untuk menguji parameter " . $exists->parameter,
                ]);
                
                Cx::redirect(Cx::mainPath(), "Tugas berhasil diterima!","success");                    
            } 
            else {
                Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning");
            }
        }
        else {
            Cx::redirect(Cx::mainPath(), "Data tugas tidak ditemukan!","warning");
        }
    }

    public function postUpdateTestings($id)
    {
        $exists = \DB::table('requests')->find($id);
        
        if($exists) {
            $data = request()->all();
            $parameters = [];
            
            // Decode data JSON parameter dari database
            $testings = json_decode($exists->testings);
            
            if ($data['analyst'] && collect($data['analyst'])->count() > 0) {
                foreach ($testings as $key => $item) {
                    
                    // Mendapatkan status baru dari input form (dropdown Selesai Pengujian)
                    $newStatus = isset($data['status'][$key]) ? $data['status'][$key] : $testings[$key]->status;

                    // Eksekusi Logika: Jika Analis mengubah status menjadi "Selesai Pengujian"
                    if ($newStatus == "Selesai Pengujian" && $testings[$key]->status != "Selesai Pengujian") {
                        // Update status di tabel tugas analis
                        \DB::table('analyst_tasks')->where([
                            'request_id' => $id,
                            'parameter' => $testings[$key]->parameter,
                            'id_cms_analyst' => (int) $data['analyst'][$key],
                        ])->update([
                            'status' => 'Selesai Pengujian',
                            'updated_at' => now()
                        ]);
                        
                        // Catat log riwayat
                        \DB::table('histories')->insert([
                            'id_cms_users' => \Cx::myId(),
                            'request_id' => $id,
                            'notes' => "Analis telah menyelesaikan pengujian parameter: " . $testings[$key]->parameter
                        ]);
                    }

                    // Susun ulang data parameter untuk disimpan kembali
                    $newData = [
                        'id' => (int) $testings[$key]->id,
                        'parameter' => $testings[$key]->parameter,
                        'harga_text' => $testings[$key]->harga_text,
                        'harga' => (int) $testings[$key]->harga,
                        'noik' => $testings[$key]->noik,
                        'id_cms_analyst' => (int) $testings[$key]->id_cms_analyst,
                        'status' => $newStatus, 
                    ];
                    
                    $parameters[] = $newData;
                }
            }

            // Pengecekan otomatisasi: Apakah SEMUA parameter sudah "Selesai Pengujian"?
            $all_done = true;
            if (count($parameters) > 0) {
                foreach($parameters as $p) {
                    if ($p['status'] != "Selesai Pengujian") {
                        $all_done = false;
                        break;
                    }
                }
            } else {
                $all_done = false;
            }

            $new_req_status = $exists->status;
            
            // Otomatisasi: Jika Analis menyelesaikan pekerjaannya dan semua parameter beres,
            // status permohonan utama maju ke "Proses Pembuatan LHP"
            if ($exists->status == "Dalam Proses Pengujian" && $all_done) {
                $new_req_status = "Proses Pembuatan LHP";
                \DB::table('histories')->insert([
                    'id_cms_users' => \Cx::myId(),
                    'request_id' => $id,
                    'notes' => "Semua parameter uji telah selesai diuji oleh Analis, permohonan berlanjut ke Proses Pembuatan LHP"
                ]);
            }
    
            // Simpan pembaruan ke tabel 'requests'
            $body = [
                'testings' => json_encode($parameters),
                'status' => $new_req_status,
                'updated_at' => now()
            ];

            \DB::table('requests')->where('id', $id)->update($body);
            
            // Redirect kembali ke daftar tugas analis
            \CRUDBooster::redirect(\CRUDBooster::mainPath(), "Data pengujian berhasil disimpan!","success");
        }
        else {
            \CRUDBooster::redirect(\CRUDBooster::mainPath(), "Data permohonan tidak ditemukan!","warning");
        }
    }
}
