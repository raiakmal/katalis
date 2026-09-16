<?php namespace App\Http\Controllers;

use App\Models\User;
use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetRequestDetailController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {
				$this->table       = "requests";
				$this->permalink   = "get_request_detail";
				$this->method_type = "get";
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process

		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
				$data = DB::table('requests')->where('id', $postdata['id'])->first();
				$user = User::find($data->id_cms_users);
				$isMou = $user->is_mou ? "Ya" : "Tidak";
				$isMhs = $user->category == "Mahasiswa" ? "Ya" : "Tidak";
				$data->company_detail = trim("{$user->company}
{$user->address}");

				$data->received_at = \Carbon\carbon::parse(DB::table('histories')->whereRequestId($data->id)->whereNotes('Menerbitkan billing')->first()->created_at)->format('Y-m-d');
				$data->start_test_at = \Carbon\carbon::parse(DB::table('histories')->whereRequestId($data->id)->where('notes', 'like', '%Menerima tugas untuk menguji parameter%')->first()->created_at)->format('Y-m-d');
				$data->end_test_at = \Carbon\carbon::parse(DB::table('histories')->whereRequestId($data->id)->whereNotes('Semua pengujian telah dilaporkan selesai oleh semua analis yang terlibat')->first()->created_at)->format('Y-m-d');
				
				
				$methods = [];
				$testings = json_decode($data->testings);
				foreach($testings as $test) {
					$methods[] = $test->metode;
				}
				$methods = implode(", ", $methods);
				$data->metode_pengujian = $data->noik . " / " . $methods;
				$data->mts = User::select('id', 'nip', 'name')->where('platform', 'like', '%' . $data->type . '%')->where('id_cms_privileges', 3)->whereStatus('Active')->get()->map(function ($q) {
					$q->name = ($q->nip ?? "NIP BELUM ADA") . " - " . $q->name;
					return $q;
				});
				$tpl = DB::table('template_lhp')->where('type', $data->type)->first();
				$data->notes = $tpl ? $tpl->content : "Template catatan tidak ada";

				$result['data'] = $data;
		    }

		}