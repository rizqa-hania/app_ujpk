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
<section class="content">
<div class="container-fluid">

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
                        <a href="{{ route('karyawan.profile') }}"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-user-edit mr-1"></i> Edit
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- STATUS CARD -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="small-box"
                 style="background: linear-gradient(135deg,#f7971e,#ffd200); color:white;">
                <div class="inner">
                    <h4 class="font-weight-bold">
                        {{ ucfirst($karyawan->status_karyawan ?? 'Aktif') }}
                    </h4>
                    <p>Status Karyawan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK MENU (Style App) -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0 font-weight-bold">
                <i class="fas fa-th-large mr-1"></i> Menu Cepat
            </h5>
        </div>

        <div class="card-body">
            <div class="row text-center">

                <div class="col-6 col-md-3 mb-4">
                    <a href="{{ route('karyawan.profile') }}" class="text-dark">
                        <div class="p-3 rounded bg-light elevation-1">
                            <i class="fas fa-user-edit fa-2x text-primary mb-2"></i>
                            <div>Edit Profil</div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-md-3 mb-4">
                    <a href="{{ route('absensi.index') }}" class="text-dark">
                        <div class="p-3 rounded bg-light elevation-1">
                            <i class="fas fa-clock fa-2x text-success mb-2"></i>
                            <div>Absensi</div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-md-3 mb-4">
                    <a href="{{ route('lembur.create') }}" class="text-dark">
                        <div class="p-3 rounded bg-light elevation-1">
                            <i class="fas fa-business-time fa-2x text-warning mb-2"></i>
                            <div>Lembur</div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-md-3 mb-4">
                    <a href="{{ route('izin.create') }}" class="text-dark">
                        <div class="p-3 rounded bg-light elevation-1">
                            <i class="fas fa-envelope-open-text fa-2x text-danger mb-2"></i>
                            <div>Izin</div>
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