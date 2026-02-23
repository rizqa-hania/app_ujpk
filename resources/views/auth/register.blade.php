<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Sistem Absensi</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">

<div class="register-box">

  <div class="register-logo">
    <b>Sistem</b>Absensi
  </div>

  <div class="card">
    <div class="card-body register-card-body">

      <p class="login-box-msg">Registrasi Karyawan</p>

      <!-- Progress Step -->
      <div class="progress mb-4" style="height: 6px;">
        <div class="progress-bar bg-primary" 
             style="width: {{ session('step',1) == 1 ? '33%' : (session('step') == 2 ? '66%' : '100%') }}">
        </div>
      </div>

      <!-- STEP 1: EMAIL -->
      @if(session('step',1) == 1)
      <form action="/send-otp" method="POST">
        @csrf
        <div class="input-group mb-3">
          <input type="email" 
                 name="email" 
                 class="form-control" 
                 placeholder="Masukkan Email" 
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <button class="btn btn-primary btn-block">
          Kirim Kode Verifikasi
        </button>
      </form>
      @endif

      <!-- STEP 2: OTP -->
      @if(session('step') == 2)
      <form action="/verify-otp" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        <div class="input-group mb-3">
          <input type="text" 
                 name="otp" 
                 class="form-control text-center" 
                 placeholder="Masukkan Kode OTP" 
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>

        <button class="btn btn-primary btn-block">
          Verifikasi
        </button>
      </form>
      @endif

      <!-- STEP 3: DATA DIRI -->
      @if(session('step') == 3)
      <form action="/complete-register" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">

        <div class="input-group mb-3">
          <input type="text" 
                 name="name" 
                 class="form-control" 
                 placeholder="Nama Lengkap" 
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
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

        <button class="btn btn-success btn-block">
          Selesaikan Registrasi
        </button>
      </form>
      @endif

      <hr>

      <p class="text-center">
        Sudah punya akun? 
        <a href="/login">Login di sini</a>
      </p>

    </div>
  </div>
</div>

<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>

</body>
</html>