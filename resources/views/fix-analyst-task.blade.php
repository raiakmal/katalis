@extends("crudbooster::admin_template")

@push('head')
<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #00a65a;
    }
</style>
@endpush
@section("content")
<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <i class="fas fa-exclamation-circle"></i>
                Fix Tugas Analis
            </div>
            <div class="box-body">
                @if(request('document_no') && $row == null)
                    <div class="alert alert-danger">No. Permohonan tidak ditemukan!</div>
                @endif

                <form method='get'>
                    <div class='form-group'>
                        <label>Mohon Input No. Permohonan</label>
                        <input type='text' required class='form-control' name="document_no" value="{{ request('document_no') ?? '' }}" required placeholder="Masukkan no. permohonan" />
                    </div>

                    <div class='form-group'>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ CRUDBooster::mainPath() }}" class="btn btn-warning">Ulangi</a>
                    </div>
                </form>

                @if(request('document_no') && $row)

                <hr style="margin-bottom: 10px;">

                <div class="table-responsive">
                    <table class="table table-condensed">
                        <tr>
                            <td width="10%"><b>No. Permohonan</b></td>
                            <td width="5%">:</td>
                            <td width="80%">{{ $row->document_no }}</td>
                        </tr>
                        <tr>
                            <td width="10%"><b>Jenis Pengujian</b></td>
                            <td width="5%">:</td>
                            <td width="80%">{{ $row->type }}</td>
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <th>#</th>
                            <th>Parameter</th>
                            <th>Analis</th>
                            <th class="text-right">Aksi</th>
                        </thead>
                        <tbody>
                            @php
                                $testings = json_decode($row->testings);
                            @endphp

                            @forelse ($testings as $item)
                            <tr>
                                <form action="{{ CRUDBooster::mainPath('post-fix-analyst-task') }}" method="POST">
                                    @csrf
                                    @php
                                        $exists = DB::table('analyst_tasks')->where(['request_id' => $row->id, 'parameter' => $item->parameter])->first();
                                        $analyst = null;
                                        if($exists) {
                                            $analyst = DB::table('cms_users')->find($exists->id_cms_analyst);
                                        }
                                    @endphp
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->parameter }}</td>
                                    <td>
                                        @if($analyst) 
                                            {{ $analyst->name }}
                                        @else
                                            <select name="id_cms_analyst" class="form-control">
                                                <option value="">Pilih Analist</option>
                                                <option value="">A</option>
                                                <option value="">A</option>
                                                <option value="">A</option>
                                            </select>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if(!$exists)
                                        <form action="">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-xs">Fix</button>
                                        </form>
                                        @else
                                        -
                                        @endif
                                    </td>
                                </form>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Tidak Ada Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                      
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('head')
@endpush