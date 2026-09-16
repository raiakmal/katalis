<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use Cx;
use crocodicstudio\crudbooster\controllers\CBController;
use Avatar;

class AdminCmsAdminsController extends CBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table               = 'cms_users';
        $this->primary_key         = 'id';
        $this->title_field         = "name";
        $this->button_action_style = 'button_icon';
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
        $this->form[] = ['label'=>'Jenis Pengujian','name'=>'platform','type'=>'checkbox','validation'=>'max:255','dataenum'=>'Mutu Pestisida;Residu Pestisida;Pupuk Organik;Pupuk Anorganik;Tanah;Air Irigasi;Mutu Produk Tanaman'];
        $this->form[] = ["label"=>"Password","name"=>"password","type"=>"password", "required" => request()->segment(3) == 'add' ? true : false, "placeholder"=> request()->segment(3) <> 'add' ? "Kosongkan jika tidak ada perubahan" : "Masukkan kata sandi"];
        $this->form[] = ["label"=>"Password Confirmation","name"=>"password_confirmation", "required" => request()->segment(3) == 'add' ? true : false, "type"=>"password", "placeholder"=>request()->segment(3) <> 'add' ? "Kosongkan jika tidak ada perubahan" : "Masukkan ulang kata sandi"];
        $this->form[] = ['label'=>'Status','name'=>'status','type'=>'select2','validation'=>'required|min:1|max:10','dataenum'=>'Active;Inactive', 'value' => 'Active'];

        # END FORM DO NOT REMOVE THIS LINE

        $this->table_row_color = [];
        $this->table_row_color[] = ["condition" => "[status] == 'Inactive'", "color" => "danger"];
        $this->table_row_color[] = ["condition" => "[status] == 'Active'", "color" => "success"];
    }

    public function hook_before_edit(&$postdata, $id)
    {
        unset($postdata['password_confirmation']);
    }

    public function hook_before_add(&$postdata)
    {
        $postdata['status'] = 'Active';
        $postdata['id_cms_privileges'] = 6;
        unset($postdata['password_confirmation']);
    }

    public function hook_query_index(&$query)
    {
        $query->whereIn('id_cms_privileges', [6]);
    }
}
