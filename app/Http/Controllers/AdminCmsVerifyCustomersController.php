<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Cx;
use Carbon;
use crocodicstudio\crudbooster\controllers\CBController;
use Avatar;
use Exception;
use App\Jobs\SendMail;

class AdminCmsVerifyCustomersController extends CBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table               = 'cms_users';
        $this->primary_key         = 'id';
        $this->title_field         = "name";
        $this->button_action_style = 'button_icon';
        $this->button_import 	   = false;
        $this->button_export 	   = true;
        $this->button_add 	       = false;
        $this->button_detail 	   = false;
        $this->button_delete 	   = true;
        $this->orderby 	           = 'id,desc';
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label"=>"Photo","name"=>"photo","callback"=>function ($x) {
            $photo = Avatar::create($x->name);
            return '
            <a  data-lightbox="roadtrip" title="Photo: ' . $x->name . '" href="' . $photo . '">
                <img src="' . $photo . '" class="img-circle" alt="' . $x->name . '" width="40" height="40" />
            </a>';
        }];
        $this->col[] = ["label"=>"Tgl. Daftar","name"=>"created_at", "callback" => function($q){
            return Carbon::parse($q->created_at)->translatedFormat("d/M/Y H:i");
        }];
        $this->col[] = ["label"=>"Nama Pemohon/Instansi/Perusahaan","name"=>"company"];
        $this->col[] = ["label"=>"Provinsi","name"=>"id_cms_provinsis", "join" => "cms_provinsis,name"];
        $this->col[] = ["label"=>"Kota/Kab","name"=>"id_cms_kabupatens", "join" => "cms_kabupatens,name"];
        $this->col[] = ["label"=>"Alamat","name"=>"address", "callback" => function ($q) {
            return $q->address ? "<p style='width: 250px; white-space: break-spaces;'>$q->address</p>" : '-';
        }];
        $this->col[] = ["label"=>"Nama Penghubung","name"=>"name"];
        $this->col[] = ["label"=>"Kategori Pelanggan","name"=>"kategori"];
        $this->col[] = ["label"=>"Email","name"=>"email"];
        $this->col[] = ["label"=>"No. WhatsApp","name"=>"phone"];
        $this->col[] = ["label"=>"Status","name"=>"status"];
        // $this->col[] = ["label"=>"No. HP","name"=>"phone"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label"=>"Nama Pemohon/Instansi/Perusahaan","name"=>"company", "type" => "text", 'validation'=>'required|string|min:3|max:50|unique:cms_users,name', "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true];
        $this->form[] = ["label"=>"Provinsi","name"=>"id_cms_provinsis", "type" => "select", 'validation'=>'required|integer|exists:cms_provinsis,id', "datatable" => "cms_provinsis,name", "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true];
        $this->form[] = ["label"=>"Kota/Kab","name"=>"id_cms_kabupatens", "type" => "select", 'validation'=>'required|integer|exists:cms_kabupatens,id', "datatable" => "cms_kabupatens,name", "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true, "datatable_ajax" => 1, "parent_select" => "id_cms_provinsis"];
        
        $this->form[] = ['label'=>'Alamat','name'=>'address','type'=>'textarea','validation'=>'required|string|min:3|max:255', "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true];
        $this->form[] = ["label"=>"Nama Penghubung","name"=>"name", "type" => "text", 'validation'=>'required|string|min:3|max:50|unique:cms_users,name', "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true];
        $this->form[] = ['label'=>'Kategori Pelanggan','name'=>'kategori','type'=>'select2','validation'=>'required|string','dataenum'=>'Petani/Kelompok Tani/Gapoktan;Mahasiswa;Universitas/Perguruan Tinggi;Instansi Terkait;Perusahaan Perorangan/Badan Usaha', 'value' => 'Perusahaan Perorangan/Badan Usaha'];
        $this->form[] = ["label"=>"Email","name"=>"email",'type'=>'email','validation'=>'required|email|max:75|unique:cms_users,email', "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true];
        $this->form[] = ['label'=>'No. WhatsApp','name'=>'phone','type'=>'number','validation'=>'required|numeric|regex:/^08[0-9]{8,11}$/','placeholder'=>'Dimulai dari 08XXXXXXXXXX, Contoh: 081612341234', "disabled" => Cx::isSuperAdmin() ? false : true, "exception" => Cx::isSuperAdmin() ? false : true];
        $this->form[] = ['label'=>'Pelanggan MoU','name'=>'is_mou','type'=>'select2','validation'=>'required|integer|in:0,1','dataenum'=>'1|Ya;0|Tidak', 'value' => ''];
        # END FORM DO NOT REMOVE THIS LINE

        $this->table_row_color = [];
        $this->table_row_color[] = ["condition" => "[status] == 'Inactive'", "color" => "danger"];
        $this->table_row_color[] = ["condition" => "[status] == 'Active'", "color" => "success"];

        if(in_array(Cx::myPrivilegeId(), [1,2])) {
            $this->addaction[] = ['label'=>'Verifikasi','url'=> Cx::mainpath('edit/[id]'),'icon'=>'fa fa-check','color'=>'primary','showIf'=>"[status] == 'Inactive'", 'confirmation' => true];
        }

        $this->script_js = "
            $(function(){
                $('.btn-edit').remove();

                $('input[name=submit]').val('Terima');
            });
        ";
    }

    public function getProfile()
    {
        $this->button_addmore = false;
        $this->button_cancel  = false;
        $this->button_show    = false;
        $this->button_add     = false;
        $this->button_delete  = false;
        $this->hide_form 	  = ['id_cms_privileges'];

        $data['page_title'] = cbLang("label_button_profile");
        $data['row']        = Cx::first('cms_users', Cx::myId());

        return $this->view('crudbooster::default.form', $data);
    }

    public function hook_before_add(&$postdata)
    {
        unset($postdata['password_confirmation']);
        $postdata['id_cms_privileges'] = 5;
        $postdata['status'] = 'Inactive';
    }

    public function hook_before_edit(&$postdata, $id)
    {
        unset($postdata['password_confirmation']);
    }

    public function hook_after_edit($id)
    {
        try {
            $rand_string = str_random(5);
            $password = \Hash::make($rand_string);
    
            $user = DB::table('cms_users')->find($id);
    
            #Notifikasi Email
            $mail = [
                'email' => $user->email,
                'name' => $user->name,
                'password' => $rand_string,
                'template' => 'register_account'
            ];

            $job = new SendMail($mail);
            dispatch($job);

            DB::table('cms_users')
            ->where('id', $id)
            ->update([
                'password' => $password,
                'status' => 'Active',
                'verified_at' => now(),
                'verifier' => Cx::myId(),
            ]);
            
            Cx::redirect(Cx::adminPath('customers'), "User bersangkutan berhasil diverifikasi!","info");
        }
        catch(Exception $e) {
            Cx::redirect(Cx::adminPath('verify-customers'), "Terjadi kesalahan sistem, mohon ulangi lagi.","warning");
        }
    }

    public function hook_query_index(&$query)
    {
        $query->where($this->table . '.id_cms_privileges', 5);
        $query->where($this->table . '.status', 'Inactive');
    }

}
