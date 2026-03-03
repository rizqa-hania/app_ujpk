<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Sistem Absensi</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">

<div class="login-box">
  
  <div class="login-logo">
    <b>APP</b>UJPK
  </div>

  <div class="card card-outline card-primary">
    <div class="card-body login-card-body">

      <p class="login-box-msg">
        Login Admin & Karyawan
      </p>

      {{-- Messages --}}
      @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
      @endif

      @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
          <input type="text" 
          name="login" 
          class="form-control" 
          placeholder="Email atau NIP" 
          required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" 
                 name="password" 
                 class="form-control" 
                 placeholder="Password" 
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
          Sign In
        </button>

      </form>

      <hr>

      <!-- Google Login -->
      <a href="/auth/google" class="btn btn-danger btn-block">
        <i class="fab fa-google"></i> Login dengan Google
      </a>

      <p class="mt-3 text-center">
        <a href="{{ route('register') }}">Belum punya akun? Daftar</a>
      </p>

    </div>
  </div>
</div>

<!-- Scripts -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>

</body>
</html>