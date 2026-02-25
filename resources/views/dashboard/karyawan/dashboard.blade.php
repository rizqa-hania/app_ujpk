@extends('template.karyawan.layout')

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Welcome Header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                                alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">
                            {{ $karyawan->nama_lengkap ?? auth()->user()->name }}
                        </h3>
                        <p class="text-muted text-center">
                            {{ $karyawan->jabatan->nama_jabatan ?? 'Belum ada jabatan' }}
                        </p>
                        <p class="text-muted text-center">
                            {{ $karyawan->nip ?? '-' }}
                            </p>

                        <a href="{{ route('karyawan.profile') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-edit mr-1"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

            
        

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ ucfirst($karyawan->status_karyawan ?? 'aktif') }}</h3>
                        <p>Status</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Info -->
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i> 
                        </h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('karyawan.profile') }}" class="btn btn-app btn-block">
                            <i class="fas fa-user-edit"></i> Edit Profil
                        </a>
                        <a href="{{ route('absensi.index') }}" class="btn btn-app btn-block">
                            <i class="fas fa-clock"></i> Absensi
                        </a>
                        <a href="{{ route('lembur.index') }}" class="btn btn-app btn-block">
                            <i class="fas fa-overtime"></i> Lembur
                        </a>
                    </div>
                </div>
            </div>

       
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
            {{ session('success') }}
        </div>
        @endif
    </div>
</section>

@endsection
