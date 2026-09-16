<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">&mdash; Filter</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="{{ url(CRUDBooster::mainPath()) }}" method="GET">
                        <div class="col-md-4 form-group">
                            <label for="group_id">Pilih Jenis Pengujian</label>
                            <select class="form-control" name="type">
                                <option value="">Pilih Jenis Pengujian</option>
                                <option value="Cemaran Aflatoksin (Mikotoksin)" {{ request('type') == "Cemaran Aflatoksin (Mikotoksin)" ? 'selected' : '' }}>Cemaran Aflatoksin (Mikotoksin)</option>
                                <option value="Cemaran Logam" {{ request('type') == "Cemaran Logam" ? 'selected' : '' }}>Cemaran Logam</option>
                                <option value="Mutu Pestisida" {{ request('type') == "Mutu Pestisida" ? 'selected' : '' }}>Mutu Pestisida</option>
                                <option value="Mutu Pupuk" {{ request('type') == "Mutu Pupuk" ? 'selected' : '' }}>Mutu Pupuk</option>
                                <option value="Residu Pestisida" {{ request('type') == "Residu Pestisida" ? 'selected' : '' }}>Residu Pestisida</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="group_id">Pilih Status Permohonan</label>
                            <select class="form-control" name="status">
                                <option value="">Pilih Status Permohonan</option>
                                @if (CRUDBooster::myPrivilegeId() == 5)
                                    <option value="Permohonan Baru" {{ request('status') == "Permohonan Baru" ? 'selected' : '' }}>Permohonan Baru</option>
                                    <option value="Permohonan Dibatalkan" {{ request('status') == "Permohonan Dibatalkan" ? 'selected' : '' }}>Permohonan Dibatalkan</option>
                                @endif
                                
                                <option value="Diajukan" {{ request('status') == "Diajukan" ? 'selected' : '' }}>Diajukan</option>
                                <option value="Permohonan Ditolak" {{ request('status') == "Permohonan Ditolak" ? 'selected' : '' }}>Permohonan Ditolak</option>
                                <option value="Menunggu Pengiriman Sampel" {{ request('status') == "Menunggu Pengiriman Sampel" ? 'selected' : '' }}>Menunggu Pengiriman Sampel</option>
                                <option value="Menunggu Pembayaran" {{ request('status') == "Menunggu Pembayaran" ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                <option value="Siap Diuji" {{ request('status') == "Siap Diuji" ? 'selected' : '' }}>Siap Diuji</option>
                                <option value="Pra Pengujian" {{ request('status') == "Pra Pengujian" ? 'selected' : '' }}>Pra Pengujian</option>
                                <option value="Dalam Proses Pengujian" {{ request('status') == "Dalam Proses Pengujian" ? 'selected' : '' }}>Dalam Proses Pengujian</option>
                                <option value="Proses Pembuatan LHP" {{ request('status') == "Proses Pembuatan LHP" ? 'selected' : '' }}>Proses Pembuatan LHP</option>
                                <option value="LHP Selesai" {{ request('status') == "LHP Selesai" ? 'selected' : '' }}>LHP Selesai</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="group_id">Pilih Status Pembayaran</label>
                            <select class="form-control" name="paid_at">
                                <option value="">Pilih Status Pembayaran</option>
                                <option value="yes_asc" {{ request('paid_at') == "yes_asc" ? 'selected' : '' }}>Sudah Bayar (Urut Ascending)</option>
                                <option value="yes_desc" {{ request('paid_at') == "yes_desc" ? 'selected' : '' }}>Sudah Bayar (Urut Descending)</option>
                                <option value="no" {{ request('paid_at') == "no" ? 'selected' : '' }}>Belum Bayar</option>
                            </select>
                        </div>


                        <div class="col-md-4 form-group">
                            <label for="group_id">Pilih Tgl. Awal (Diajukan)</label>
                            <input type="date" class="form-control" name="start_dt" value="{{ request('start_dt') ?? '' }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="group_id">Pilih Tgl. Akhir (Diajukan)</label>
                            <input type="date" class="form-control" name="end_dt" value="{{ request('end_dt') ?? '' }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="group_id">&nbsp;</label>
                            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
