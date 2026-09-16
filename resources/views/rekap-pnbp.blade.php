@extends("crudbooster::admin_template")
@push('head')
 <style>
     th, td {
         vertical-align: middle !important;
     }
 </style>
@endpush
@section("content")
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
                            <label for="group_id">Pilih Tahun</label>
                            <select class="form-control" name="y">
                                <option value="">Semua Tahun</option>
                                @foreach(range(2021, now()->format('Y')) as $yl)
                                <option value="{{ $yl }}" {{ $yl == $y ? 'selected' : '' }}>{{ $yl }}</option>
                                @endforeach
                            </select>
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
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    <b>&mdash; Rekapitulasi PNBP</b>
                </h3>
            </div>
            <div class="box-body" style="padding: 0">
                <div class="table-responsive">
                    <table class="table table-bordered " style="margin-bottom: 0" id="table">
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Jenis Pengujian</th>
                            <th class="text-center" colspan="13">{{ $y }}</th>
                        </tr>
                        <tr>
                            @foreach (range(1, 12) as $m)
                            <th class="text-center">{{ $m }}</th>
                            @endforeach
                            <th class="text-right">Total</th>
                        </tr>

                        @if($datas->count() > 0)
                            @foreach ($datas->pluck('type')->unique() as $user)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ \Str::limit($user, 25) }}<br>
                                    </td>
                                    @foreach (range(1, 12) as $m)
                                        @php
                                            $nowHorizontal = $datas->where('type', $user)->sum('total');
                                            $now = $datas->where('type', $user)->where('m', $m)->first()->total;
                                        @endphp

                                        <td class="text-right" style="min-width: 100px">
                                            Rp{{ number_format($now) }}
                                        </td>
                                    @endforeach

                                    <td class="text-right"  style="min-width: 125px">
                                        Rp{{ number_format($nowHorizontal) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="2" class="text-right">Total</th>
                                @foreach (range(1, 12) as $m)
                                    @php
                                        $nowVertical = $datas->where('m', $m)->sum('total');
                                        $nowVerticalTotal += $nowVertical;
                                    @endphp

                                    <th class="text-right" width="10%">
                                        Rp{{ number_format($nowVertical) }}
                                    </th>
                                @endforeach

                                <th class="text-right" width="10%">
                                    Rp{{ number_format($nowVerticalTotal) }}
                                </th>
                            </tr>
                        @else
                            <tr>
                                <td colspan="15" class="text-center text-danger">&mdash; Belum Ada Data &mdash;</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
