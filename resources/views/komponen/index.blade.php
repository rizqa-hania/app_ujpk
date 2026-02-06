<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Data Komponen Gaji</h5>
            <a href="{{ route('komponen.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> + Tambah Komponen
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">No</th>
                            <th>Kode</th>
                            <th>Komponen</th>
                            <th>Tipe</th>
                            <th>Perhitungan</th>
                            <th>Nilai</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komponen as $v)
                        <tr>
                            <td class="px-3 text-muted">{{ $loop->iteration }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $v->kode }}</span></td>
                            <td class="fw-semibold">{{ $v->komponen }}</td>
                            <td>{{ ucfirst($v->tipe) }}</td>
                            <td>
                                {{ $v->tipe_penghitungan == 'persen' ? 'Persentase' : 'Tetap' }}
                            </td>
                            <td class="fw-bold text-dark">
                                @if($v->tipe_penghitungan == 'persen')
                                    <span class="text-primary">{{ $v->nilai }}%</span>
                                @else
                                    Rp {{ number_format($v->nilai, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($v->status == 1)
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3">Aktif</span>
                                @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @if($v->status == 1)
                                        <form action="{{ route('komponen.nonaktif', $v->kode) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn btn-outline-warning" onclick="return confirm('Nonaktifkan komponen ini?')">
                                                Matikan
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('komponen.aktif', $v->kode) }}" method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Aktifkan komponen ini?')">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('komponen.destroy', $v->kode) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin hapus komponen ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>