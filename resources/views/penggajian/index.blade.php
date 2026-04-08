@extends('template.admin.layout')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Periode Penggajian</h3>
                <div class="card-tools">
                    <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Periode Gaji
                    </a>
                </div>
            </div>

            <div class="card-body">
                {{-- Filter Form --}}
                <form method="GET" action="{{ route('penggajian.index') }}" class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="dari_tanggal">Dari Tanggal</label>
                            <input type="date" name="dari_tanggal" id="dari_tanggal"
                                class="form-control"
                                value="{{ request('dari_tanggal') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="sampai_tanggal">Sampai Tanggal</label>
                            <input type="date" name="sampai_tanggal" id="sampai_tanggal"
                                class="form-control"
                                value="{{ request('sampai_tanggal') }}">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Table --}}
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode Bulan</th>
                                <th>Periode Tahun</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penggajian as $v)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $v->periode_bulan }}</td>
                                    <td>{{ $v->periode_tahun }}</td>
                                    <td>
                                        @switch($v->status)
                                            @case('draft')
                                                <span class="badge badge-secondary">Draft</span>
                                                @break
                                            @case('approved')
                                                <span class="badge badge-success">Approved</span>
                                                @break
                                            @case('paid')
                                                <span class="badge badge-primary">Paid</span>
                                                @break
                                            @default
                                                <span class="badge badge-info">{{ $v->status }}</span>
                                        @endswitch
                                    </td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('detail.index', $v->penggajian_id) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('penggajian.destroy', $v->penggajian_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data penggajian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    new DataTable('#table');
</script>
@endpush