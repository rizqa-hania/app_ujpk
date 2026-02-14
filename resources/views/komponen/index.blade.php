@extends('template.layout')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Komponen Gaji</h3>
        <div class="card-tools">
            <a href="{{ route('komponen.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Komponen
            </a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-stripped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Komponen</th>
                    <th>Tipe Komponen</th>
                    <th>Tipe Penghitungan</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($komponen as $v)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $v->kode }}</td>
                    <td>{{ $v->komponen }}</td>
                    <td>{{ $v->tipe }}</td>
                    <td>{{ $v->tipe_penghitungan == 'persen' ? 'Persentase' : 'Tetap' }}</td>
                    <td>
                        @if($v->tipe_penghitungan == 'persen')
                            {{ $v->nilai }}%
                        @else
                            Rp {{ number_format($v->nilai, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if($v->status == 1)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            @if($v->status == 0 || $v->status == 2) {{-- Jika Nonaktif --}}
                                <form action="{{ route('komponen.aktif', $v->kode) }}" method="POST" class="mr-1">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Aktifkan komponen ini?')">Aktifkan</button>
                                </form>
                            @else {{-- Jika Aktif --}}
                                <form action="{{ route('komponen.nonaktif', $v->kode) }}" method="POST" class="mr-1">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Nonaktifkan komponen ini?')">Nonaktifkan</button>
                                </form>
                            @endif

                            <form action="{{ route('komponen.destroy', $v->kode) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus komponen ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection           