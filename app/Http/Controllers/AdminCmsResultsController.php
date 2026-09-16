<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Cx;
use crocodicstudio\crudbooster\controllers\CBController;
use Avatar;

class AdminCmsResultsController extends CBController
{
    public function cbInit()
    {
        Cx::redirect(Cx::adminPath(), "Mohon maaf masih tahap pengembangan!","warning");
        die;
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table               = 'cms_users';
        $this->primary_key         = 'id';
        $this->title_field         = "name";
        $this->button_action_style = 'button_icon';
        $this->button_import 	   = false;
        $this->button_export 	   = false;
        $this->orderby 	           = 'id,asc';
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
        $this->col[] = ["label"=>"Nama","name"=>"name"];
        $this->col[] = ["label"=>"Hak","name"=>"id_cms_privileges","join"=>"cms_privileges,name", "callback" => function ($q) {
            return $q->cms_privileges_name ?? '-';
        }];
        $this->col[] = ["label"=>"Email","name"=>"email"];
        // $this->col[] = ["label"=>"No. HP","name"=>"phone"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label"=>"Nama","name"=>"name", "type" => "text", 'validation'=>'required|string|min:3|max:50|unique:cms_users,name'];
        $this->form[] = ["label"=>"Email","name"=>"email",'type'=>'email','validation'=>'required|email|max:75|unique:cms_users,email'];
        
        if(Cx::myPrivilegeId() == 5) {
            $this->form[] = ["label"=>"No. WhatsApp","name"=>"phone",'type'=>'number','validation'=>'required|numeric|regex:/^08[0-9]{8,11}$/|unique:cms_users,phone','help'=>'Dimulai dari 08XXXXXXXXXX, Contoh: 081612341234'];
            $this->form[] = ["label"=>"Alamat","name"=>"address",'type'=>'textarea','validation'=>'required|string|min:0|max:255','help'=>'Mohon isi alamat sedetil mungkin', 'placeholder' => "Jl XXX No. 99 RT 01/02, Bantarjati, Kec. Bogor Utara, Kota Bogor, Jawa Barat 16152"];
        }
        
        $this->form[] = ["label"=>"Password","name"=>"password","type"=>"password","help"=>"Kosongkan jika tidak ada perubahan"];
        $this->form[] = ["label"=>"Password Confirmation","name"=>"password_confirmation","type"=>"password","help"=>"Kosongkan jika tidak ada perubahan"];
        # END FORM DO NOT REMOVE THIS LINE

        $this->table_row_color = [];
        $this->table_row_color[] = ["condition" => "[status] == 'Inactive'", "color" => "danger"];
        $this->table_row_color[] = ["condition" => "[status] == 'Active'", "color" => "success"];
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

    public function hook_before_edit(&$postdata, $id)
    {
        unset($postdata['password_confirmation']);
    }

    public function hook_before_add(&$postdata)
    {
        $postdata['id_cms_privileges'] = 1;
        $postdata['status'] = 'Active';
        unset($postdata['password_confirmation']);
    }

    public function hook_query_index(&$query)
    {
        $query->where('id_cms_privileges', 1);
    }
}
