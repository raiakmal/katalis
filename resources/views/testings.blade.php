    @extends('crudbooster::admin_template')

    @push('head')
    <style>
        td {
            vertical-align: middle !important;
        }
        .readonly-select {
            pointer-events: none;
            background-color: #eee;
        }
    </style>
    @endpush

    @push('bottom')
    <script>
    function updateTotal() {
        var totVal = 0;
        var totalDisplay = $('#totalDisplay');
        var total = $('#total');
        
        $('.harga').each(function(){
            var newVal = parseInt($(this).val());
            if(!Number.isNaN(newVal)) {
                totVal += newVal;
            }
        });

        var formattedTotal = new Intl.NumberFormat("id-ID", {
            style: "currency", 
            currency: "IDR", 
            minimumFractionDigits: 2
        }).format(totVal);

        totalDisplay.val(formattedTotal);
        total.val(totVal);
    }

    $(function(){
        $(document).on('change','.parameter_id',function(){
            var obj = $(this);
            var row_val = obj.val(); 
            var row_id = obj.data('id'); 
            
            var parameter = $('#parameter_' + row_id);
            var harga_text = $('#harga_' + row_id);
            var harga = $('#harga_val_' + row_id);
            var noik = $('#noik_' + row_id);
            var status = $('#status_' + row_id);
            var status_text = $('#status_text_' + row_id);
            
            parameter.val("");
            harga_text.val("Memuat...");
            harga.val(0);
            noik.val("-");

            if(!row_val) {
                updateTotal();
                return;
            }

            $.ajax({
                url: "{{ url('api/get_param_detail') }}",
                data: { 
                    token: 'b0aab7cef76645cb040bc42eb38c7c23', // Ganti dengan Token API yang Active jika error 403 muncul lagi
                    id: row_val   
                },
                type: "GET",
                success: function(resp) { 
                    console.log("Respon dari API:", resp); 

                    if(resp.api_status == 1) {
                        parameter.val(resp.data.parameter);
                        
                        var rawPrice = resp.data.price !== undefined ? resp.data.price : resp.data.harga;
                        if (typeof rawPrice === 'string') {
                            rawPrice = rawPrice.replace(/[^0-9]/g, '');
                        }
                        var price = parseInt(rawPrice) || 0;

                        var formattedPrice = new Intl.NumberFormat("id-ID", {
                            style: "currency", 
                            currency: "IDR", 
                            minimumFractionDigits: 2
                        }).format(price);

                        harga_text.val(formattedPrice);
                        harga.val(price); 
                        
                        noik.val(resp.data.noik ?? '-');
                        status.val("Menunggu Tindakan");
                        status_text.text("Menunggu Tindakan");
                        
                        updateTotal();
                    } else {
                        alert("API merespons, tetapi gagal mengambil data. Cek Console Browser!");
                    }
                },
                error: function(xhr, status, error) {
                    alert("Terjadi kesalahan sistem/koneksi ke API!");
                    console.error("Detail Error:", error);
                }
            });
        });

        $(document).on('click', '#checkAll', function() {
            $('.itemRow').prop('checked', this.checked);
        });

        $(document).on('click', '.itemRow', function() {
            if ($('.itemRow:checked').length == $('.itemRow').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });

        var count = $('.itemRow').length;
        $(document).on('click', '#addRows', function() {
            count++;
            var htmlRows = `
                <tr>
                    <td><input class="itemRow" type="checkbox"></td>
                    <td>
                        <input type="hidden" name="row_index[]" value="new_${count}">
                        <select name="parameter_id[]" id="parameter_id_${count}" class="form-control parameter_id" data-id="${count}" required>
                            <option value="">Pilih Parameter</option>
                            @foreach($parameters as $param)
                                <option value="{{ $param->id }}">{{ $param->parameter }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="parameter[]" id="parameter_${count}" class="form-control">
                    </td>
                    @if(CRUDBooster::myPrivilegeId() <> 4)
                    <td>
                        <input type="text" name="harga_text[]" id="harga_${count}" class="form-control harga_text" readonly style="background: transparent; border: 0">
                        <input type="hidden" name="harga[]" id="harga_val_${count}" class="form-control harga" value="0">
                    </td>
                    @endif
                    <td>
                        <input type="text" name="noik[]" id="noik_${count}" class="form-control noik" readonly style="background: transparent; border: 0">
                    </td>
                    @if(in_array(Cx::myPrivilegeId(), [2,3,4,5]))
                    <td>
                        <select name="analyst[]" id="analyst_${count}" class="form-control analyst" required>
                            <option value="">Pilih Analis</option>
                            @if(isset($analysts))
                                @foreach($analysts as $analyst)
                                    <option value="{{ $analyst->id }}">{{ $analyst->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    @endif
                    <td>
                        <input type="hidden" name="status[]" id="status_${count}" value="Menunggu Tindakan">
                        <p id="status_text_${count}" style="margin-bottom: 0; white-space: pre-wrap; width: 100px">Pilih & Simpan Dahulu</p>
                    </td>
                </tr>
            `;
            $('#invoiceItem > tbody').append(htmlRows);
        });

        $(document).on('click', '#removeRows', function(){
            $('.itemRow:checked').each(function() {
                $(this).closest('tr').remove();
            });
            $('#checkAll').prop('checked', false);
            updateTotal();
        });

        updateTotal();
    });
    </script>
    @endpush

    @section('content')
    <form method='post' action='{{CRUDBooster::mainpath('update-testings/'.$row->id)}}'>
        @csrf
        <div class='panel panel-default'>
            <div class='panel-heading'>Parameter Uji</div>
            <div class='panel-body'>
                <div class='form-group'>
                    <label>No. Permohonan</label>
                    <input type='text' class='form-control' value='{{$row->document_no}}' readonly disabled/>
                </div>
                <div class='form-group'>
                    <label>Nama Sampel</label>
                    <input type='text' class='form-control' value='{{$row->name}}' readonly disabled/>
                </div>
                <div class='form-group'>
                    <label>Jenis Pengujian</label>
                    <input type='text' class='form-control' value='{{$row->type}}' readonly disabled/>
                </div>

                @if(CRUDBooster::myPrivilegeId() <> 4)
                <div class='form-group'>
                    <label>Total Biaya</label>
                    <input type='text' id="totalDisplay" class='form-control' value='{{ $row->total }}' readonly disabled/>
                    <input type='hidden' id="total" name="total" value='{{ $row->total }}'/>
                </div>
                @endif

                <div class='form-group'>
                    <label>Status Terakhir</label>
                    <input type='text' class='form-control' value='{{$row->status}}' readonly disabled/>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="invoiceItem">
                            <tbody>
                                <tr>
                                    <th width="5%">
                                        @if(($row->status == "Permohonan Baru" && CRUDBooster::myPrivilegeId() == 5) || (in_array(Cx::myPrivilegeId(), [2, 3]) && in_array($row->status, ["Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian"])))
                                            <input id="checkAll" type="checkbox"> 
                                        @else 
                                            # 
                                        @endif 
                                    </th>
                                    <th width="19%">Parameter</th>
                                    @if(CRUDBooster::myPrivilegeId() <> 4)
                                        <th width="15%">Harga</th>
                                    @endif
                                    <th width="15%">No. IK</th>
                                    @if(in_array(Cx::myPrivilegeId(), [2,3,4,5]))
                                        <th width="23%">Analis</th>
                                    @endif
                                    <th width="23%">Status Pengujian</th>
                                </tr>

                                @php
                                    $testings = $row->testings ? json_decode($row->testings) : [];
                                @endphp

                                @forelse($testings as $key => $item)
                                    <tr style="{{ Cx::myPrivilegeId() == 4 && $item->id_cms_analyst != Cx::myId() ? 'display: none' : '' }}">
                                        <td>
                                            @if(($row->status == "Permohonan Baru" && CRUDBooster::myPrivilegeId() == 5) || (in_array(Cx::myPrivilegeId(), [2, 3]) && in_array($row->status, ["Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian"])))
                                                <input class="itemRow" type="checkbox">
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>
                                            <input type="hidden" name="row_index[]" value="{{ $item->parameter_id ?? ($item->id ?? $key) }}">
                                            <select name="parameter_id[]" id="parameter_id_{{ $loop->iteration }}" data-id="{{ $loop->iteration }}" class="form-control parameter_id {{ in_array(Cx::myPrivilegeId(), [2,3,5]) && $row->status != 'Permohonan Baru' ? 'readonly-select' : '' }}" required>
                                                <option value="">Pilih Parameter</option>
                                                @foreach($parameters as $param)
                                                    <option value="{{ $param->id }}" {{ (isset($item->parameter_id) && $param->id == $item->parameter_id) || ($param->id == ($item->id ?? null)) ? 'selected' : '' }}>{{ $param->parameter }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="parameter[]" id="parameter_{{ $loop->iteration }}" value="{{ $item->parameter }}">
                                        </td>

                                        @if(CRUDBooster::myPrivilegeId() <> 4)
                                        <td>
                                            <input type="text" name="harga_text[]" id="harga_{{ $loop->iteration }}" value="{{ $item->harga_text }}" class="form-control harga_text" readonly style="background: transparent; border: 0">
                                            <input type="hidden" name="harga[]" id="harga_val_{{ $loop->iteration }}" value="{{ $item->harga }}" class="form-control harga">
                                        </td>
                                        @endif
                                        
                                        <td>
                                            <input type="text" name="noik[]" id="noik_{{ $loop->iteration }}" value="{{ $item->noik }}" class="form-control noik" readonly style="background: transparent; border: 0">
                                        </td>

                                        @if(in_array(Cx::myPrivilegeId(), [2,3,4,5]))
                                            <td>
                                               @if(CRUDBooster::myPrivilegeId() == 3 && $item->status != "Selesai Pengujian" && $row->status != "Diajukan")
                                                    <select name="analyst[]" id="analyst_{{ $loop->iteration }}" class="form-control analyst" required>
                                                        <option value="">Pilih Analis</option>
                                                        @if(isset($analysts))
                                                            @foreach($analysts as $analyst)
                                                                <option value="{{ $analyst->id }}" {{ (isset($item->id_cms_analyst) && $analyst->id == $item->id_cms_analyst) ? 'selected' : '' }}>{{ $analyst->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                @else
                                                    @php 
                                                        $id_analyst = $item->id_cms_analyst ?? 0;
                                                        $analyst_name = DB::table('cms_users')->where('id', $id_analyst)->value('name');
                                                    @endphp
                                                    <input type="text" class="form-control" value="{{ $analyst_name ?? 'Belum Ditunjuk' }}" readonly style="background-color: #eee; cursor: not-allowed;">
                                                    <input type="hidden" name="analyst[]" value="{{ $id_analyst }}">
                                                @endif
                                            </td>
                                        @endif
                                        
                                        <td>
                                            @if(Cx::myPrivilegeId() == 4 && $item->status == 'Dalam Proses Pengujian' && $item->id_cms_analyst == Cx::myId())
                                                <select name="status[]" class="form-control" required>
                                                    <option value="Dalam Proses Pengujian" selected>Dalam Proses Pengujian</option>
                                                    <option value="Selesai Pengujian">Selesai Pengujian</option>
                                                </select>
                                            @else
                                                <input type="hidden" name="status[]" value="{{ $item->status }}">
                                                @if($item->status == "Selesai Pengujian")
                                                    <a href="{{ $item->attachment ? url($item->attachment) : '#' }}" title="Unduh Lampiran" style="padding-left: 10px"><i class="fas fa-paperclip"></i> </a>{{ $item->status }}
                                                @else
                                                    <p id="status_text_{{ $loop->iteration }}" style="margin-bottom: 0; white-space: pre-wrap; width: 100px">{{ $item->status }}</p> 
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if(
                    ($row->status == "Permohonan Baru" && CRUDBooster::myPrivilegeId() == 5) || 
                    (in_array(Cx::myPrivilegeId(), [2, 3]) && in_array($row->status, ["Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian"]))
                )
                <div class="row">
                    <div class="col-xs-12 text-right">
                        <button class="btn btn-danger delete" id="removeRows" type="button">
                            <i class="fa fa-minus-circle mr-2"></i> Hapus Baris Terpilih
                        </button>
                        <button class="btn btn-success" id="addRows" type="button">
                            <i class="fa fa-plus-circle mr-2"></i> Tambah Baris
                        </button>
                    </div>
                </div>
                @endif

                @if(
                    CRUDBooster::myPrivilegeId() == 3 && in_array($row->status, ["Diajukan", "Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])
                    || CRUDBooster::myPrivilegeId() == 5 && in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])
                    || CRUDBooster::myPrivilegeId() == 2 && in_array($row->status, ["Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])
                    || Cx::myPrivilegeId() == 4 && in_array($row->status, ["Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])
                )
                
                <div class='form-group'>
                    <label>Metode <sup class="text-danger">*</sup></label>
                    <select class="form-control" required name="metode" @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif >
                        <option value="1" {{ $row->metode == "1" ? "selected" : "" }}>Ada</option>
                        <option value="0" {{ $row->metode == "0" ? "selected" : "" }}>Tidak Ada</option>
                    </select>
                </div>
                <div class='form-group'><label>SDM <sup class="text-danger">*</sup></label><select class="form-control" required name="sdm" @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif ><option value="1" {{ $row->sdm == "1" ? "selected" : "" }}>Ada</option><option value="0" {{ $row->sdm == "0" ? "selected" : "" }}>Tidak Ada</option></select></div>
                <div class='form-group'><label>Bahan Standar <sup class="text-danger">*</sup></label><select class="form-control" required name="bahan_standar" @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif ><option value="1" {{ $row->bahan_standar == "1" ? "selected" : "" }}>Ada</option><option value="0" {{ $row->bahan_standar == "0" ? "selected" : "" }}>Tidak Ada</option></select></div>
                <div class='form-group'><label>Bahan Kimia <sup class="text-danger">*</sup></label><select class="form-control" required name="bahan_kimia" @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif ><option value="1" {{ $row->bahan_kimia == "1" ? "selected" : "" }}>Ada</option><option value="0" {{ $row->bahan_kimia == "0" ? "selected" : "" }}>Tidak Ada</option></select></div>
                <div class='form-group'><label>Alat <sup class="text-danger">*</sup></label><select class="form-control" required name="alat" @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif ><option value="1" {{ $row->alat == "1" ? "selected" : "" }}>Ada</option><option value="0" {{ $row->alat == "0" ? "selected" : "" }}>Tidak Ada</option></select></div>

                @if(!in_array($row->status, ["Permohonan Ditolak", "Diajukan", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran"]))
                    @if(in_array($row->status, ["Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"]))
                        <div class='form-group' style='border: 2px dotted #000; padding: 10px'>
                            <label>Perkiraan Waktu Penyelesaian Pengujian</label>
                            <input type='date' name="estimation_dt" class='form-control' required value='{{ $row->estimation_dt }}' @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif />
                        </div>
                    @endif
                @endif

                <div class='form-group'>
                    <label>Kesimpulan <sup class="text-danger">Jika ditolak akan menjadi catatan penolakan</sup></label>
                    <input type='text' placeholder="Mohon masukkan kesimpulan" name="kesimpulan" required class='form-control' value='{{ $row->kesimpulan }}'  @if(CRUDBooster::myPrivilegeId() == 5 || in_array($row->status, ["Permohonan Ditolak", "Menunggu Pengiriman Sampel", "Menunggu Pembayaran", "Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian", "Proses Pembuatan LHP", "LHP Selesai"])) readonly disabled @endif />
                </div>
                @endif
            </div>
            
            <div class='panel-footer'>
                @if(
                    (CRUDBooster::myPrivilegeId() == 5 && $row->status == "Permohonan Baru") ||
                    (in_array(Cx::myPrivilegeId(), [2, 3]) && in_array($row->status, ["Siap Diuji", "Pra Pengujian", "Dalam Proses Pengujian"])) ||
                    (Cx::myPrivilegeId() == 4 && in_array($row->status, ["Pra Pengujian", "Dalam Proses Pengujian"]))
                )
                    <input type='submit' class='btn btn-primary pull-right' value='Simpan Perubahan'/>
                @endif

                <a href="{{ CRUDBooster::mainPath() }}" class="btn btn-warning">Kembali</a>

                @if(Cx::myPrivilegeId() == 3 && in_array($row->status, ["Diajukan"]))
                    <input id="btnDiterima" type='submit' name="status" class='btn btn-success pull-right' value='Diterima'/>
                    <input id="btnDitolak" type='submit' name="status" class='btn btn-danger pull-right' style="margin-right: 10px" value='Ditolak'/>
                @endif
            </div>
        </div>
    </form>
    @endsection