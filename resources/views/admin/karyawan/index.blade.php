@extends('template.layout')

@php
function getStatusBadge($isComplete) {
    if ($isComplete) {
        return '<span class="badge badge-success">Lengkap</span>';
    }
    return '<span class="badge badge-warning">Belum Lengkap</span>';
}
@endphp

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
        <div class="row">
            <div class="col-12">
                
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Karyawan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Unit PLN</th>
                                    <th>Sub Unit</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($karyawans as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @if($user->karyawan && $user->karyawan->foto_profil)
                                            <img src="{{ asset('storage/' . $user->karyawan->foto_profil) }}" 
                                                 alt="Foto" 
                                                 class="img-circle elevation-2" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" 
                                                 alt="Foto" 
                                                 class="img-circle elevation-2" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $user->karyawan->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $user->nip ?? '-' }}</td>
                                    <td>
                                        @if($user->karyawan && $user->karyawan->jabatan)
                                            {{ $user->karyawan->jabatan->nama_jabatan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->karyawan && $user->karyawan->unitpln)
                                            {{ $user->karyawan->unitpln->nama_unit }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->karyawan && $user->karyawan->subunit)
                                            {{ $user->karyawan->subunit->nama_sub_unit }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->karyawan)
                                            {!! getStatusBadge($user->karyawan->is_complete) !!}
                                        @else
                                            <span class="badge badge-secondary">Baru</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.karyawan.show', $user->user_id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data karyawan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>

@endsection
