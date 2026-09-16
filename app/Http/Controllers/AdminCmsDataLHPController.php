<?php

namespace App\Http\Controllers;

use App\Models\User;
use Session;
use Request;
use DB;
use Cx;
use PDF;
use App\Jobs\SendMail;

class AdminCmsDataLHPController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "name";
        $this->limit = "20";
        $this->orderby = ["created_at" => "desc"];
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_addmore = false;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "data_lhp";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Status", "name" => "status"];
        $this->col[] = ["label" => "Tgl. Generate", "name" => "created_at"];
        $this->col[] = ["label" => "Tgl. Verifikasi MT", "name" => "verified_at", "callback_php" => '$row->verified_at ?? "-"'];
        $this->col[] = ["label" => "Jenis Pengujian", "name" => "jenis_pengujian"];
        $this->col[] = ["label" => "No. Permohonan", "name" => "request_id", "join" => "requests,document_no"];
        $this->col[] = ["label" => "No. Seri LHP", "name" => "lhp_no"];
        $this->col[] = ["label" => "Deskripsi Sampel", "name" => "deskripsi_sampel"];
        $this->col[] = ["label" => "Detil Perusahaan", "name" => "company_detail", "callback" => function ($q) {
            return nl2br($q->company_detail);
        }];
        $this->col[] = ["label" => "Nama Sampel", "name" => "sample_name"];
        $this->col[] = ["label" => "Banyaknya Sampel", "name" => "sample_number"];
        $this->col[] = ["label" => "Keadaan Sampel", "name" => "sample_state"];
        $this->col[] = ["label" => "Tgl. Terima Sampel", "name" => "sample_receive_dt"];
        $this->col[] = ["label" => "Tgl. Awal Pengujian", "name" => "start_test_dt"];
        $this->col[] = ["label" => "Tgl. Akhir Pengujian", "name" => "end_test_dt"];
        $this->col[] = ["label" => "Metode Pengujian", "name" => "testing_method"];
        $this->col[] = ["label" => "Hasil Pengujian", "name" => "testing_result"];
        $this->col[] = ["label" => "Ttd. MT", "name" => "mts", "join" => "cms_users,name"];
        $this->col[] = ["label" => "Pembuat LHP", "name" => "id_cms_staffs", "join" => "cms_users,name"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'No. Permohonan', 'name' => 'request_id', 'type' => 'select2', 'validation' => 'required|integer|exists:requests,id|unique:data_lhp,request_id', 'datatable' => 'requests,document_no', 'datatable_where' => "status = 'Proses Pembuatan LHP'", 'datatable_format' => 'document_no," - ",type," - ",name," | Estimasi Selesai: ",estimation_dt', 'readonly' => request()->segment(3) == "edit" ? true : false, 'disabled' => request()->segment(3) == "edit" ? true : false, 'exception' => request()->segment(3) == "edit" ? true : false];
        
        if((request('type') || request('ref_parameter')) && in_array(request()->segment(3), ['edit', 'edit-save'])) {
            if ((request('type') == "upload-final-lhp" || request('ref_parameter') == "type=upload-final-lhp") && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->form[] = ['label'=>'PDF Tertanda Tangan','name'=>'pdf','type'=>'upload','validation'=>'required|mimetypes:application/octet-stream,application/pdf|max:2000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 2MB"];
            }
        }
        else {
            $this->form[] = ['label' => 'No. Seri LHP', 'name' => 'lhp_no', 'type' => 'text', 'validation' => 'required|string|min:1|max:100|unique:data_lhp,lhp_no', 'placeholder' => 'Masukkan no. seri LHP'];
            $this->form[] = ['label' => 'Deskripsi Sampel', 'name' => 'deskripsi_sampel', 'type' => 'select2', 'validation' => 'required|string|min:5|max:100', 'dataenum' => 'Padatan;Cairan;Aerosol'];
            $this->form[] = ['label' => 'Detil Perusahaan', 'name' => 'company_detail', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:10000', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Jenis Pengujian', 'name' => 'jenis_pengujian', 'type' => 'text', 'validation' => 'required|string|min:5|max:100', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Nama Sampel', 'name' => 'sample_name', 'type' => 'text', 'validation' => 'required|string|min:5|max:100', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Banyaknya Sampel', 'name' => 'sample_number', 'type' => 'text', 'validation' => 'required|string|min:1|max:100', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Keadaan Sampel', 'name' => 'sample_state', 'type' => 'text', 'validation' => 'required|string|min:1|max:100', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Tgl. Terima Sampel', 'name' => 'sample_receive_dt', 'type' => 'date', 'validation' => 'required|string|min:5|max:100', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Tgl. Awal Pengujian', 'name' => 'start_test_dt', 'type' => 'date', 'validation' => 'required|date_format:Y-m-d', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Tgl. Selesai Pengujian', 'name' => 'end_test_dt', 'type' => 'date', 'validation' => 'required|date_format:Y-m-d|after_or_equal:start_test_dt', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Metode Pengujian', 'name' => 'testing_method', 'type' => 'text', 'validation' => 'required|string|min:5|max:250', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            $this->form[] = ['label' => 'Hasil Pengujian', 'name' => 'testing_result', 'type' => 'textarea', 'validation' => 'required|string|min:1|max:10000', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
            // $this->form[] = ['label' => 'Notes', 'name' => 'notes', 'type' => 'wysiwyg', 'validation' => 'required|string|min:1|max:10000', 'placeholder' => 'Pilih No. Permohonan terlebih dahulu', 'readonly' => request()->segment(3) == "edit" ? false : true];
    
            $enum = [];
            $mtName = null;
            if (in_array(request()->segment(3), ['edit', 'detail'])) {
                $row = DB::table($this->table)->where($this->primary_key, request()->segment(4))->first();
                $mts = User::select('id', 'nip', 'name')->where('platform', 'like', '%' . $row->jenis_pengujian . '%')->where('id_cms_privileges', 3)->whereStatus('Active')->get()->mapWithKeys(function ($q) {
                    return [$q->id => ($q->nip ?? "NIP BELUM ADA") . " - " . $q->name];
                });
    
                foreach ($mts as $k => $mt) {
                    $enum[] = $k . "|" . $mt;
                }
    
                if (request()->segment(3) == "detail") {
                    $mt = User::find($row->mts);
                    $mtName = ($mt->nip ?? "NIP BELUM ADA") . " - " . $mt->name;
                }
            }
    
            $this->form['mts'] = ['label' => 'MT Penanda Tangan', 'name' => 'mts', 'type' => 'select', 'validation' => 'required|integer|exists:cms_users,id', 'dataenum' => implode(";", $enum), 'readonly' => request()->segment(3) == "edit" ? false : true];
    
            if ($mtName)
                $this->form['mts']["callback_php"] = "'$mtName'";
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

        if (in_array(Cx::myPrivilegeId(), [1, 2, 3])) {
            if (in_array(Cx::myPrivilegeId(), [1, 3])) {
                $this->addaction[] = ['label' => 'Verifikasi', 'url' => Cx::mainpath('set-accept/[id]'), 'icon' => 'fa fa-eye', 'color' => 'info', 'showIf' => "[status] == 'Pending'", "confirmation" => true];
            }
            $this->addaction[] = ['label' => 'Unduh Draft LHP', 'url' => Cx::mainpath('set-draft-lhp/[id]'), 'icon' => 'fa fa-eye', 'color' => 'success', 'showIf' => "[status] == 'Pending'", "confirmation" => true];

            if (in_array(Cx::myPrivilegeId(), [1, 2])) {
                $this->addaction[] = ['label' => 'Upload PDF + TTD', 'url' => Cx::mainpath('edit/[id]?type=upload-final-lhp'), 'icon' => 'fa fa-upload', 'color' => 'success', 'showIf' => "[status] == 'Sudah Diverifikasi'", "confirmation" => true];
            }
        }



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
        $this->table_row_color = array();


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
                var mts = $('#mts');
                mts.attr('required', true);

                mts.bind('change', function () {
                    $(this).trigger('blur');
                });

                $('#request_id').change(function(){
                    var id = $(this).val(); 
                    var company_detail = $('#company_detail');
                    var jenis_pengujian = $('#jenis_pengujian');
                    var sample_name = $('#sample_name');
                    var sample_number = $('#sample_number');
                    var sample_state = $('#sample_state');
                    var sample_receive_dt = $('#sample_receive_dt');
                    var start_test_dt = $('#start_test_dt');
                    var end_test_dt = $('#end_test_dt');
                    var testing_method = $('#testing_method');
                    var testing_result = $('#testing_result');
                    // var notes = $('#textarea_notes');

                    company_detail.attr('readonly', true).val('');
                    jenis_pengujian.attr('readonly', true).val('');
                    sample_name.attr('readonly', true).val('');
                    sample_number.attr('readonly', true).val('');
                    sample_state.attr('readonly', true).val('');
                    sample_receive_dt.attr('readonly', true).val('');
                    start_test_dt.attr('readonly', true).val('');
                    end_test_dt.attr('readonly', true).val('');
                    testing_method.attr('readonly', true).val('');
                    testing_result.attr('readonly', true).val('');
                    mts.attr('disabled', true).attr('required', true).html('');
                    mts.append('<option value=\"\">Pilih No. Permohonan terlebih dahulu</option>');
                    // notes.summernote('disable');
                    // notes.summernote('code', '');

                    $.ajax({
                        url: '" . url('api/get_request_detail') . "',
                        data: { 
                            token: 'b0aab7cef76645cb040bc42eb38c7c23', 
                            id: id   
                        },
                        type: 'GET',
                        success: function(resp) { 
                            if(resp.api_status == 1 && resp.data) {
                                company_detail.attr('readonly', false).val(resp.data.company_detail);
                                jenis_pengujian.attr('readonly', false).val(resp.data.type);
                                sample_name.attr('readonly', false).val(resp.data.name);
                                sample_number.attr('readonly', false).val(resp.data.size + ' ' + (resp.data.unit_others ? resp.data.unit_others : (resp.data.unit ?? 'Satuan tidak ditemukan')));
                                sample_state.attr('readonly', false).val('Baik');
                                sample_receive_dt.attr('readonly', false).val(resp.data.received_at);
                                start_test_dt.attr('readonly', false).val(resp.data.start_test_at);
                                end_test_dt.attr('readonly', false).val(resp.data.end_test_at);
                                testing_method.attr('readonly', false).val(resp.data.metode_pengujian);
                                testing_result.attr('readonly', false).val();
                                // notes.summernote('enable')
                                // notes.summernote('pasteHTML', resp.data.notes);
                                // notes.val(resp.data.notes);

                                $.each(resp.data.mts, function(k, v) {
                                    var newOpt = `
                                        <option value=\"` + v.id + `\">` + v.name + `</option>
                                    `;
        
                                    mts.append(newOpt);
                                });

                                mts.attr('disabled', false).removeAttr('readonly').select2()
                            }
                        }
                    });
                });

                // $('#form').on('submit', function(e) {
                //     e.preventDefault();
                //     var notes = $('#textarea_notes');
                //     console.log(notes.val());

                //     var ori_notes = $('#notes');
                //     console.log(ori_notes.val());

                // });
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
        if (in_array(Cx::myPrivilegeId(), [3])) {
            $query->where('mts', Cx::myId());
        }
        //Your code here
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
        $postdata['id_cms_staffs'] = Cx::myId();
        if($postdata['mts']) {
            $user = User::find($postdata['mts']);
            $postdata['mts_nip'] = ($user->nip ?? "NIP BELUM ADA");
        }

        // dd($postdata, $_POST);
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
        if ($postdata['request_id'] == "")
            unset($postdata['request_id']);

        if($postdata['mts']) {
            $user = User::find($postdata['mts']);
            $postdata['mts_nip'] = ($user->nip ?? "NIP BELUM ADA");
        }

        if($postdata['pdf']) {
            $postdata['status'] = "LHP Selesai";
            $postdata['finish_at'] = now();

            $lhp = DB::table('data_lhp')->find($id);

            $request = DB::table('requests')->where('id', $lhp->request_id);
            
            $user = DB::table('cms_users')->find($request->id_cms_users);

            #Notifikasi Email
            $mail = [
                'email' => $user->email,
                'name' => $user->name,
                'document_no' => $request->first()->document_no,
                'status' => 'LHP Selesai',
                'notes' => "Pelanggan yang terhormat, terima kasih telah memilih pengujian di BPMPT. Kami berkomitmen menjaga dan meningkatkan pelayanan berkelanjutan untuk memenuhi harapan dan kepuasan untuk pelanggan. Untuk itu silahkan mengisi survei kepuasaan pelanggan melalui baris data permohonan Anda yang telah selesai agar dapat mengunduh LHP yang telah diterbitkan.<br><br>Saran dan Kritik serta Pengaduan dapat disampaikan pada menu yang tersedia pada Dashboard SI JITU. Mohon turut serta mengisi IKM Online pada link berikut ini : <a href='http://ikm.pertanian.go.id/?u=BD#'>Klik Disini</a>.",
                'template' => 'new_updates',
            ];

            $request->update([
                'status' => 'LHP Selesai',
                'lhp_file' => $postdata['pdf'],
                'finish_at' => now()
            ]);

            $job = new SendMail($mail);
            dispatch($job);

            DB::table('histories')->insert([
                'id_cms_users' => Cx::myId(),
                'request_id' => $id,
                'notes' => "Menerbitkan LHP dan merubah permohonan menjadi Selesai",
                'updated_at' => now()
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
    public function getSetAccept($id) {
        $lhp = DB::table('data_lhp')->whereId($id);
        
        $lhp->update([
            'verified_at' => now(),
            'status' => 'Sudah Diverifikasi',
        ]);

        Cx::redirect(Cx::mainPath(), "Draft LHP berhasil diverifikasi!","success");
    }

    public function getSetDraftLhp($id)
    {
        
        $data = DB::table('data_lhp')->whereId($id)->first();
        $data->mt = User::find($data->mts);

        // dd(trim(str_replace("\r\n", " \line", $data->testing_result)));

        $array = array(
			'[lhp_no]' => $data->lhp_no,
			'[company_detail]' => str_replace("\r\n", "\line ", $data->company_detail),
			'[sample_name]' => $data->sample_name,
			'[sample_number]' => $data->sample_number,
			'[sample_state]' => $data->sample_state,
			'[sample_receive_dt]' => \Carbon\carbon::parse($data->sample_receive_dt)->translatedFormat('l, d F Y'),
			'[testing_dt]' => \Carbon\carbon::parse($data->start_test_at)->translatedFormat('d F Y') . ' s/d ' . \Carbon\carbon::parse($data->end_test_at)->translatedFormat('d F Y'),
			'[testing_method]' => $data->testing_method,
			'[testing_result]' => trim(str_replace("\r\n", "\line ", $data->testing_result)),
			'[created_at]' => \Carbon\carbon::parse($data->created_at)->translatedFormat('d F Y'),
			'[mt_name]' => $data->mt->name,
			'[mt_nip]' => $data->mt->nip ?? "** BELUM DIUPDATE **",
		);

        return \WordTemplate::export(public_path('lhp_template.rtf'), $array, 'lhp_' . $data->lhp_no . '.doc');
    }

    // public function getUploadPdf($id) {
    //     $lhp = DB::table('data_lhp')->whereId($id);
        
    //     $lhp->update([
    //         'file' => now(),
    //         'status' => 'Sudah Diverifikasi',
    //     ]);

    //     Cx::redirect(Cx::mainPath(), "Draft LHP berhasil diverifikasi!","success");
    // }
}
