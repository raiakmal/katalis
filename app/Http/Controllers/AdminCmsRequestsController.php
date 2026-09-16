<?php namespace App\Http\Controllers;

use CRUDBooster;
use Log;
use Session;
use Request;
use DB;
use Cx;
use Carbon;
use Exception;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendMail;

class AdminCmsRequestsController extends \crocodicstudio\crudbooster\controllers\CBController
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
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = false;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "requests";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label"=>"Status","name"=>"status"];
        $this->col[] = ["label"=>"Tgl. Permohonan","name"=>"created_at", "callback" => function($q){
            return Carbon::parse($q->created_at)->translatedFormat("d/M/Y H:i");
        }];

        $this->col[] = ["label"=>"Tgl. Bayar","name"=>"paid_at", "callback" => function($q){
            return $q->paid_at ? Carbon::parse($q->paid_at)->translatedFormat("d/M/Y H:i") : "-";
        }];

        $this->col[] = ["label"=>"No. Permohonan","name"=>"document_no", "callback_php" => '$row->document_no ?? "-"'];
        $this->col[] = ["label"=>"Tgl. Perkiraan Selesai","name"=>"estimation_dt", "callback" => function($q){
            return $q->estimation_dt ? Carbon::parse($q->estimation_dt)->translatedFormat("d/M/Y") : "-";
        }];
        $this->col[] = ["label"=>"Is MOU","name"=>"id_cms_users", "join" => "cms_users,is_mou", "visible" => false];

        if(!in_array(Cx::myPrivilegeId(), [3, 5])) {
            $this->col[] = ["label"=>"Pemohon","name"=>"id_cms_users", "callback" => function($q){
                $user = DB::table("cms_users")->find($q->id_cms_users);
                $mou = $user->is_mou ? 'Ya' : 'Tidak';

                $string = "<div style='width: 350px; white-space:pre-wrap;'>";
                $string .= "Nama Perusahaan: <b>{$user->company}</b><br>";
                $string .= "Alamat Perusahaan: <b>{$user->address}</b><br>";
                $string .= "Nama Penghubung: <b>{$user->name}</b><br>";
                $string .= "Email: <b>{$user->email}</b><br>";
                $string .= "No. WhasApp: <b>{$user->phone}</b><br>";
                $string .= "Pelanggan MoU: <b>{$mou}</b>";
                $string .= "</div>";
                return $string;
            }];
        }

        $this->col[] = ["label"=>"Jenis Pengujian","name"=>"type", "callback_php" => '$row->type ?? "-"'];
        $this->col[] = ['label'=>'Nama Sampel','name'=>'name', "callback_php" => '$row->name ?? "-"'];
        $this->col[] = ["label"=>"Foto Sample","name"=>"photo_1", "image" => true];
        $this->col[] = ["label"=>"Param Ready?","name"=>"param_ready", "visible" => false];
        $this->col[] = ["label"=>"Unit","name"=>"unit", "visible" => false];
        $this->col[] = ["label"=>"Unit Others","name"=>"unit_others", "visible" => false];
        $this->col[] = ["label"=>"Invoice File","name"=>"billing_file", "visible" => false];
        $this->col[] = ["label"=>"Report File","name"=>"report_file", "visible" => false];
        $this->col[] = ["label"=>"Questioner Status","name"=>"questioner_status", "visible" => false];
        $this->col[] = ["label"=>"LHP File","name"=>"lhp_file", "visible" => false];
        $this->col[] = ["label"=>"Volume/Berat","name"=>"size", "callback" => function($q){
            $size = number_format($q->size);
            $others = $q->unit_others;
            $unit = $q->unit;
            if($others) $unit = $others . " (Lainnya)";
            return "{$size} {$unit}";
        }];

        if(in_array(Cx::myPrivilegeId(), [1,6])) {
            $this->col[] = ["label"=>"Surat Permohonan (PDF)","name"=>"file_1", "callback" => function($q){
                return $q->file_1 ? "<a href='" . url($q->file_1) . "' download><i class='fas fa-paperclip'></i> Unduh</a>" : "-";
            }];
        }

        // Tampilan Rincian Biaya (Awal vs Tambahan)
        $this->col[] = ["label"=>"Rincian Biaya","name"=>"total", "callback" => function($q) {
            if ($q->status == "Permohonan Dibatalkan") return "-";
            else if($q->param_ready == 1) {
                $text = "Rp ". number_format($q->total);
                if (preg_match('/Total Biaya Awal: Rp ([\d,]+)/', $q->notes, $matches)) {
                    $totalAwal = (int)str_replace(',', '', $matches[1]);
                    if ($q->total > $totalAwal) {
                        $selisih = $q->total - $totalAwal;
                        $text = "<div style='white-space:nowrap'>Biaya Awal: Rp " . number_format($totalAwal) . "<br>Tambahan: Rp " . number_format($selisih) . "<br><b>Total Akhir: Rp " . number_format($q->total) . "</b></div>";
                    }
                }
                return $text;
            }
            return "<b>Mohon isi parameter uji terlebih dahulu!</b>";
        }];
        
        $this->col[] = ["label"=>"Catatan / Info","name"=>"notes", "callback" => function ($q) {
            return $q->notes ? "<p style='width: 250px; white-space: break-spaces;'>$q->notes</p>" : '-';
        }];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];   
        if(Cx::myPrivilegeId() == 2 && (!request('type') || !in_array(request('type'), ["handling", "lhp", "renew-lhp", "renew-billing"])) && request()->segment(3) == 'edit') {
            Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning");
        }

        if((request('type') || request('ref_parameter')) && in_array(request()->segment(3), ['edit', 'edit-save'])) {
            $this->form[] = ['label'=>'No. Permohonan','name'=>'document_no','type'=>'text','disabled'=> true, 'exception' => true];
            $this->form[] = ['label'=>'Status Terakhir','name'=>'status','type'=>'text','disabled'=> true, 'exception' => true];
           
            if ((request('type') == "handling" || request('ref_parameter') == "type=handling") && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->form[] = ['label'=>'Invoice Awal (PDF)','name'=>'billing_file','type'=>'upload','validation'=>'required|mimetypes:application/octet-stream,application/pdf|max:2000', "upload_encrypt" => true, "help" => "Upload dokumen tagihan awal. Total biaya otomatis ditarik dari parameter uji."];
            }
            else if ((request('type') == "lhp" || request('ref_parameter') == "type=lhp") && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->form[] = ['label'=>'LHP','name'=>'lhp_file','type'=>'upload','validation'=>'required|mimetypes:application/octet-stream,application/pdf|max:5000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 5MB"];
            }
            else if (request('type') == "renew-lhp" || request('ref_parameter') == "type=renew-lhp" && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->form[] = ['label'=>'LHP Baru','name'=>'lhp_file_renew','type'=>'upload','validation'=>'required|mimetypes:application/octet-stream,application/pdf|max:5000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 5MB"];
            }
            else if (request('type') == "renew-billing" || request('ref_parameter') == "type=renew-billing" && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->form[] = ['label'=>'Invoice Tambahan (PDF)','name'=>'billing_file_renew','type'=>'upload','validation'=>'required|mimetypes:application/octet-stream,application/pdf|max:2000', "upload_encrypt" => true, "help" => "Upload jika terdapat penambahan parameter. Sistem otomatis menagihkan selisih biayanya."];
            }
            else if ((request('type') == "questioner" || request('ref_parameter') == "type=questioner") && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->page_title = "Masukkan";
                $ratings = view('ratings')->render();
                $this->form[] = ["label"=>"Penilaian","name"=>"rating","type"=>"custom","html"=>$ratings, 'validation' => 'required'];
                $this->form[] = ['label'=>'Masukkan/Saran/Kritik','name'=>'notes','type'=>'textarea', 'validation' => 'min:0|max:10000', "placeholder" => "Tuliskan masukan, saran maupun kritik untuk lebih meningkatkan pelayanan pengujian"];
            }
            else if ((request('type') == "update-finish-date" || request('ref_parameter') == "type=update-finish-date") && in_array(request()->segment(3), ['edit', 'edit-save'])) {
                $this->form[] = ['label'=>'Tgl. Perkiraan Waktu Selesai Pengujian','name'=>'estimation_dt','type'=>'date','validation'=>'required|date_format:Y-m-d'];
            }
        }
        else {
            $enum = DB::table('parameters')->select('type')->groupBy('type')->get()->pluck('type')->map(function($q) {
                return trim($q);
            })->toArray();
            $this->form[] = ['label'=>'Tgl. Permohonan','name'=>'created_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s', "value" => now(), "exception" => true, "disabled" => true];
            $this->form[] = ['label'=>'Jenis Pengujian','name'=>'type','type'=>'select2','validation'=>'required|string|min:1|max:100|exists:parameters,type', 'dataenum' => implode(";", (array) $enum)];
            $this->form[] = ['label'=>'Nama Sampel','name'=>'name','type'=>'text','validation'=>'required|string|min:1|max:100', 'placeholder' => 'Masukkan nama sampel'];
            
            if (in_array(Cx::myPrivilegeId(), [1,6])) {
                $this->form[] = ['label'=>'Surat Permohonan','name'=>'file_1','type'=>'upload','validation'=>'required|mimetypes:application/octet-stream,application/pdf|max:1000', "upload_encrypt" => true, "help" => "Jenis file merupakan PDF, dengan maksimal ukuran 1MB"];
            }
            $this->form[] = ['label'=>'Foto Sampel','name'=>'photo_1','type'=>'upload','validation'=>'required|mimes:jpg,jpeg,png|max:5000', "upload_encrypt" => true, "help" => "Jenis file merupakan JPG/JPEG/PNG, dengan maksimal ukuran 5MB"];
            $this->form[] = ['label'=>'Volume/Berat','name'=>'size','type'=>'money','validation'=>'required|integer|min:0'];
            $this->form[] = ['label'=>'Satuan','name'=>'unit','type'=>'select2','validation'=>'required|string|min:1|max:15', "dataenum" => "g;kg;ml;liter;Lainnya"];
            $this->form[] = ['label'=>'Satuan Lainnya','name'=>'unit_others','type'=>'text','validation'=>'required|string|min:1|max:15', "placeholder" => "Masukkan satuan lainnya"];
            
            if(request()->segment(3) == "detail") {
                $this->form[] = ['label'=>'Status Terakhir','name'=>'status','type'=>'text','disabled'=> true, 'exception' => true];
            }
        }
        # END FORM DO NOT REMOVE THIS LINE

        $this->sub_module = array();
        
        // =========================================================
        // PENGATURAN TOMBOL AKSI KUSTOM
        // =========================================================
        $this->addaction = array();

        $this->addaction[] = [
            "label" => "Bayar Online",
            "url" => Cx::mainPath("pay/[id]"),
            "icon" => "fa fa-credit-card",
            "color" => "success",
            "showIf" => "([status] == 'Menunggu Pembayaran' || [status] == 'Menunggu Pembayaran Tambahan')"
        ];

        if (in_array(Cx::myPrivilegeId(), [5, 3, 2, 1])) {
            $this->addaction[] = ["label" => "Kumpulan File", "url" => "javascript:modalFiles([id],\"[billing_file]\",\"[report_file]\",\"[lhp_file]\",\"[questioner_status]\")", "icon" => "fas fa-download", "color" => "primary", "showIf" => "([billing_file] <> NULL || [lhp_file] <> NULL) && in_array([status], ['Menunggu Pembayaran', 'Menunggu Pembayaran Tambahan', 'Siap Diuji', 'Pra Pengujian', 'Dalam Proses Pengujian', 'Proses Pembuatan LHP', 'LHP Selesai', 'Selesai'])"];
        }

        if(Cx::myPrivilegeId() == 5) {
            $this->addaction[] = ['label'=>'Batalkan','url'=> Cx::mainpath('set-cancel/[id]'),'icon'=>'fa fa-times','color'=>'danger','showIf'=>"[status] == 'Permohonan Baru'", 'confirmation' => true];
            $this->addaction[] = ['label'=>'Parameter Uji','url'=> Cx::mainpath('set-testings/[id]'),'icon'=>'fa fa-eye','color'=>'warning','showIf'=>"in_array([status], ['Permohonan Baru', 'Siap Diuji', 'Diajukan', 'Permohonan Ditolak', 'Menunggu Pengiriman Sampel', 'Menunggu Pembayaran', 'Siap Diuji', 'Pra Pengujian', 'Dalam Proses Pengujian', 'Proses Pembuatan LHP', 'LHP Selesai'])", 'confirmation' => true];
            $this->addaction[] = ['label'=>'Ajukan','url'=> Cx::mainpath('set-apply/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>'[status] == "Permohonan Baru" AND [param_ready] == 1', 'confirmation' => true];
            $this->addaction[] = ['label'=>'','url'=> Cx::mainpath('edit/[id]'),'icon'=>'fa fa-pencil-alt','color'=>'success','showIf'=>"[status] == 'Permohonan Baru'"];
        }

        if (Cx::myPrivilegeId() == 3) {
            $this->addaction[] = ['label'=>'Verifikasi','url'=> Cx::mainpath('set-testings/[id]'),'icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status] == 'Diajukan'"];
            $this->addaction[] = ['label'=>'Parameter Uji','url'=> Cx::mainpath('set-testings/[id]'),'icon'=>'fa fa-eye','color'=>'info','showIf'=>"[status] <> 'Siap Diuji' AND [status] <> 'Diajukan'"];
            $this->addaction[] = ['label'=>'Distribusi Tugas','url'=> Cx::mainpath('set-testings/[id]'),'icon'=>'fa fa-users','color'=>'success','showIf'=>"[status] == 'Siap Diuji'"];
        }

        if (Cx::myPrivilegeId() == 2) {
            $this->addaction[] = ['label'=>'Parameter Uji','url'=> Cx::mainpath('set-testings/[id]'),'icon'=>'fa fa-eye','color'=>'info'];
            
            $this->addaction[] = ['label'=>'Upload Invoice Awal','url'=> Cx::mainpath('edit/[id]?type=handling'),'icon'=>'fa fa-file-invoice','color'=>'success','showIf'=>"[status] == 'Menunggu Pengiriman Sampel' AND [billing_file] == NULL"];
            $this->addaction[] = ['label'=>'Upload Invoice Tambahan','url'=> Cx::mainpath('edit/[id]?type=renew-billing'),'icon'=>'fa fa-file-invoice-dollar','color'=>'warning','showIf'=>"[status] == 'LHP Selesai'"];
            
            $this->addaction[] = ['label'=>'Unggah LHP','url'=> Cx::mainpath('edit/[id]?type=lhp'),'icon'=>'fa fa-plus','color'=>'success','showIf'=>"[status] == 'Proses Pembuatan LHP'"];
            
            $this->addaction[] = ['label'=>'Verif Pemb. Awal','url'=> Cx::mainpath('set-payment-received/[id]'),'icon'=>'fa fa-check-double','color'=>'success','showIf'=>"[status] == 'Menunggu Pembayaran'", 'confirmation' => true];
            $this->addaction[] = ['label'=>'Verif Pemb. Tambahan','url'=> Cx::mainpath('set-payment-received/[id]'),'icon'=>'fa fa-check-double','color'=>'success','showIf'=>"[status] == 'Menunggu Pembayaran Tambahan'", 'confirmation' => true];
        }

        $this->addaction[] = ["label" => "Riwayat", "url" => "javascript:modalTimeline([id])", "icon" => "fas fa-clock", "color" => "primary"];
        
        $this->button_selected = array();
        $this->alert        = array();
        $this->index_button = array();

        $this->table_row_color = [];
        $this->table_row_color[] = ["condition" => "[status] == 'Permohonan Baru'", "color" => "warning"];
        $this->table_row_color[] = ["condition" => "[status] == 'Permohonan Dibatalkan'", "color" => "danger"];
        $this->table_row_color[] = ["condition" => "[status] == 'Diajukan'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Permohonan Ditolak'", "color" => "danger"];
        $this->table_row_color[] = ["condition" => "[status] == 'Menunggu Pengiriman Sampel'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Menunggu Pembayaran'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Menunggu Pembayaran Tambahan'", "color" => "warning"];
        $this->table_row_color[] = ["condition" => "[status] == 'Siap Diuji'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Pra Pengujian'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Dalam Proses Pengujian'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'Proses Pembuatan LHP'", "color" => "info"];
        $this->table_row_color[] = ["condition" => "[status] == 'LHP Selesai'", "color" => "success"];
        $this->table_row_color[] = ["condition" => "[status] == 'Selesai'", "color" => "success"];
        
        $this->index_statistic = array();

        $this->script_js = "
            $(function(){
                $('.btn-edit').remove();

                $(document).on('click', '.alert-questioner', function(){
                    var id = $(this).data('id');
                    new swal({
                        title: 'Silahkan isi Form Masukan & Pengaduan Terlebih Dahulu',
                        icon:'info',
                        showCancelButton:true,
                        allowOutsideClick:true,
                        confirmButtonColor: '#00a65a',
                        confirmButtonText: 'Isi Sekarang',
                        cancelButtonText: 'Batal',
                    }).then(function(result) {
                        var url = '" . Cx::mainPath('edit') . "/' + id + '?type=questioner';
                        if (result.isConfirmed) {
                            location.href = url;
                        }
                    });
                });
            });

            window.modalFiles = function(id, billing, report, lhp, q = false){
                var url = '" . url('/') . "';
                var modalFiles = $('#modalFiles');

                if(billing) {
                    modalFiles.find('#billingFile').attr('target', '_blank').attr('href', url + '/' + billing);
                } else {
                    modalFiles.find('#billingFile').parent().remove();
                }

                if(lhp) {
                    var privilegeId = '" . Cx::myPrivilegeId() . "';
                    q = privilegeId == 5 ? q : true;
                    if(q) {
                        modalFiles.find('#lhpFile').attr('target', '_blank').attr('href', url + '/' + lhp);
                    } else {
                        modalFiles.find('#lhpFile').attr('href', '#').attr('disabled', true).attr('data-id', id).addClass('alert-questioner');
                    }
                } else {
                    modalFiles.find('#lhpFile').parent().remove();
                }
                modalFiles.modal('show');
            }

            window.modalTimeline = function(id){
                var modalTimeline = $('#modalTimeline');
                modalTimeline.find('#data').html('Loading...');
                $.ajax({
                    url: '" . url('api/get_history_lists') . "',
                    data: { token: 'b0aab7cef76645cb040bc42eb38c7c23', request_id: id },
                    type: 'GET',
                    success: function(resp) { 
                        if(resp.api_status == 1 && resp.data.length > 0) {
                            var ul = modalTimeline.find('#data').html('').attr('class', 'timeline');
                            $.each(resp.data, function(k, v) {
                                var newLi = `<li><i class=\"fa fa-clock bg-green\"></i><div class=\"timeline-item\"><h5 class=\"no-border text-success\">` + v.created_at + `</h5><h3 class=\"timeline-header\">` + v.notes + `</h3></div></li>`;
                                ul.append(newLi);
                            });
                        } else {
                            modalTimeline.find('#data').html('<span class=\"text-danger\">Data tidak ditemukan...</span>');
                        }
                    }
                });
                modalTimeline.modal('show');
            }
        ";

        $this->pre_index_html = view('filter-permohonan')->render();
        $this->post_index_html = null;

        $this->modal_index_html = '
        <div class="modal fade" id="modalFiles" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fas fa-paperclip"></i> Kumpulan File</h4>
                    </div>
                    <div class="modal-body">
                        <table width="100%">
                            <tr>
                                <td width="50%" class="text-center">
                                    <a href="#" id="billingFile" class="btn btn-primary btn-lg">
                                        <i class="fas fa-download fa-2x"></i>
                                    </a>

                                    <h3>Invoice</h3>
                                </td>
                                <td width="50%" class="text-center">
                                    <a href="#" id="lhpFile" class="btn btn-primary btn-lg">
                                        <i class="fas fa-download fa-2x"></i>
                                    </a>
    
                                    <h3>Laporan Hasil Pengujian</h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTimeline" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fas fa-paperclip"></i> Riwayat Permohonan</h4>
                    </div>
                    <div class="modal-body">
                        <ul id="data" class="timeline" style="margin: 0">
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        ';

        $this->load_js = array();
        $this->style_css = ".modal-body { max-height: calc(100vh - 150px); overflow-y: auto; }";
        $this->load_css = array();
    }

    public function actionButtonSelected($id_selected, $button_name) {}

    public function getPay($id)
    {
        $request = DB::table('requests')->find($id);
        if (!$request) CRUDBooster::redirectBack("Data tidak ditemukan", "danger");

        preg_match_all('/https?:\/\/[^\s]+/', $request->notes, $matches);

        if (isset($matches[0]) && count($matches[0]) > 0) {
            $latestLink = end($matches[0]); // Ambil link yang ter-generate terakhir (Tahap 2 jika ada)
            return redirect()->away($latestLink);
        }

        CRUDBooster::redirectBack("Link pembayaran belum tersedia/kedaluwarsa.", "warning");
    }

    public function hook_query_index(&$query) {
        $privilegeName = CRUDBooster::myPrivilegeName();
        if ($privilegeName == 'Pelanggan') $query->where('requests.id_cms_users', CRUDBooster::myId());
        else $query->orderBy('requests.id', 'desc');
    }

    public function hook_row_index($column_index, &$column_value) {}
    public function hook_before_add(&$postdata) {}
    public function hook_after_add($id) {}

    public function hook_before_edit(&$postdata, $id)
    {
        $request = DB::table('requests')->find($id);
        $user = DB::table('cms_users')->find($request->id_cms_users);
        $reqType = request('type') ?: request('ref_parameter');

        // =========================================================================
        // SKENARIO 2: UPLOAD INVOICE TAMBAHAN (DIPRIORITASKAN)
        // LHP Selesai -> Selesai / Bayar Lagi
        // =========================================================================
        if (strpos($reqType, 'renew-billing') !== false || isset($postdata['billing_file_renew'])) {
            if (isset($postdata['billing_file_renew'])) {
                $postdata['billing_file'] = $postdata['billing_file_renew'];
                unset($postdata['billing_file_renew']);
            }
            
            $totalAkhir = (int)$request->total;
            $totalAwal = 0;

            if (preg_match('/Total Biaya Awal: Rp ([\d,]+)/', $request->notes, $matches)) {
                $totalAwal = (int)str_replace(',', '', $matches[1]);
            }

            $selisih = $totalAkhir - $totalAwal;

            try {
                if ($selisih > 0) {
                    $postdata['status'] = "Menunggu Pembayaran Tambahan";
                    $paymentUrl = null;

                    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                    \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

                    $lacakUrl = CRUDBooster::mainPath(); // URL untuk kembali ke daftar permohonan

                    $params = [
                        'transaction_details' => ['order_id' => 'INV-' . $id . '-2-' . time(), 'gross_amount' => $selisih],
                        'customer_details' => ['first_name' => $user->name, 'email' => $user->email],
                        'callbacks' => [
                            'finish' => $lacakUrl,
                            'error' => $lacakUrl,
                            'pending' => $lacakUrl
                        ]
                    ];

                    $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
                    
                    $currentNotes = $request->notes ? $request->notes . "\n" : "";
                    $postdata['notes'] = $currentNotes . "Biaya Tambahan: Rp " . number_format($selisih) . "\nLink Pembayaran Tambahan: " . $paymentUrl;

                    $pesanEmail = "Terdapat penambahan parameter pengujian pada sampel Anda. Berikut adalah tagihan biaya tambahannya: <a href='" . $paymentUrl . "'><b>Bayar Online Disini</b></a>.";
                } 
                else {
                    $postdata['status'] = "Selesai";
                    $pesanEmail = "Permohonan Anda telah sepenuhnya selesai diproses. LHP kini dapat diunduh melalui dashboard KATALIS.";
                }

                $job = new SendMail(['email' => $user->email, 'name' => $user->name, 'document_no' => $request->document_no, 'status' => $postdata['status'], 'notes' => $pesanEmail, 'template' => 'new_updates_2']);
                dispatch($job);

                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => ($selisih > 0) ? "Menerbitkan tagihan biaya tambahan parameter uji" : "Selesai tanpa ada tagihan biaya tambahan", 'updated_at' => now()]);
            }
            catch(Exception $e){
                Log::error('Midtrans Error on Request ID ' . $id . ': ' . $e->getMessage());
                Cx::redirect(Cx::mainPath(), "Terjadi kesalahan sistem pengiriman email atau Midtrans.","warning");
            }
        }

        // =========================================================================
        // SKENARIO 1: UPLOAD INVOICE AWAL (Menunggu Pengiriman Sampel -> Pembayaran)
        // =========================================================================
        elseif (strpos($reqType, 'handling') !== false || isset($postdata['billing_file'])) {
            $postdata['id_cms_staffs'] = Cx::myId();
            $postdata['status'] = "Menunggu Pembayaran";
            
            $totalHarga = (int)$request->total;

            try {
                $file = isset($postdata['billing_file']) ? url($postdata['billing_file']) : null;
                $paymentUrl = null;

                if ($totalHarga > 0) {
                    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                    \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

                     $lacakUrl = CRUDBooster::mainPath(); // URL untuk kembali ke daftar permohonan

                    $params = [
                        'transaction_details' => ['order_id' => 'INV-' . $id . '-1-' . time(), 'gross_amount' => $totalHarga],
                        'customer_details' => ['first_name' => $user->name, 'email' => $user->email],
                        'callbacks' => [
                            'finish' => $lacakUrl,
                            'error' => $lacakUrl,
                            'pending' => $lacakUrl
                        ]
                    ];

                    $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
                    
                    $currentNotes = $request->notes ? $request->notes . "\n" : "";
                    $postdata['notes'] = $currentNotes . "Total Biaya Awal: Rp " . number_format($totalHarga) . "\nLink Pembayaran Otomatis: " . $paymentUrl;
                }
                
                $pesanEmail = "Pelanggan yang terhormat, berikut adalah tagihan biaya pengujian tahap awal. ";
                if ($paymentUrl) {
                    $pesanEmail .= "Anda dapat melakukan pembayaran instan melalui link berikut: <a href='" . $paymentUrl . "'><b>Bayar Online Disini</b></a>.";
                }

                $job = new SendMail(['email' => $user->email, 'name' => $user->name, 'document_no' => $request->document_no, 'status' => 'Menunggu Pembayaran', 'notes' => $pesanEmail, 'template' => 'new_updates_2']);
                dispatch($job);

                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Menerbitkan billing/tagihan tahap awal", 'updated_at' => now()]);
            }
            catch(Exception $e){
                Log::error('Midtrans Error on Request ID ' . $id . ': ' . $e->getMessage());
                Cx::redirect(Cx::mainPath(), "Terjadi kesalahan integrasi Midtrans!","warning");
            }
        }

        // =========================================================================
        // SKENARIO 3: UPLOAD LHP
        // =========================================================================
        elseif(isset($postdata['lhp_file'])) {
            $postdata['status'] = "LHP Selesai";
            try {
                $mail = [
                    'email' => $user->email,
                    'name' => $user->name,
                    'document_no' => $request->document_no,
                    'status' => 'LHP Selesai',
                    'notes' => "Laporan Hasil Pengujian (LHP) telah selesai disusun. Namun, untuk dapat mengunduhnya secara penuh, tim kami akan segera menerbitkan Invoice rekapitulasi akhir untuk tahap penyelesaian.",
                    'template' => 'new_updates',
                ];
                $job = new SendMail($mail);
                dispatch($job);
                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Menerbitkan LHP", 'updated_at' => now()]);
            } catch(Exception $e){}
        }

        // =========================================================================
        // SKENARIO LAINNYA
        // =========================================================================
        elseif(isset($postdata['lhp_file_renew'])) {
            $postdata['lhp_file'] = $postdata['lhp_file_renew'];
            unset($postdata['lhp_file_renew']);
            DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Menerbitkan perubahan LHP terbaru", 'updated_at' => now()]);
        }

        elseif(isset($postdata['rating'])) {
            DB::table('ratings')->insert(['request_id' => $id, 'notes' => $postdata['notes'] ?? '', 'rating' => $postdata['rating']]);
            DB::table('requests')->where('id', $id)->update(['questioner_status' => 1, 'updated_at' => now()]);
            Cx::redirect(Cx::mainPath(), "Terima kasih, penilaian Anda berhasil dicatat.","success");
        }
        
        elseif(isset($postdata['estimation_dt'])) {
            DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Merubah tanggal perkiraan selesai pengujian"]);
        }
        
        else {
            $exists = DB::table('requests')->find($id);
            if(isset($_POST['type']) && $_POST['type'] != $exists->type) {
                $postdata['testings'] = NULL;
                $postdata['param_ready'] = 0;
                $postdata['total'] = 0;
                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Merubah jenis pengujian dan diharuskan mengisi ulang parameter uji"]);
            }
        }

        // =========================================================================
        // PENGATURAN FIELD UMUM
        // =========================================================================
        if(isset($_POST['name'])) $postdata['name'] = $_POST['name'];
        if(isset($_POST['type'])) $postdata['type'] = $_POST['type'];
        if(isset($_POST['size'])) $postdata['size'] = $_POST['size'];
        
        if(!empty($_POST['unit']) && $_POST['unit'] != "Lainnya") {
            $postdata['unit_others'] = NULL;
            $postdata['unit'] = $_POST['unit'];
        } else if(!empty($_POST['unit'])) {
            $postdata['unit_others'] = $_POST['unit_others'];
            $postdata['unit'] = $_POST['unit'];
        } 
    }

    public function hook_after_edit($id) {}
    public function hook_before_delete($id) {}
    public function hook_after_delete($id) {}

    public function getSetCancel($id) {
        $exists = DB::table('requests')->where('id_cms_users', Cx::myId())->where('status', "Permohonan Baru")->find($id);
        if ($exists) {
            if(Cx::myPrivilegeID() == 5) {
                DB::table('requests')->where('id_cms_users', Cx::myId())->where('status', "Permohonan Baru")->where('id', $id)->update(['status' => 'Permohonan Dibatalkan']);
                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Membatalkan permohonan"]);
                Cx::redirect(Cx::mainPath(), "Permohonan berhasil dibatalkan!","success");
            } else { Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning"); }
        } else { Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!","warning"); }
    }

    public function getSetTestings($id) 
    {
        $data = [];
        $data['page_title'] = 'Parameter Uji';
        $data['row'] = DB::table('requests')->where('id', $id)->first();
        
        if($data['row']) {
            if(Cx::myPrivilegeId() == 5 && $data['row']->id_cms_users != Cx::myId()) {
                Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning");
            } 

            $data['parameters'] = DB::table('parameters')
                ->where('type', $data['row']->type)
                ->where('status', "Active")
                ->get();

            // UBAH BAGIAN INI (Hapus filter 'platform' untuk sementara agar terlihat di dropdown)
            if(in_array($data['row']->status, ["Diajukan","Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) {
                $data['analysts'] = DB::table('cms_users')
                    ->where('id_cms_privileges', 4)
                    ->where('status', "Active")
                    ->get();
            }
                
            return $this->view('testings', $data);
        } else {
            Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!","warning");
        }
    }

    public function postUpdateTestings($id)
    {
        $exists = DB::table('requests')->find($id);
        if (!$exists) Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!", "warning");

        // --- LOGIKA UNTUK ANALIS (PRIVILEGE 4) ---
        if (Cx::myPrivilegeId() == 4) {
            $data = request()->all();
            $testings = json_decode($exists->testings);
            $parameters = [];
            if (isset($data['analyst'])) {
                foreach ($testings as $key => $item) {
                    $newStatus = isset($data['status'][$key]) ? $data['status'][$key] : $item->status;
                    if ($newStatus == "Selesai Pengujian" && $item->status != "Selesai Pengujian") {
                        DB::table('analyst_tasks')->where(['request_id' => $id, 'parameter' => $item->parameter, 'id_cms_analyst' => (int) $data['analyst'][$key]])->update(['status' => 'Selesai Pengujian', 'updated_at' => now()]);
                        DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Analis menyelesaikan pengujian parameter: " . $item->parameter]);
                    }
                    // Tetap mempertahankan properti data awal
                    $parameters[] = [
                        'id' => isset($item->id) ? (int)$item->id : null, 
                        'parameter_id' => isset($item->parameter_id) ? (int)$item->parameter_id : (int)$item->id,
                        'parameter' => $item->parameter, 
                        'harga_text' => $item->harga_text, 
                        'harga' => (int) $item->harga, 
                        'noik' => $item->noik, 
                        'id_cms_analyst' => (int) $data['analyst'][$key], 
                        'status' => $newStatus
                    ];
                }
                $all_done = !collect($parameters)->contains('status', '!=', 'Selesai Pengujian');
                $new_req_status = ($exists->status == "Dalam Proses Pengujian" && $all_done) ? "Proses Pembuatan LHP" : $exists->status;
                DB::table('requests')->where('id', $id)->update(['testings' => json_encode($parameters), 'status' => $new_req_status, 'updated_at' => now()]);
                Cx::redirect(Cx::mainPath(), "Data pengujian berhasil diperbarui!", "success");
            }
        }
        
        // --- LOGIKA UNTUK SUPER ADMIN/KOORDINATOR TEKNIS ---
        if(request()->has('status') && in_array(request('status'), ["Ditolak", "Diterima"])) {
            if($exists->status == "Diajukan") {
                if(Cx::myPrivilegeID() != 3) Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning"); 
                if(request('status') == "Ditolak") {
                    try{
                        DB::table('requests')->where('status', "Diajukan")->where('id', $id)->update(['id_cms_mt' => Cx::myId(), 'status' => 'Permohonan Ditolak', 'sdm' => request('sdm'), 'bahan_standar' => request('bahan_standar'), 'bahan_kimia' => request('bahan_kimia'), 'alat' => request('alat'), 'kesimpulan' => request('kesimpulan'), 'notes' => request('kesimpulan'), 'updated_at' => now()]);
                        DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Menolak permohonan Anda"]);
                        Cx::redirect(Cx::mainPath(), "Permohonan berhasil ditolak!","success");     
                    } catch(Exception $e) { Cx::redirect(Cx::mainPath(), "Terjadi kesalahan!","warning"); }
                } else if(request('status') == "Diterima") {
                    try {
                        DB::table('requests')->where('status', "Diajukan")->where('id', $id)->update(['id_cms_mt' => Cx::myId(), 'status' => 'Menunggu Pengiriman Sampel', 'sdm' => request('sdm'), 'bahan_standar' => request('bahan_standar'), 'bahan_kimia' => request('bahan_kimia'), 'alat' => request('alat'), 'estimation_dt' => request('estimation_dt'), 'kesimpulan' => request('kesimpulan'), 'updated_at' => now()]);
                        DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Menerima permohonan serta menunggu pengiriman sampel"]);
                        Cx::redirect(Cx::mainPath(), "Permohonan berhasil diterima!","success"); 
                    } catch(Exception $e) { Cx::redirect(Cx::mainPath(), "Terjadi kesalahan!","warning"); }
                }
            } else { Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!","warning"); }
        } else {
            if(Cx::myPrivilegeID() == 5 && $exists->id_cms_users != Cx::myId()) Cx::redirect(Cx::mainPath(), "Anda tidak berhak!","warning");
            
            $data = request()->all();
            
            if($exists->status == "Permohonan Baru") {
                $parameters = [];
                if (isset($data['parameter_id']) && count($data['parameter_id']) > 0) {
                    foreach ($data['parameter_id'] as $key => $param_id) {
                        $parameters[] = [
                            'id' => (int) $param_id, 
                            'parameter_id' => (int) $param_id,
                            'parameter' => $data['parameter'][$key], 
                            'harga_text' => $data['harga_text'][$key], 
                            'harga' => (int) $data['harga'][$key], 
                            'noik' => $data['noik'][$key], 
                            'status' => "Menunggu Tindakan"
                        ];
                    }
                }
                DB::table('requests')->where('id', $id)->update(['total' => (int) $data['total'] ?? 0, 'param_ready' => (int) $data['total'] ? 1 : 0, 'testings' => json_encode($parameters)]);
                Cx::redirect(Cx::mainPath(), "Parameter uji berhasil diubah!","success");
            }

            if(in_array($exists->status, ["Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian"])) {
                $parameters = [];
                $old_testings = json_decode($exists->testings);
                
                if (isset($data['parameter_id']) && count($data['parameter_id']) > 0) {
                    foreach ($data['parameter_id'] as $key => $param_id) {
                        $row_index = $data['row_index'][$key];
                        $is_old = false;
                        $old_item = null;
                        
                        if ($old_testings) {
                            foreach ($old_testings as $old) {
                                $old_match_id = $old->parameter_id ?? $old->id;
                                if ($old_match_id == $row_index) { $is_old = true; $old_item = $old; break; }
                            }
                        }

                        $analyst_val = isset($data['analyst'][$key]) ? (int)$data['analyst'][$key] : 0;
                        $status_val = isset($data['status'][$key]) ? $data['status'][$key] : "Menunggu Tindakan";

                        if ($is_old) {
                            if ($analyst_val != 0 && $analyst_val != ($old_item->id_cms_analyst ?? 0)) {
                                DB::table('analyst_tasks')->where(['request_id' => $id, 'id_cms_analyst' => $old_item->id_cms_analyst, 'parameter' => $old_item->parameter])->delete();
                                DB::table('analyst_tasks')->insert(['request_id' => $id, 'id_cms_analyst' => $analyst_val, 'parameter' => $old_item->parameter, 'harga_text' => $old_item->harga_text, 'harga' => (int) $old_item->harga, 'noik' => $old_item->noik, 'status' => "Analis telah didaftarkan serta menunggu tindakan Analis", 'created_at' => now()]);
                                $status_val = "Analis telah didaftarkan serta menunggu tindakan Analis";
                                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Menunjuk Analis untuk parameter uji " . $old_item->parameter]);
                            }
                            if ($status_val == "Selesai Pengujian" && $old_item->status != "Selesai Pengujian") {
                                DB::table('analyst_tasks')->where(['request_id' => $id, 'parameter' => $old_item->parameter, 'id_cms_analyst' => $analyst_val])->update(['status' => 'Selesai Pengujian', 'updated_at' => now()]);
                            }
                            $newData = ['id' => (int) $old_item->id, 'parameter_id' => (int)$old_item->parameter_id, 'parameter' => $old_item->parameter, 'harga_text' => $old_item->harga_text, 'harga' => (int) $old_item->harga, 'noik' => $old_item->noik, 'id_cms_analyst' => $analyst_val, 'status' => $status_val];
                        } else {
                            $newData = ['id' => (int) $param_id, 'parameter_id' => (int) $param_id, 'parameter' => $data['parameter'][$key], 'harga_text' => $data['harga_text'][$key], 'harga' => (int) $data['harga'][$key], 'noik' => $data['noik'][$key], 'id_cms_analyst' => $analyst_val, 'status' => "Menunggu Tindakan"];
                            DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Admin menambahkan parameter uji tambahan: " . $data['parameter'][$key]]);
                            if ($analyst_val != 0) {
                                DB::table('analyst_tasks')->insert(['request_id' => $id, 'id_cms_analyst' => $analyst_val, 'parameter' => $newData['parameter'], 'harga_text' => $newData['harga_text'], 'harga' => $newData['harga'], 'noik' => $newData['noik'], 'status' => "Analis telah didaftarkan serta menunggu tindakan Analis", 'created_at' => now()]);
                                $newData['status'] = "Analis telah didaftarkan serta menunggu tindakan Analis";
                            }
                        }
                        $parameters[] = $newData;
                    }
                }
        
                $all_done = (count($parameters) > 0) && !collect($parameters)->contains('status', '!=', 'Selesai Pengujian');
                $new_req_status = ($exists->status == "Dalam Proses Pengujian" && $all_done) ? "Proses Pembuatan LHP" : (($exists->status == "Siap Diuji") ? "Pra Pengujian" : $exists->status);
                
                $newTotal = collect($parameters)->sum('harga');
                
                DB::table('requests')->where('id', $id)->update(['testings' => json_encode($parameters), 'total' => $newTotal, 'estimation_dt' => request('estimation_dt') ?: $exists->estimation_dt, 'status' => $new_req_status]);
                Cx::redirect(Cx::mainPath(), "Data pengujian berhasil diperbarui!","success");
            } else { Cx::redirect(Cx::mainPath(), "Data permohonan sudah tidak bisa diubah!","warning"); }
        }
    }

    public function getSetApply($id) {
        $exists = DB::table('requests')->where('id_cms_users', Cx::myId())->where('status', "Permohonan Baru")->find($id);
        if ($exists) {
            if(Cx::myPrivilegeID() == 5) {
                DB::table('requests')->where('id_cms_users', Cx::myId())->where('status', "Permohonan Baru")->where('id', $id)->update(['status' => 'Diajukan', 'updated_at' => now()]);
                DB::table('histories')->insert(['id_cms_users' => Cx::myId(), 'request_id' => $id, 'notes' => "Mengajukan permohonan untuk segera diuji"]);
                Cx::redirect(Cx::mainPath(), "Permohonan berhasil diajukan!","success");                    
            } else { Cx::redirect(Cx::mainPath(), "Anda tidak berhak masuk ke halaman ini!","warning"); }
        } else { Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!","warning"); }
    }

public function getSetPaymentReceived($id) {
        $exists = DB::table('requests')->find($id);

        if ($exists) {
            if(Cx::myPrivilegeID() == 2) {
                
                if ($exists->status == "Menunggu Pembayaran Tambahan") {
                    DB::table('requests')->where('id', $id)->update([
                        'status' => 'Selesai', 
                        'paid_at' => now(), // <-- (OPSIONAL) Catat waktu pembayaran tambahan
                        'updated_at' => now()
                    ]);
                    DB::table('histories')->insert([
                        'id_cms_users' => Cx::myId(), 
                        'request_id' => $id, 
                        'notes' => "Pembayaran tambahan telah diterima dan proses pengujian selesai"
                    ]);
                    Cx::redirect(Cx::mainPath(), "Pembayaran TAMBAHAN diterima dan permohonan Selesai!", "success");
                    
                } elseif ($exists->status == "Menunggu Pembayaran") {
                    DB::table('requests')->where('id', $id)->update([
                        'status' => 'Siap Diuji', 
                        'paid_at' => now(), 
                        'updated_at' => now()
                    ]);
                    DB::table('histories')->insert([
                        'id_cms_users' => Cx::myId(), 
                        'request_id' => $id, 
                        'notes' => "Pembayaran awal telah diterima dan permohonan siap diuji"
                    ]);
                    Cx::redirect(Cx::mainPath(), "Pembayaran AWAL diterima dan status menjadi Siap Diuji!", "success");
                    
                } else {
                    Cx::redirect(Cx::mainPath(), "Status permohonan tidak valid untuk diverifikasi!", "warning"); 
                }
                
            } else {
                // <-- Peringatan jika bukan Admin Keuangan/Privilege 2 yang memaksa masuk URL
                Cx::redirect(Cx::mainPath(), "Anda tidak memiliki akses untuk memverifikasi pembayaran!", "warning");
            }
        } else {
            Cx::redirect(Cx::mainPath(), "Data permohonan tidak ditemukan!", "warning");
        }
    }
    }