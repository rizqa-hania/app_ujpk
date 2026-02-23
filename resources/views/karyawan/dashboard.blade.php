@extends('layouts.master') @section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Halo, {{ Auth::user()->name }}!</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/avatar.png') }}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ $karyawan->nama_lengkap }}</h3>
                        <p class="text-muted text-center">{{ $karyawan->jabatan->nama_jabatan ?? 'Karyawan' }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item"><b>NIP</b> <a class="float-right">{{ $karyawan->nip }}</a></li>
                            <li class="list-group-item"><b>Status</b> <a class="float-right text-success">{{ strtoupper($karyawan->status_karyawan) }}</a></li>
                        </ul>
                        <a href="{{ route('karyawan.profile') }}" class="btn btn-primary btn-block"><b>Lihat Profile</b></a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <h3 class="card-title">Informasi Pengumuman</h3>
                    </div>
                    <div class="card-body">
                        <p>Selamat datang di sistem HRIS. Data Anda telah tersinkronisasi dengan Admin untuk kebutuhan absensi dan penggajian.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection