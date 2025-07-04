<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SPK Siswa Berprestasi - Yayasan Advent Papua' }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">

@include('layouts.alerts')

<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h5">
                SISTEM PENDUKUNG KEPUTUSAN UNTUK MENENTUKAN SISWA/I BERPRESTASI DENGAN MENGGUNAKAN METODE PROMETHEE
            </a>
        </div>
        <div class="card-body text-center">
            <p class="login-box-msg">Silakan login sebagai:</p>
            <div class="row">
                <div class="col-12 col-sm-4 mb-2 d-flex align-items-stretch">
                    <a href="{{ route('login.admin-yayasan') }}" class="btn btn-primary btn-block w-100 p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-user-shield fa-2x mb-2"></i>
                        Admin Yayasan
                    </a>
                </div>
                <div class="col-12 col-sm-4 mb-2 d-flex align-items-stretch">
                    <a href="{{ route('login.admin-sekolah') }}" class="btn btn-success btn-block w-100 p-3 h-100 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-user-cog fa-2x mb-2"></i>
                        Admin Sekolah
                    </a>
                </div>
                <div class="col-12 col-sm-4 mb-2 d-flex align-items-stretch">
                    <a href="{{ route('login.guru') }}" class="btn btn-warning btn-block w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                        Guru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
<script>
    setTimeout(() => {
        const toast = document.getElementById('liveToast');
        if (toast) {
            toast.classList.remove('show');
            toast.classList.add('fade');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>
</body>
</html>
