<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">&mdash; Filter</h3>
            </div>
            <div class="box-body">
                <form method="get" action="{{ CRUDBooster::mainPath() }}">
                    <div class="row">
                        @if(collect($filter['pangans'])->count() > 0)
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="id_cms_pangans" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Komoditas</option>
                                    @foreach($filter['pangans'] as $list)
                                        <option value="{{ $list['id'] }}"  {{ request()->get('id_cms_pangans') == $list['id'] ? 'selected' : ''  }}>{{ $list['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if(collect($filter['provinsis'])->count() > 0) 
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="id_cms_provinsis" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($filter['provinsis'] as $list)
                                    <option value="{{ $list['id'] }}" {{ request()->get('id_cms_provinsis') == $list['id'] ? 'selected' : '' }}>{{ $list['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if(collect($filter['kabupatens'])->count() > 0) 
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="id_cms_kabupatens" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Kabupaten</option>
                                    @foreach($filter['kabupatens'] as $list)
                                    <option value="{{ $list['id'] }}" {{ request()->get('id_cms_kabupatens') == $list['id'] ? 'selected' : '' }}>{{ $list['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if(collect($filter['kecamatans'])->count() > 0) 
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="id_cms_kecamatans" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($filter['kecamatans'] as $list)
                                    <option value="{{ $list['id'] }}" {{ request()->get('id_cms_kecamatans') == $list['id'] ? 'selected' : '' }}>{{ $list['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if(collect($filter['quartals'])->count() > 0) 
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="quartal_chosen" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Periode</option>
                                    @foreach($filter['quartals'] as $keys => $val)
                                    <option value="{{ $keys }}" {{ request()->get('quartal_chosen') == $keys ? 'selected' : '' }}>{{ $keys }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-md-3" style="margin-bottom: 20px">
                            <select class="form-control" name="years" style="height: 35px; font-size: 12; padding: 5px 10px;">
                                <option value="">Pilih Tahun</option>
                                @foreach(range(now()->subYears(5)->format('Y'), now()->format('Y')) as $yl)
                                <option value="{{ $yl }}" {{ $yl == request()->get('years') ? 'selected' : '' }}>{{ $yl }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3" style="margin-bottom: 20px">
                            <select class="form-control" name="months" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                <option value="">Pilih Bulan</option>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @while($i <= 12)
                                        @php
                                            $month = $i++;
                                        @endphp
                                        <option value="{{ $month }}" {{ request()->get('months') == $month ? 'selected' : '' }}>{{ \Carbon\carbon::create()->month($month)->format('M') }}</option>
                                    @endwhile
                            </select>
                        </div>

                        <div class="col-md-3" style="margin-bottom: 20px">
                            <select class="form-control" name="status" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                <option value="">Pilih Status</option>
                                <option value="Pending" {{ request()->get('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="On Progress" {{ request()->get('status') == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                                <option value="Telah Diverifikasi" {{ request()->get('status') == 'Telah Diverifikasi' ? 'selected' : '' }}>Telah Diverifikasi</option>
                                <option value="Ditolak" {{ request()->get('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        @if(collect($filter['lahans'])->count() > 0) 
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="lahan" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Jenis Lahan</option>
                                    @foreach($filter['lahans'] as $list)
                                        <option value="{{ $list['id'] }}" {{ request()->get('lahan') == $list['id'] ? 'selected' : '' }}>{{ $list['name'] }} ({{$list['jenis']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if(request()->segment(2) == "reports") 
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <select class="form-control" name="jenis_bantuan" style="height: 30px; font-size: 12; padding: 5px 10px;">
                                    <option value="">Pilih Jenis Bantuan</option>
                                    <option value="BanPem" {{ request()->get('jenis_bantuan') == 'BanPem' ? 'selected' : '' }}>BanPem</option>
                                    <option value="Non BanPem" {{ request()->get('jenis_bantuan') == 'Non BanPem' ? 'selected' : '' }}>Non BanPem</option>
                                </select>
                            </div>
                        @endif
                        
                        <div class="col-md-12 text-right" style="margin-bottom: 20px">
                            <button type="submit" class="btn btn-success btn-md">Filter</button>
                        </div>

                        @if(collect(request()->except('debug'))->count() > 0)
                            <div class="col-md-3" style="margin-bottom: 20px">
                                <a href="{{ $filter['current'] }}" class="btn btn-danger btn-md">Hapus Filter</a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>