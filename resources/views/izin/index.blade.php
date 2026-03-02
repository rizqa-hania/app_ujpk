@extends('template.layout')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">

        <h5 class="mb-0">Data Izin</h5>

        {{-- Hanya USER yang bisa ajukan izin --}}
        @if(Auth::user()->role == 'user')
            <a href="{{ route('izin.create') }}" class="btn btn-primary">
                Ajukan Izin
            </a>
        @endif

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
        </div>

    </div>
</div>

@endsection