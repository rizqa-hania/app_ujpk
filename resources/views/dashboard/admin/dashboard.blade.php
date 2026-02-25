@extends('template.layout')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $totalTad }}</h3>
                        <p>Total TAD</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('master_tad.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $totalJabatan }}</h3>
                        <p>Total Jabatan</p>
                    </div>
                    <div class="icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <a href="{{ route('master_jabatan.index') }}" class="small-box-footer">
            Lihat Data <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalProject }}</h3>
                        <p>Total Project</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <a href="{{ route('master_project.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalPendidikan }}</h3>
                            <p>Total Pendidikan</p>
                        </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="{{ route('master_pendidikan.index') }}" class="small-box-footer">
                    Lihat Data <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalUnitPln }}</h3>
                        <p>Total Unit PLN</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('master_unit_pln.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

             <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>{{ $totalSubUnit }}</h3>
                        <p>Total Sub Unit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('master-sub-unit.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalLembur }}</h3>
                        <p>Total Lembur</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('lembur.index') }}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
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

@endsection