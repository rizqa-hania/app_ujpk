@extends('template.karyawan.layout')

@section('content')

<section class="content">
<div class="container-fluid">

{{-- Notifikasi Ulang Tahun --}}
<div class="birthday-card">
<button class="close text-white" onclick="tutupCard(this)">&times;</button>

<strong>🎉 Ulang Tahun Hari Ini</strong>

<ul class="mb-0 mt-2">
@foreach($ulangTahunHariIni as $k)
<li onclick="ucapin('{{ $k->nama_lengkap }}')" style="cursor:pointer;">
{{ $k->nama_lengkap }}
({{ \Carbon\Carbon::parse($k->tanggal_lahir)->age }} tahun)
</li>
@endforeach
</ul>
</div>

<div id="birthdayModal" class="custom-modal">
  <div class="modal-content">
    <h5>🎉 Ulang Tahun!</h5>

    <p id="namaUcapan"></p>

    <!-- INPUT UCAPAN -->
    <textarea id="pesanUcapan" placeholder="Tulis ucapan kamu di sini..."
      style="width:100%; height:80px; border-radius:8px; padding:10px; border:1px solid #ccc;"></textarea>

    <!-- BUTTON -->
    <div style="margin-top:15px;">
      <button onclick="kirimUcapan()">Kirim</button>
      <button onclick="tutupModal()" style="background:#ccc; color:#000;">Tutup</button>
    </div>
  </div>
</div>

<!-- PROFILE CARD -->
<div class="row mb-4">
<div class="col-md-12">
<div class="card shadow-sm">
<div class="card-body d-flex align-items-center">

<img class="img-circle elevation-2 mr-4"
src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
width="80" height="80">

<div>
<h4 class="mb-1 font-weight-bold">
{{ $karyawan->nama_lengkap ?? auth()->user()->name }}
</h4>

<p class="mb-1 text-muted">
{{ $karyawan->jabatan->nama_jabatan ?? 'Belum ada jabatan' }}
</p>

<small class="text-muted">
NIP: {{ $karyawan->nip ?? '-' }}
</small>
</div>

<div class="ml-auto">
<a href="{{ route('karyawan.profile') }}" class="btn btn-primary btn-sm">
<i class="fas fa-user-edit mr-1"></i> Edit
</a>
</div>

</div>
</div>
</div>
</div>


<!-- STATISTIK -->
<div class="row mb-4 col-6">

<div class="col-md-4 col-6">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h3 class="font-weight-bold mb-0">
{{ $totalAbsensi ?? 0 }}
</h3>
<small class="text-muted">Total Absensi</small>
</div>

<div class="bg-light p-3 rounded">
<i class="fas fa-clock text-primary"></i>
</div>

</div>
</div>
</div>


<div class="col-md-4 col-6">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h3 class="font-weight-bold mb-0">
{{ $totalIzin ?? 0 }}
</h3>
<small class="text-muted">Total Izin</small>
</div>

<div class="bg-light p-3 rounded">
<i class="fas fa-envelope text-danger"></i>
</div>

</div>
</div>
</div>


<div class="col-md-4 col-6">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h3 class="font-weight-bold mb-0">
{{ $totalLembur ?? 0 }}
</h3>
<small class="text-muted">Total Lembur</small>
</div>

<div class="bg-light p-3 rounded">
<i class="fas fa-business-time text-warning"></i>
</div>

</div>
</div>
</div>

</div>


<!-- MENU CEPAT -->
<div class="card shadow-sm">

<div class="card-header">
<h5 class="mb-0 font-weight-bold">
<i class="fas fa-th-large mr-1"></i> Menu Cepat
</h5>
</div>

<div class="card-body">
<div class="row text-center justify-content-center">


<div class="col-4 col-md-2 mb-4">
<a href="{{ route('absensi.index') }}" class="text-dark">

<div class="p-3 rounded elevation-1"
style="background:#2f4bb2;color:white;">

<i class="fas fa-clock fa-2x mb-2"></i>

<div>Absensi</div>

</div>

</a>
</div>


<div class="col-4 col-md-2 mb-4">
<a href="{{ route('izin.create') }}" class="text-dark">

<div class="p-3 rounded elevation-1"
style="background:#2f4bb2;color:white;">

<i class="fas fa-envelope fa-2x mb-2"></i>

<div>Izin</div>

</div>

</a>
</div>


<div class="col-4 col-md-2 mb-4">
<a href="{{ route('lembur.create') }}" class="text-dark">

<div class="p-3 rounded elevation-1"
style="background:#2f4bb2;color:white;">

<i class="fas fa-business-time fa-2x mb-2"></i>

<div>Lembur</div>

</div>

</a>
</div>


</div>
</div>
</div>


<!-- ALERT -->
@if(session('success'))
<div class="alert alert-success alert-dismissible mt-3">
<button type="button" class="close" data-dismiss="alert">&times;</button>
{{ session('success') }}
</div>
@endif

</div>
</section>

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

.birthday-card {
  position: relative;
}

.birthday-card .close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
}

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(-20px);}
  to {opacity: 1; transform: translateY(0);}
}
  </style>
  <script>
let namaTerpilih = "";

function ucapin(nama) {
    namaTerpilih = nama;

    document.getElementById("namaUcapan").innerText =
        "Berikan ucapan untuk " + nama;

    document.getElementById("birthdayModal").style.display = "block";
}

function tutupModal() {
    document.getElementById("birthdayModal").style.display = "none";
}

function kirimUcapan() {
    let pesan = document.getElementById("pesanUcapan").value;

    if (pesan.trim() === "") {
        alert("Isi ucapan dulu ya!");
        return;
    }

    alert("Ucapan untuk " + namaTerpilih + ":\n\n" + pesan);

    // reset
    document.getElementById("pesanUcapan").value = "";
    tutupModal();
}
</script>
<script>
function tutupCard(btn) {
    btn.parentElement.style.display = "none";
}
</script>
@endsection