@extends('template.admin.layout')

@section('content')

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Data Izin</h5>

            @if(strtolower(Auth::user()->role ?? '') != 'admin')
                <a href="{{ route('izin.create') }}" class="btn btn-primary">
                    Ajukan Izin
                </a>
            @endif
        </div>

        <!-- SEARCH -->
        <form method="GET" action="{{ route('izin.index') }}">
            <div class="input-group input-group-sm" style="max-width:300px">

                <input 
                    type="text" 
                    name="search"
                    class="form-control"
                    placeholder="Cari user / jenis / status / tanggal..."
                    value="{{ request('search') }}"
                >

                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Cari</button>

                    <a href="{{ route('izin.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="thead-light">
                    <tr>

                        @if(strtolower(Auth::user()->role ?? '') == 'admin')
                        <th>Nama Karyawan</th>
                        @endif
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                       

                        @if(strtolower(Auth::user()->role ?? '') == 'admin')
                        <th width="200">Aksi</th>
                        @endif

                    </tr>
                </thead>

                <tbody>

                    @forelse($dataIzin as $item)
                    <tr>

                       
                        @if(strtolower(Auth::user()->role ?? '') == 'admin')
                        <td>{{ $item->user->karyawan->nama_lengkap ?? $item->user->name ?? '-' }}</td>
                        @endif

                        <td>
                            @if($item->jenis == 'izin')
                                <span class="badge badge-info">Izin</span>
                            @elseif($item->jenis == 'cuti')
                                <span class="badge badge-primary">Cuti</span>
                            @elseif($item->jenis == 'sakit')
                                <span class="badge badge-danger">Sakit</span>
                            @endif
                        </td>

                        <td>
                            {{ $item->tanggal_mulai }} 
                            s/d 
                            {{ $item->tanggal_selesai }}
                        </td>

                        <td>
                            {{ $item->keterangan }}
                        </td>

                        <td>
                            @if($item->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($item->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($item->status == 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>

                        @php
                            $role = strtolower(Auth::user()->role ?? '');
                        @endphp
                        @if($role == 'admin')
                        <td>
                            @if($item->status == 'pending')

                                <form action="{{ route('izin.approve', $item->izin_id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('izin.reject', $item->izin_id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Tolak
                                    </button>
                                </form>

                            @else
                                <span class="text-muted">Tidak ada aksi</span>
                            @endif
                        </td>
                        @endif

                    </tr>

                    @empty
                    <tr>
                        <td colspan="{{ strtolower(Auth::user()->role ?? '') == 'admin' ? 6 : 4 }}" class="text-center">
                            Belum ada data izin
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">
                {{ $dataIzin->withQueryString()->links() }}
            </div>

        </div>

    </div>

</div>

@endsection