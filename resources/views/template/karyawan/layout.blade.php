<style>

  .alert.alert-warning li {
  cursor: pointer;
  transition: 0.2s;
}

.alert.alert-warning li:hover {
  transform: translateX(5px);
  opacity: 0.9;
}

 .birthday-card {
  position: relative;
  padding: 20px 25px;
  border-radius: 15px;

  /* warna elegan */
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  color: #fff;

  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  overflow: hidden;
}

/* efek glow halus */
.birthday-card::before {
  content: "";
  position: absolute;
  width: 200%;
  height: 200%;
  top: -50%;
  left: -50%;
  background: radial-gradient(circle, rgba(255,255,255,0.2), transparent 60%);
  transform: rotate(25deg);
}

/* judul */
.birthday-card strong {
  font-size: 16px;
  font-weight: 600;
}

/* list */
.birthday-card ul {
  margin-top: 10px;
  padding-left: 18px;
}

.birthday-card li {
  margin-bottom: 5px;
  font-size: 14px;
}

/* umur */
.birthday-card .age {
  opacity: 0.85;
  font-size: 13px;
}

/* tombol close */
.birthday-card .close {
  position: absolute;
  top: 10px;
  right: 15px;
  opacity: 0.8;
}
.custom-modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
}

.modal-content {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  width: 320px;
  margin: 15% auto;
  text-align: center;
  animation: fadeIn 0.3s ease;
}

.modal-content h5 {
  margin-bottom: 10px;
}

.modal-content button {
  margin-top: 15px;
  padding: 8px 15px;
  border: none;
  background: #4facfe;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
}

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(-20px);}
  to {opacity: 1; transform: translateY(0);}
}
  </style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Karyawan PT UJPK</title>

  <!-- Favicon / Logo -->
<link rel="icon" href="assets/images/logo.png" type="image/png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css')}}">
  <!-- Datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap4.css">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('template.navbar')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Karyawan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('karyawan.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Sidebar sekarang di bawah konten -->
  <div class="container-fluid mt-4">
    @include('template.karyawan.sidebar')
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 PT UJPK.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- bootstrap 4 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap4.js"></script>
@stack('js')
</body>
</html>