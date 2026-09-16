<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use Cx;
    use Carbon;

	class AdminCmsReportPNBPController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "500";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "audits";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];

			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Merchant Id","name"=>"merchant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"merchant,id"];
			//$this->form[] = ["label"=>"Project Id","name"=>"project_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"project,id"];
			//$this->form[] = ["label"=>"Note","name"=>"note","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			# OLD END FORM

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
	        $this->script_js = NULL;


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
	        $this->style_css = NULL;



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

        public function getIndex() {
            $now = Carbon::now()->format('Y');
            $max = 2021;
            $y = (request('y') && request('y') >= $max) ? request('y') : $now;

            // $types = DB::table('parameters')
            //     ->select('type', 'parameter')
            //     ->get()
            //     ->groupBy('type')
            //     ->mapWithKeys(function($q, $key) use($y){
            //         $requests = DB::table('requests')
            //             ->select(DB::raw('MONTH(paid_at) m'), 'testings')
            //             ->where('billing_file', '<>', null)
            //             ->where('paid_at', '<>', null)
            //             ->whereYear('paid_at', $y)
            //             ->where('type', $key)
            //             ->get();

                    
            //         $newData = [];
            //         foreach($requests as $req) {
            //             $m = Carbon::parse($req->paid_at)->format('n');
            //             $testings = json_decode($req->testings);
            //             foreach($testings as $test) {
            //                 $newData[$test->parameter][$m] += $test->harga;
            //             }
            //         }

            //         foreach($q as $y) {
            //             foreach($newData as $k => $new) {
            //                 dd($newData);
            //                 $keys = collect($k)->keys()->toArray();
            //                 dd($keys);
            //                 if(in_array($y->parameter, $keys)) {
            //                         $y->details = [
            //                             $k => $new[$y->parameter]
            //                         ];

            //                 }

            //             }
            //         } 

            //         dd($new);
                    
            //         $new = $q->filter(function($x) {
            //             return $x->details != null;
            //         });

            //         // $q->where('parameter') = $newData;
            //         return $new;
            //     })->values();
            // return ($types);
            $datas = DB::table('requests')
                ->select('type', DB::raw('MONTH(created_at) as m'), DB::raw('SUM(total) as total'))
                ->where('billing_file', '<>', null)
                ->where('paid_at', '<>', null)
                ->whereYear('paid_at', $now)
                ->groupBy('type', 'm')
                ->orderBy('m', 'asc')
                ->get();

            if(request('debug'))
                return $datas;

            return view('rekap-pnbp', compact('datas', 'y'));
        }

	}
