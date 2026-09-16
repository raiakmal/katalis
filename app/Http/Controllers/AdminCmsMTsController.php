<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Cx;
use crocodicstudio\crudbooster\controllers\CBController;
use Avatar;

class AdminCmsMTsController extends CBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table               = 'cms_users';
        $this->primary_key         = 'id';
        $this->title_field         = "name";
        $this->button_action_style = 'button_icon';
        $this->button_addmore 	   = false;
        $this->button_import 	   = false;
        $this->button_export 	   = false;
        $this->orderby 	           = 'name,asc';
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
        $this->col[] = ["label"=>"NIP","name"=>"nip", "callback_php" => '$row->nip ?? "-"'];
        $this->col[] = ["label"=>"Nama","name"=>"name"];
        $this->col[] = ["label"=>"Email","name"=>"email"];
        $this->col[] = ["label"=>"Hak","name"=>"id_cms_privileges","join"=>"cms_privileges,name", "callback" => function ($q) {
            return $q->cms_privileges_name ?? '-';
        }];
        $this->col[] = ["label"=>"Jenis Pengujian","name"=>"platform", "callback" => function ($q) {
            $string = explode(";", $q->platform);
            return $q->platform ? implode("<br>", $string) : '-';
        }];
        $this->col[] = ["label"=>"Status","name"=>"status"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label"=>"NIP","name"=>"nip", "type" => "text", 'validation'=>'string|min:3|max:100|unique:cms_users,nip', 'placeholder' => 'Masukkan NIP'];
        $this->form[] = ["label"=>"Nama","name"=>"name", "type" => "text", 'validation'=>'required|string|min:3|max:50|unique:cms_users,name', 'placeholder' => 'Masukkan nama lengkap dan gelar'];
        $this->form[] = ["label"=>"Email","name"=>"email",'type'=>'email','validation'=>'required|email|max:75|unique:cms_users,email', 'placeholder' => 'Masukkan alamat email'];
        $this->form[] = ["label"=>"Hak","name"=>"id_cms_privileges","type"=>"select2",'validation'=>'required|integer|exists:cms_privileges,id',"datatable"=>"cms_privileges,name","datatable_where"=> "id IN (2,3,4)"];
        $this->form[] = ['label'=>'Jenis Pengujian','name'=>'platform','type'=>'checkbox','validation'=>'max:255','dataenum'=>'Mutu Pestisida;Residu Pestisida;Pupuk Organik;Pupuk Anorganik;Tanah;Air Irigasi;Mutu Produk Tanaman'];
        $this->form[] = ["label"=>"Password","name"=>"password","type"=>"password", "required" => request()->segment(3) == 'add' ? true : false, "placeholder"=> request()->segment(3) <> 'add' ? "Kosongkan jika tidak ada perubahan" : "Masukkan kata sandi"];
        $this->form[] = ["label"=>"Password Confirmation","name"=>"password_confirmation", "required" => request()->segment(3) == 'add' ? true : false, "type"=>"password", "placeholder"=>request()->segment(3) <> 'add' ? "Kosongkan jika tidak ada perubahan" : "Masukkan ulang kata sandi"];
        $this->form[] = ['label'=>'Status','name'=>'status','type'=>'select2','validation'=>'required|min:1|max:10','dataenum'=>'Active;Inactive', 'value' => 'Active'];

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
        $postdata['status'] = 'Active';
        unset($postdata['password_confirmation']);
    }

    public function hook_query_index(&$query)
    {
        $query->whereIn('id_cms_privileges', [2,3,4]);
    }
}
