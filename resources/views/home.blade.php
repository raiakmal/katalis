@extends("crudbooster::admin_template")

@push('head')
<style>
    .nav-tabs-custom>.nav-tabs>li.active {
        border-top-color: #00b7f0;
    }
</style>
@endpush
@section("content")
<div class="row">
    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-xs-12">
        <legend>Statistik Pengguna Aplikasi</legend>
    </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pendaftaran Baru</span>
          <span class="info-box-number">{{ number_format($new_users) }}</span>
        </div>
      </div>
    </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pelanggan</span>
          <span class="info-box-number">{{ number_format($customers) }}</span>
        </div>
      </div>
    </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-purple"><i class="fas fa-hospital-user"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">MT / Penyelia</span>
            <span class="info-box-number">{{ number_format($users[3]) }}</span>
          </div>
        </div>
    </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-maroon"><i class="fa fa-chalkboard-teacher"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Analis</span>
          <span class="info-box-number">{{ number_format($users[4]) }}</span>
        </div>
      </div>
    </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fas fa-user-friends"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Petugas Pengelola Sampel</span>
          <span class="info-box-number">{{ number_format($users[2]) }}</span>
        </div>
      </div>
    </div>
    @endif
  </div>
  
  <div class="row">
    <div class="col-xs-12">
        <legend>Monitor Permohonan Pengujian</legend>
    </div>
    
    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-teal"><i class="fas fa-star-of-life"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Pengajuan Baru</span>
            <span class="info-box-number">{{ number_format($requests['Diajukan']) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-navy"><i class="fas fa-hourglass-half"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Dalam Pengerjaan</span>
            <span class="info-box-number">{{ number_format($requests['Menunggu Pengiriman Sampel'] + $requests['Menunggu Pembayaran'] + $requests['Siap Diuji'] + $requests['Pra Pengujian'] + $requests['Dalam Proses Pengujian'] + $requests['Proses Pembuatan LHP'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fas fa-check-double"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Selesai</span>
            <span class="info-box-number">{{ number_format($requests['LHP Selesai'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [1, 2, 3, 6]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fas fa-times"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Ditolak</span>
            <span class="info-box-number">{{ number_format($requests['Permohonan Ditolak'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fas fa-star-of-life"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Permohonan Baru</span>
            <span class="info-box-number">{{ number_format($requests['Permohonan Baru']) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fas fa-list"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Menunggu Persetujuan</span>
            <span class="info-box-number">{{ number_format($requests['Diajukan']) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fas fa-hourglass-half"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Dalam Pengerjaan</span>
            <span class="info-box-number">{{ number_format($requests['Menunggu Pengiriman Sampel'] + $requests['Menunggu Pembayaran'] + $requests['Siap Diuji'] + $requests['Pra Pengujian'] + $requests['Dalam Proses Pengujian'] + $requests['Proses Pembuatan LHP'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    
    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fas fa-check-circle"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Selesai</span>
            <span class="info-box-number">{{ number_format($requests['LHP Selesai'] ) }}</span>
          </div>
        </div>
      </div>
    @endif


    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fas fa-hand-holding-heart"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Butuh Tindakan Anda</span>
            <span class="info-box-number">{{ number_format($requests['Permohonan Baru'] + $requests['Menunggu Pengiriman Sampel'] + $requests['Menunggu Pembayaran'] + $requests['Proses Pembuatan LHP'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fas fa-times"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Ditolak</span>
            <span class="info-box-number">{{ number_format($requests['Permohonan Ditolak'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [5]))
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fas fa-minus"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Dibatalkan</span>
            <span class="info-box-number">{{ number_format($requests['Permohonan Dibatalkan'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    
    @if(in_array(Cx::myPrivilegeId(), [4]))
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fas fa-hand-holding-heart"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Butuh Tindakan</span>
            <span class="info-box-number">{{ number_format($myWorks['Analis telah didaftarkan serta menunggu tindakan Analis'] ) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [4]))
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-maroon"><i class="fas fa-hourglass-half"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Dalam Pengerjaan</span>
            <span class="info-box-number">{{ number_format($myWorks['Dalam Proses Pengujian']) }}</span>
          </div>
        </div>
      </div>
    @endif

    @if(in_array(Cx::myPrivilegeId(), [4]))
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fas fa-check-double"></i></span>
  
          <div class="info-box-content">
            <span class="info-box-text">Selesai</span>
            <span class="info-box-number">{{ number_format($myWorks['Proses Pembuatan LHP'] ) }}</span>
          </div>
        </div>
      </div>
    @endif


  </div>

  <div class="row">
    <div class="col-xs-12">
        <legend>Informasi Terkini</legend>
    </div>

    @if(in_array(Cx::myPrivilegeId(), [1, 3, 6]))
    <div class="col-md-7 col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                {{-- <li class="active">
                    <a href="#tab_1" data-toggle="tab">
                        <i class="fas fa-chart-bar"></i>
                        Grafik Permohonan Pengujian
                    </a>
                </li> --}}

                @if(in_array(Cx::myPrivilegeId(), [1, 3, 6]))
                <li class="active">
                    <a href="#tab_2" data-toggle="tab">
                        <i class="fas fa-user-friends"></i>
                        Load Kerja Analis
                    </a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                {{-- <div class="tab-pane active" id="tab_1">
                    <div class="overlay">
                            <i class="fas fa-refresh fa-spin"></i>
                    </div>
                </div> --}}

                @if(in_array(Cx::myPrivilegeId(), [1, 3, 6]))
                <div class="tab-pane active" id="tab_2">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover">
                            <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Butuh Tindakan</th>
                                <th>Dalam Pengerjaan</th>
                                <th>Telah Selesai</th>
                            </thead>
                            <tbody>
                                @forelse ($analyst_workloads as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <p class="mb-0">{{ $item->name }}</p>
                                            @php
                                            $explode = explode(";", $item->platform);   
                                            @endphp
                                            <small class="text-success"><b>{!! implode(", ", $explode) !!}</b></small>
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($item->works['Analis telah didaftarkan serta menunggu tindakan Analis'] ) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($item->works['Dalam Proses Pengujian'] ) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($item->works['Proses Pembuatan LHP'] ) }}
                                        </td>
                                    </tr> 
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak Ada Data</td>
                                    </tr>   
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(!in_array(Cx::myPrivilegeId(), [3, 4]))
    <div class="{{ !in_array(Cx::myPrivilegeId(), [1, 3, 6]) ? 'col-md-12' : 'col-md-5' }} col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <i class="fas fa-clock"></i>
                Aktifitas Terbaru
            </div>
            <div class="box-body">
                @if($activities->count() > 0)
                    <ul class="timeline mb-0 pb-0">
                        @foreach($activities as $activity)
                        <li>
                            <i class="fa fa-clock bg-green"></i>
                            <div class="timeline-item">
                                <h5 class="no-border text-success" style="padding-top: 0; margin-top: -5px">{{ $activity->created_at }}</h5>
                                <h5 class="no-border text-success" style="padding-top: 0; margin-top: 3px; margin-bottom: 5px; font-size: 12px; font-weight: bold">#{{ $activity->document_no }}</h5>
                                <h3 class="timeline-header no-border" style="padding-top: 0; padding-left: 0">{{ $activity->notes }}</h3>
                                
                                

                                <h5 class="no-border text-success" style="padding-top: 5px; margin-top: -5px; padding-bottom: 10px; font-size: 12px; font-weight: bold">
                                    &mdash; 

                                    {{ $activity->user_name }} 
                                    @if($activity->user_company) 
                                      ({{ $activity->user_company }}) 
                                    @endif 
                                    
                                    @if($activity->user_role && $activity->user_role <> "Pelanggan") 
                                      ({{ $activity->user_role }}) 
                                    @endif
                                </h5>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-danger mb-0 text-center">Tidak Ada Aktifitas</div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('head')
@endpush