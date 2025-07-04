<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Area</title>
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
  <!-- Logo -->
  <div class="login-logo">
    <b>Login Admin Sekolah</b>
  </div>

  <!-- Card -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silakan login terlebih dahulu</p>

      <form action="{{ route('auth.login.admin-sekolah') }}" method="POST">
        @csrf

        <!-- Email -->
        <div class="input-group mb-3">
          <input type="text" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <!-- Tombol -->
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- Informasi Login -->
<div class="login-box mt-3">
  <div class="card">
    <div class="card-body login-card-body">
        <p class="text-center text-bold">🔐 Informasi Akun Login</p>
        <ul class="small">
            <li><strong>Admin Sekolah 1</strong><br>
                Email: <code>adminsekolah1@gmail.com</code><br>
                Password: <code>adminsekolah1</code>
            </li>
            <li><strong>Admin Sekolah 2</strong><br>
                Email: <code>adminsekolah2@gmail.com</code><br>
                Password: <code>adminsekolah2</code>
            </li>
        </ul>
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
