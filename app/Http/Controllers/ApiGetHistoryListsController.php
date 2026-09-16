<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetHistoryListsController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {
				$this->table       = "histories";
				$this->permalink   = "get_history_lists";
				$this->method_type = "get";
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process

		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
		        //This method will be execute after run the main process
				$result['data'] = collect($result['data'])->map(function($q) {
					$q->created_at = \Carbon\carbon::parse($q->created_at)->translatedFormat('l, d/M/Y H:i');
					return $q;
				});

				return $result;
		    }

		}