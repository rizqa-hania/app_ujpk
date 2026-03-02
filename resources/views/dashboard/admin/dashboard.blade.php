@extends('template.layout')

@section('content')

<section class="content">
    <div class="container-fluid">

        <div class="row">

            {{-- TAD --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-primary elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalTad }}</h3>
                        <p>Total TAD</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('master_tad.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Jabatan --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-indigo elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalJabatan }}</h3>
                        <p>Total Jabatan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('master_jabatan.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Project --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-success elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalProject }}</h3>
                        <p>Total Project</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <a href="{{ route('master_project.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Pendidikan --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-danger elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalPendidikan }}</h3>
                        <p>Total Pendidikan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <a href="{{ route('master_pendidikan.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Unit PLN --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-info elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalUnitPln }}</h3>
                        <p>Total Unit PLN</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('master_unit_pln.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Sub Unit --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-teal elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalSubUnit }}</h3>
                        <p>Total Sub Unit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <a href="{{ route('master-sub-unit.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

           {{-- Izin --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-warning elevation-3 dashboard-box">
                    <div class="inner">
                        <h3 class="text-white">{{ $totalIzin }}</h3>
                        <p class="text-white">Total Izin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-envelope-open-text text-white"></i>
                    </div>
                    <a href="{{ route('izin.index') }}" class="small-box-footer text-white">
                        Lihat Detail <i class="fas fa-arrow-circle-right text-white"></i>
                    </a>
                </div>
            </div>

            {{-- Lembur --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-secondary elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalLembur }}</h3>
                        <p>Total Lembur</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('lembur.index') }}" class="small-box-footer text-white">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Absensi --}}
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="small-box bg-dark elevation-3 dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalAbsensi ?? 0 }}</h3>
                        <p>Total Absensi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <a href="{{ route('absensi.index') }}" class="small-box-footer">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

               <div class="col-lg-3 col-6">
                <div class="small-box bg-indigo">
                    <div class="inner">
                        <h3>{{ $totalKaryawan }}</h3>
                        <p>Total Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.karyawan.index') 
                    }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.dashboard-box {
    transition: all 0.3s ease;
}

.dashboard-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.small-box h3 {
    font-weight: 700;
}

/*  Biar Lihat Detail putih */
.dashboard-box .small-box-footer {
    color: #ffffff !important;
}

.dashboard-box .small-box-footer:hover {
    color: #ffffff !important;
}
</style>

@endsection