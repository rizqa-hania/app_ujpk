@extends('template.karyawan.layout')

@section('content')

<section class="content">
<div class="container-fluid">

{{-- NOTIF ULANG TAHUN --}}
@if(isset($ulangTahunHariIni) && $ulangTahunHariIni->count() > 0)
<div class="alert alert-warning alert-dismissible fade show">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>🎉 Ulang Tahun Hari Ini!</strong>
<ul class="mb-0 mt-2">
@foreach($ulangTahunHariIni as $k)
<li>
{{ $k->nama_lengkap }}
({{ \Carbon\Carbon::parse($k->tanggal_lahir)->age }} tahun)
</li>
@endforeach
</ul>
</div>
@endif


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

@endsection