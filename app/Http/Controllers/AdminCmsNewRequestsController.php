<?php namespace App\Http\Controllers;

    use Session;
    use Request;
    use DB;
    use Cx;
    use Carbon;
    
    class AdminCmsNewRequestsController extends \crocodicstudio\crudbooster\controllers\CBController
    {
        public function cbInit()
        {

            # START CONFIGURATION DO NOT REMOVE THIS LINE
            $this->title_field = "id";
            $this->limit = "100";
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
            $this->table = "requests";
            # END CONFIGURATION DO NOT REMOVE THIS LINE

            # START COLUMNS DO NOT REMOVE THIS LINE
            $this->col = [];
            # END COLUMNS DO NOT REMOVE THIS LINE

            # START FORM DO NOT REMOVE THIS LINE
            $this->form = [];
            $enum = DB::table('parameters')->select('type')->groupBy('type')->get()->pluck('type')->map(function($q) {
                return trim($q);
            })->toArray();

            $this->form[] = ['label'=>'Tgl. Permohonan','name'=>'created_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s', "value" => now(), "exception" => true, "disabled" => true];
            $this->form[] = ['label'=>'Jenis Pengujian','name'=>'type','type'=>'select2','validation'=>'required|string|min:1|max:100|exists:parameters,type', 'dataenum' => implode(";", (array) $enum)];
            $this->form[] = ['label'=>'Nama Contoh','name'=>'name','type'=>'text','validation'=>'required|string|min:1|max:255', 'placeholder' => 'Masukkan nama contoh'];
            $this->form[] = ['label'=>'Surat Permohonan','name'=>'file_1','type'=>'upload','validation'=>'required|mimes:pdf|max:1000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 1MB"];
            $this->form[] = ["label"=>" ","name"=>"custom_field","type"=>"custom","html"=>"
            <embed id='file_1_preview' type='application/pdf' width='300' style='display: none;' />
            ", "exception" => true, "disabled" =>true];
            
            $this->form[] = ['label'=>'Foto Contoh','name'=>'photo_1','type'=>'upload','validation'=>'required|mimes:jpg,jpeg,png|max:5000', "upload_encrypt" => true, "help" => "Jenis file merupakan JPG/JPEG/PNG, dengan maksimal ukuran 5MB"];
            $this->form[] = ["label"=>" ","name"=>"custom_field","type"=>"custom","html"=>"
            <a data-lightbox='roadtrip' href='" . asset('assets/images/no-image.png') . "' style='display: none;'>
                <img id='photo_1_preview' src='" . asset('assets/images/no-image.png') . "' alt='Foto Sampel' style='width: 200px'>
            </a>
            ", "exception" => true, "disabled" =>true];

          
            
            $this->form[] = ['label'=>'Satuan','name'=>'unit','type'=>'select2','validation'=>'required|string|min:1|max:15', "dataenum" => "gr;kg;ml;liter;Lainnya"];
            $this->form[] = ['label'=>'Satuan Lainnya','name'=>'unit_others','type'=>'text','validation'=>'required|string|min:1|max:15', "placeholder" => "Masukkan satuan lainnya"];
            $this->form[] = ['label'=>'Volume/Berat Contoh','name'=>'size','type'=>'money','validation'=>'required|integer|min:0', 'placeholder' => "Masukkan nilai volume/berat dari sampel yang akan dikirim"];
            $this->form[] = ["label"=>" ","name"=>"custom_field","type"=>"custom","html"=>"
            <img src='" . asset('assets/images/persyaratan.png') . "' width='50%'>
            ", "exception" => true, "disabled" =>true];

            $allParameters = DB::table("parameters")->orderBy('type', 'asc')->orderBy('parameter', 'asc')->orderBy('price', 'asc')->get();
            $select_parameter_uji = view('select_parameter_uji', compact('row', 'allParameters'))->render();
            $this->form[] = ['label'=>'Pilih Parameter Uji','name'=>'testings','type'=>'custom', 'html' => $select_parameter_uji];

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

            $this->alert[] = ["type" => "white", "message" => "
                <h4>Catatan</h4>
                <ol>
                    <li>Apabila terjadi pembatalan pengujian oleh pelanggan, maka biaya pengujian yang sudah disetorkan tidak dapat ditarik kembali.</li>
                    <li>Pengujian contoh akan diproses setelah kami menerima biaya pengujian contoh yang disetorkan oleh pelanggan.</li>
                    <li>Perkiraan waktu penyelesaian pengujian dihitung dari sejak proses pengujian dimulai (di luar waktu preparasi contoh) dan dapat berubah apabila terjadi hal-hal di luar kemampuan Laboratorium Kimia Agro.</li>
                    <li>Laboratorium dapat menyampaikan informasi rahasia terkait data pengujian/pelanggan apabila dipersyaratkan oleh undang-undang/hukum, dengan terlebih dahulu memberitahukan kepada pelanggan tersebut.</li> 
                </ol>
            "];

            $this->alert[] = ["type" => "white", "message" => "
                <p class='text-success' style='font-weight: 500'>
                    Periksa kembali dan pastikan data yang diisi sudah benar! Kesalahan pada Laporan Hasil Pengujian (LHP) bukan tanggung jawab dari Satuan Pelayanan Laboratorium Kimia Agro.
                </p>
            "];



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
            $this->table_row_color[] = ["condition" => "[status] == 'Inactive'", "color" => "danger"];
            $this->table_row_color[] = ["condition" => "[status] == 'Active'", "color" => "success"];
            

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
                var allParameters = " . json_encode($allParameters) . ";

                var unit = $('#unit');    
                var unit_others = $('#unit_others');  
                
                if(unit.val() == '') {
                    unit_others.parent().parent().hide(); 
                    unit_others.attr('required', false);
                }
                
                unit.on('change', function(){
                    var val = $(this).val(); 
                    unit_others.parent().parent().hide(); 
                    unit_others.attr('required', false);

                    if(val == 'Lainnya'){
                        unit_others.parent().parent().show(); 
                        unit_others.attr('required', true);
                    }
                });

                var photo_1 = $('#photo_1');
                photo_1.on('change', function(){
                    $('#photo_1_preview').parent().attr('style', 'display: none');
                    var oFReader = new FileReader();

                    if(document.getElementById('photo_1').files[0]) {
                        if(
                            document.getElementById('photo_1').files[0].type == 'image/jpeg' ||
                            document.getElementById('photo_1').files[0].type == 'image/jpg' ||
                            document.getElementById('photo_1').files[0].type == 'image/png'
                        
                        ) {
                            oFReader.readAsDataURL(document.getElementById('photo_1').files[0]);
                            oFReader.onload = function (oFREvent) {
                                document.getElementById('photo_1_preview').src = oFREvent.target.result;
                                $('#photo_1_preview').parent().attr('href', oFREvent.target.result);
                                $('#photo_1_preview').parent().attr('style', '');
                            };
                        }
                        else {
                            $('#photo_1').val('');
                            alert('Hanya menerima file Gambar JPG/JPEG/PNG!');
                        }
                    }
                });

                var file_1 = $('#file_1');
                file_1.on('change', function(e){
                    $('#file_1_preview').attr('style', 'display: none');
                    if(e.target.files[0]) {
                        if(e.target.files[0].type == 'application/pdf') {
                            var src = URL.createObjectURL(e.target.files[0])
                            $('#file_1_preview')
                                .attr('src', src)
                                .attr('style', ''); 
                        }
                        else {
                            $('#file_1').val('');
                            alert('Hanya menerima file PDF!');
                        }
                    }

                });

                

                $('#type').on('change', function() {
                    var nilai = $(this).val();
                    var parameterChooserWrapper = $('.parameterChooserWrapper');
                    var emptyWrapper = $('#emptyWrapper');

                    emptyWrapper.show();
                    parameterChooserWrapper.hide();

                    if(nilai) {
                        $('.parameterChild').each(function(){
                            $(this).hide();

                            if($(this).data('group') == nilai)
                                $(this).show();
                        });

                        emptyWrapper.hide();
                        parameterChooserWrapper.show();                        
                    }
                });

                $('.inputParams').on('change', function() {
                    recalc();
                });

                
                function recalc() {
                    var tot = 0;
                    var inputTotal = $('input[name=total]');
                    var inputTotalText = $('#totalText');
                    
                    $('.inputParams').each(function() {
                        if($(this).is(':checked')) {
                            tot = tot + $(this).data('price') - 0;
                        }
                    });

                    inputTotal.val(tot)
                    inputTotalText.html(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0}).format(tot).replace('Rp', '').trim())
                }
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
            //Your code here
            // if (Cx::me()->platform) {
            //     $platforms = explode(";", Cx::me()->platform);
            //     $query->whereIn('category', $platforms);
            // }
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
            $lastID = DB::table('requests')
                ->whereYear('created_at', Carbon::now()->format('Y'))
                ->where('type', $postdata['type'])
                ->orderBy('id', 'desc')
                ->count();

            $m = Carbon::now()->format("m");
            $y =  Carbon::now()->format("Y");
            $code = "";

            #Mutu Pestisida;Residu Pestisida;Pupuk Organik;Pupuk Anorganik;Tanah;Air Irigasi;Mutu Produk Tanaman
            switch($postdata['type']){
                case 'Mutu Pestisida' : 
                    $code = "M";
                    $lastID = $lastID; 
                break;
                case 'Residu Pestisida' : 
                    $code = "R"; 
                    $lastID = $lastID; 
                break;
                case 'Pupuk Organik' : 
                    $code = "PO"; 
                    $lastID = $lastID; 
                break;
                case 'Pupuk Anorganik' : 
                    $code = "PA"; 
                    $lastID = $lastID; 
                break;
                case 'Tanah' : 
                    $code = "T"; 
                    $lastID = $lastID; 
                break;
                case 'Air Irigasi' : 
                    $code = "AI"; 
                    $lastID = $lastID; 
                break;
                case 'Mutu Produk Tanaman' : 
                    $code = "MPT"; 
                    $lastID = $lastID; 
                break;
                default: $code = "";
            }
            $lastID = sprintf("%04d", $lastID+=1);

            $postdata['document_no'] = "{$lastID}.{$code}.{$m}.{$y}";
            $postdata['id_cms_users'] = Cx::myId();
            $postdata['updated_at'] = now();

            $params = [];
            foreach($postdata['testings'] as $test) {
                $parameter = DB::table('parameters')->find($test);
                $params[] = [
                    'id' => (int) $parameter->id,
                    'parameter' => $parameter->parameter,
                    'harga_text' => "Rp " . number_format($parameter->price, 2, ",", "."),
                    'harga' => (int) $parameter->price,
                    'noik' => $parameter->noik ?? '-',
                    'status' => "Menunggu Tindakan",
                ];
            }
            $postdata['testings'] = json_encode($params);
            $postdata['total'] = $_POST['total'];
            $postdata['param_ready'] = 1;
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
            DB::table('histories')->insert([
                'id_cms_users' => Cx::myId(),
                'request_id' => $id,
                'notes' => "Membuat permohonan baru"
            ]);

            Cx::redirect(Cx::adminPath('requests'), "Permohonan Anda berhasil dibuat, silahkan lengkapi data terlebih dahulu!","success");

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
    }
