@extends('template.layout')

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

        @if(Auth::user()->role == 'user')
            <a href="{{ route('izin.create') }}" class="btn btn-primary">
                Ajukan Izin
            </a>
        @endif
    </div>

    <!-- FORM SEARCH -->
    <form method="GET" action="{{ route('izin.index') }}">
        <div class="input-group input-group-sm" style="max-width: 300px;">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari user / jenis / status / tanggal..."
                   value="{{ request('search') }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">
                    Cari
                </button>

                <a href="{{ route('izin.index') }}"
                   class="btn btn-outline-secondary">
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
                        @if(Auth::user()->role == 'admin')
                            <th>User</th>
                        @endif
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($dataIzin as $item)
                <tr>

                    {{-- Kolom User (Admin Only) --}}
                    @if(Auth::user()->role == 'admin')
                        <td>{{ $item->user->name ?? '-' }}</td>
                    @endif

                    {{-- Kolom Jenis --}}
                    <td>
                        @if($item->jenis == 'izin')
                            <span class="badge badge-info">Izin</span>
                        @elseif($item->jenis == 'cuti')
                            <span class="badge badge-primary">Cuti</span>
                        @elseif($item->jenis == 'sakit')
                            <span class="badge badge-danger">Sakit</span>
                        @endif
                    </td>

                    {{-- Kolom Tanggal --}}
                    <td>
                        {{ $item->tanggal_mulai }} 
                        s/d 
                        {{ $item->tanggal_selesai }}
                    </td>

                    {{-- Kolom Keterangan --}}
                    <td>{{ $item->keterangan }}</td>

                    {{-- Kolom Status --}}
                    <td>
                        @if($item->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($item->status == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($item->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>

                    {{-- Kolom Aksi --}}
                    <td>

                        @if(Auth::user()->role == 'admin' && $item->status == 'pending')
                            <a href="{{ route('izin.approve',$item->izin_id) }}"
                            class="btn btn-sm btn-success">
                                Setuju
                            </a>

                            <a href="{{ route('izin.reject',$item->izin_id) }}"
                            class="btn btn-sm btn-danger">
                                Tolak
                            </a>
                        @endif

                        @if(Auth::user()->role == 'user' && $item->status == 'pending')
                            <form action="{{ route('izin.destroy',$item->izin_id) }}"
                                method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin hapus izin ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->role == 'admin' ? 6 : 5 }}" class="text-center">
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