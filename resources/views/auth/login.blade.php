<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login </title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">

 <style>
  body.login-page {
    background: url("{{ asset('assets/images/pt-ujpk-gambar.webp') }}") no-repeat center center fixed;
    background-size: cover;

    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative;
  }

  /* overlay biar fokus ke login */
  body.login-page::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 0;
  }

  .login-box {
    width: 450px;
    position: relative;
    z-index: 1;
  }

  .login-logo b {
    font-size: 50px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 2px;
  }

  
.card {
  background: rgba(255, 255, 255, 0.1) !important; /* transparan */
  backdrop-filter: blur(15px); /* efek kaca */
  -webkit-backdrop-filter: blur(15px);
  border-radius: 15px;
  border: 1px solid rgba(255,255,255,0.2);
  box-shadow: 0 8px 30px rgba(0,0,0,0.4);
}

  .login-card-body {
  background: transparent !important;
}

  .login-box-msg {
    font-size: 15px;
    color: #ddd;
    margin-bottom: 25px;
  }

  /* INPUT FIX */
  .form-control {
    height: 50px;
    border-radius: 10px;
    font-size: 15px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
  }

  .form-control:focus {
    background: rgba(234, 228, 228, 0.99);
    box-shadow: none;
    border-color: #4facfe;
  }

  .form-control::placeholder {
    color: #fef7f7;
  }

  .input-group-text {
    border-radius: 0 10px 10px 0;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
  }

  /* 🔥 BUTTON LEBIH HIDUP */
  .btn-primary {
    height: 50px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    border: none;
    transition: 0.3s;
  }

  .btn-primary:hover {
    transform: scale(1.03);
    opacity: 0.95;
  }

  hr {
    margin-top: 25px;
    border-color: rgba(255,255,255,0.2);
  }

  .sidebar .user-panel .info a{
    white-space: normal;
    overflow-wrap: break-word;
}

.main-sidebar{
    width:250px;
}

</style>
</head>

<body class="hold-transition login-page">

<div class="login-box">
  
  <div class="login-logo">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('images/logojya-removebg-preview.png') }}"
             
             style="width:120px; height:120px; object-fit:contain;"
             alt="Logo User">
    </div>
<!-- -->
     <b>APP UJPK</b>
</div>



   
   
  </div>

  <div class="card">
    <div class="card-body login-card-body">

      <p class="login-box-msg">
        Selamat Datang UJPK
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
          placeholder="Masukkan Email/NIP anda" 
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
                 placeholder="Masukkan Password" 
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
          Masuk
        </button>

      </form>

      <hr>

    </div>
  </div>
</div>

<!-- Scripts -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>

</body>
</html>