<style>
    .navbar-custom {
        background-color: #00b7f0;
        color: #ffffff;
        border-radius: 0;
    }

    .navbar-custom .navbar-nav>li>a {
        color: #fff;
    }

    .navbar-custom .navbar-nav>.active>a {
        color: #ffffff;
        background-color: transparent;
    }

    .navbar-custom .navbar-nav>li>a:hover,
    .navbar-custom .navbar-nav>li>a:focus,
    .navbar-custom .navbar-nav>.active>a:hover,
    .navbar-custom .navbar-nav>.active>a:focus,
    .navbar-custom .navbar-nav>.open>a {
        text-decoration: none;
        background-color: #00b7f0;
    }

    .navbar-custom .navbar-brand {
        color: #eeeeee;
    }

    .navbar-custom .navbar-toggle,
    .navbar-default .navbar-toggle:focus,
    .navbar-default .navbar-toggle:hover {
        background-color: transparent;
    }

    .navbar-custom .icon-bar {
        background-color: #00b7f0;
    }

    .navbar-default .navbar-toggle .icon-bar {
        background-color: #fff;
    }

    .navbar-custom .navbar-nav>li>a:focus,
    .navbar-custom .navbar-nav>li>a:hover {
        color: #fff;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 500px;
        max-width: 700px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 5px 10%;
    }

    .modal.left.fade .modal-dialog {
        left: -500px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog {
        left: 0;
    }

    .modal.right.fade .modal-dialog {
        right: -500px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    @media screen and (max-width: 768px) {

        .modal-dialog {
            width: -webkit-fill-available !important;
        }
    }

    .modal-header {
        border-bottom-color: transparent;
        background-color: #fff;
        padding: 0 auto;
    }

    .close {
        opacity: 1;
        color: #00b7f0;
        font-size: 30px;
    }

    .logo-modal {
        width: 80px;
        height: 80px;
        margin-left: 20px;
        margin-bottom: -5px;
    }

    .logo-list {
        width: 75px;
    }

    .list-parent {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 15px;
    }

    .list-content>ul>li {
        font-size: 12px;
    }

    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 1px;
        text-overflow: '';
    }

    .navbar-top {
        background: #fff;
    }

    .nav-group {
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 1002;
    }

    .custom-container {
        display: flex;
        justify-content: space-between;
        margin: 0;
        padding: 0 20px;
        align-items: center;
        width: auto;
        flex-wrap: wrap;
    }

    .navbar-text {
        white-space: nowrap;
    }

    @media screen and (max-width: 1024px) {
        .custom-container {
            padding: 20px;
            justify-content: center;
        }

        .navbar-brand>img {
            margin: auto;
        }

        .navbar-text {
            white-space: pre-wrap;
        }
    }
</style>

<div class="nav-group">
    <nav class="navbar navbar-default navbar-top mb-0  hidden-xs hidden-sm">
        <div class="container-fluid custom-container">
            <div class="navbar-header" style="flex: 1">
                <a class="navbar-brand" href="#" style="padding: 5px; height: 100%">
                    <img src="{{ asset('assets/images/logo-black.png') }}" alt="Logo" width="125">
                </a>
            </div>

            <div class="navbar-text" style="">
                Sistem Manajemen Informasi Laboratorium Pertanian Terpadu Kimia Agro
            </div>
            </ul>
        </div>
    </nav>

    <nav class="navbar navbar-default navbar-custom">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#modalMaklumat">
                            <i class="fas fa-comment-alt mr-2"></i>
                            Moto dan Maklumat Pelayanan
                        </a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#modalBobotContoh">
                            <i class="fas fa-list-ul mr-2"></i>
                            Persyaratan Bobot Contoh
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <li>
                        <a href="#" data-toggle="modal" data-target="#modalJenisPengujian">
                            <i class="fas fa-th-large mr-2"></i>
                            Jenis Pengujian
                        </a>
                    </li>
                </ul>
            </div>
        </div>
</div>
</nav>

<div class="modal left fade" id="modalMaklumat" tabindex="-1" role="dialog" aria-labelledby="modalMaklumatLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 30px;">
                    <img class="logo-modal"
                        src="{{ CRUDBooster::getSetting('favicon') ? asset(CRUDBooster::getSetting('favicon')) : asset('vendor/crudbooster/assets/logo_crudbooster.png') }}"
                        alt="Logo">
                    <h5 class="text-primary" style="letter-spacing: 2px; font-weight: 600;">KATALIS</h5>
                </div>

                <img class="w-100" src="{{ asset('assets/images/moto-maklumat.png') }}"
                    alt="Moto & Maklumat Pelayanan">
            </div>
        </div>
    </div>
</div>

<div class="modal left fade" id="modalBobotContoh" tabindex="-1" role="dialog" aria-labelledby="modalBobotContohLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <img class="logo-modal"
                        src="{{ CRUDBooster::getSetting('favicon') ? asset(CRUDBooster::getSetting('favicon')) : asset('vendor/crudbooster/assets/logo_crudbooster.png') }}"
                        alt="Logo">
                    <h5 class="text-primary" style="letter-spacing: 2px; font-weight: 600;">KATALIS</h5>
                </div>

                <h5 class="text-primary text-center">Persyaratan Minimum Bobot Contoh Untuk Pengujian</h5>

                <div class="list-parent">
                    <div>
                        <img class="logo-list" src="{{ asset('assets/images/mutu-pestisida.png') }}"
                            alt="Mutu Pestisida">
                    </div>
                    <div class="list-content">
                        <ul>
                            <h5 class="text-success" style="margin-left: -15px">Mutu Pestisida</h5>
                            <li>Uji kadar bahan teknis pestisida minimal 10 mL atau 10 g.</li>
                            <li>Uji kadar bahan aktif formulasi pestisida minimal 250 mL atau 250 g.</li>
                        </ul>
                    </div>
                </div>

                <div class="list-parent">
                    <div>
                        <img class="logo-list" src="{{ asset('assets/images/mutu-produk-tanaman.png') }}"
                            alt="Mutu Produk Tanaman">
                    </div>
                    <div class="list-content">
                        <ul>
                            <h5 class="text-success" style="margin-left: -15px">Mutu Produk Tanaman</h5>
                            <li>Produk berukuran kecil (< 25 g) minimal 1 kg.</li>
                            <li>Produk berukuran sedang (25 - 250 g) minimal 1 kg atau 10 satuan.</li>
                            <li>Produk berukuran besar (250 g - 2 kg) minimal 2 satuan.</li>
                        </ul>
                    </div>
                </div>

                <div class="list-parent">
                    <div>
                        <img class="logo-list" src="{{ asset('assets/images/mutu-pupuk.png') }}" alt="Mutu Pupuk">
                    </div>
                    <div class="list-content">
                        <ul>
                            <h5 class="text-success" style="margin-left: -15px">Mutu Pupuk</h5>
                            <li>Pupuk organik padatan minimal 1 kg, cairan minimal 1 L.</li>
                            <li>Pupuk anorganik padatan minimal 500 g, cairan minimal 500 mL.</li>
                        </ul>
                    </div>
                </div>

                <div class="list-parent">
                    <div>
                        <img class="logo-list" src="{{ asset('assets/images/tanah.png') }}" alt="Tanah">
                    </div>
                    <div class="list-content">
                        <ul>
                            <h5 class="text-success" style="margin-left: -15px">Tanah</h5>
                            <li>Tanah pertanian minimal 1 kg.</li>
                        </ul>
                    </div>
                </div>

                <div class="list-parent">
                    <div>
                        <img class="logo-list" src="{{ asset('assets/images/air-irigasi.png') }}" alt="Air Irigasi">
                    </div>
                    <div class="list-content">
                        <ul>
                            <h5 class="text-success" style="margin-left: -15px">Air Irigasi</h5>
                            <li>Minimal 1 L.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal right fade" id="modalJenisPengujian" tabindex="-1" role="dialog"
    aria-labelledby="modalJenisPengujianLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 30px">
                    <img class="logo-modal"
                        src="{{ CRUDBooster::getSetting('favicon') ? asset(CRUDBooster::getSetting('favicon')) : asset('vendor/crudbooster/assets/logo_crudbooster.png') }}"
                        alt="Logo">
                    <h5 class="text-primary" style="letter-spacing: 2px; font-weight: 600;">KATALIS</h5>
                </div>

                <img class="w-100" src="{{ asset('assets/images/jenis-pengujian.png') }}" alt="Jenis Pengujian">


            </div>
        </div>
    </div>
</div>

<div class="modal right fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegisterLabel"
    aria-hidden="true">
    <div class="modal-dialog w-auto" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="margin-left: 10px margin-right: 10px">
                <div
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 30px">
                    <img class="logo-modal"
                        src="{{ CRUDBooster::getSetting('favicon') ? asset(CRUDBooster::getSetting('favicon')) : asset('vendor/crudbooster/assets/logo_crudbooster.png') }}"
                        alt="Logo">
                    <h5 class="text-primary" style="letter-spacing: 2px; font-weight: 600;">KATALIS</h5>
                </div>

                <h5 class="text-primary text-center mb-4">Buat Akun Baru</h5>


                <form autocomplete="off" action="{{ route('postRegister') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <input autocomplete="off" type="text" class="form-control" name="company"
                                    required placeholder="Nama Pemohon/Instansi/Perusahaan"
                                    value="{{ old('company') }}" />
                                <span class="fas fa-building form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input autocomplete="off" type="text" class="form-control" name="name"
                                    required placeholder="Nama Penghubung" value="{{ old('name') }}" />
                                <span class="fas fa-user form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <select class="form-control" name="kategori" required>
                                    <option value="">Kategori Pelanggan</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ old('kategori') == $category ? 'selected' : '' }}>{{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="fas fa-chevron-down form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <input autocomplete="off" type="text" class="form-control" name="email"
                                    required placeholder="Email" value="{{ old('email') }}" />
                                <span class="fas fa-envelope form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <input autocomplete="off" type="text" class="form-control" name="phone"
                                    required placeholder="No. WhatsApp. Format: 08xxxxxxxx"
                                    value="{{ old('phone') }}" />
                                <span class="fab fa-whatsapp form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <select class="form-control" name="id_cms_provinsis" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinsis as $provinsi)
                                        <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                    @endforeach
                                </select>
                                <span class="fas fa-chevron-down form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <select class="form-control" name="id_cms_kabupatens" required disabled>
                                    <option value="">Pilih Kota/Kab</option>
                                </select>
                                <span class="fas fa-chevron-down form-control-feedback"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <textarea autocomplete="off" name="address" class="form-control" placeholder="Alamat lengkap perusahaan" required>{{ old('address') }}</textarea>
                                <span class="fas fa-globe form-control-feedback"></span>
                            </div>
                            <p class="mt-3"><small class="text-success"><b>*Kata sandi akan dikirim ke alamat email
                                        yang didaftarkan setelah data Anda kami verifikasi</b></small></p>
                        </div>
                    </div>

                    <div style="margin-bottom:10px" class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-warning btn-lg btn-rounded mb-3">
                                Daftar
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            Sudah mempunyai Akun? <a href="#" data-dismiss="modal"
                                class="text-success"><b>Masuk Disini</b></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal right fade" id="modalForgot" tabindex="-1" role="dialog" aria-labelledby="modalForgotLabel"
    aria-hidden="true">
    <div class="modal-dialog w-100" role="document">
        <div class="modal-content h-100">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="margin-left: 10px margin-right: 10px">
                <div
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-bottom: 30px">
                    <img class="logo-modal"
                        src="{{ CRUDBooster::getSetting('favicon') ? asset(CRUDBooster::getSetting('favicon')) : asset('vendor/crudbooster/assets/logo_crudbooster.png') }}"
                        alt="Logo">
                    <h5 class="text-primary" style="letter-spacing: 2px; font-weight: 600;">KATALIS</h5>
                </div>

                <h5 class="text-primary text-center mb-4">Lupa Kata Sandi</h5>


                <form autocomplete="off" action="{{ route('postForgot') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <input autocomplete="off" type="text" class="form-control" name="email"
                                    required placeholder="Email" value="{{ old('email') }}" />
                                <span class="fas fa-envelope form-control-feedback"></span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom:10px" class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-danger btn-lg btn-block btn-rounded mb-3">
                                Kirim Kata Sandi Baru
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            Sudah ingat? <a href="#" data-dismiss="modal" class="text-success"><b>Masuk
                                    Disini</b></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
