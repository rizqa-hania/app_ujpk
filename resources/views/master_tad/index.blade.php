@extends('template.layout')
@section('content')

<!-- Tombol Kembali (Terpisah) -->
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">
            
            <!-- Header -->
            <div class="card-header pr-3 pl-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="card-title font-weight-bold mb-0">
            Data TAD
        </h3>

        <a href="{{ route('master_tad.create') }}" 
           class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah TAD
        </a>
    </div>

    <form method="GET" action="{{ route('master_tad.index') }}">
        <div class="input-group input-group-sm" style="max-width: 300px;">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari kode / nama TAD..."
                   value="{{ request('search') }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">
                    Cari
                </button>

                <a href="{{ route('master_tad.index') }}"
                   class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

            <!-- Body -->
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="15%">Kode</th>
                            <th>Nama TAD</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($tad as $index => $t)
                        <tr>
                            <td>{{ $t->kode_tad }}</td>
                            <td>{{ $t->nama_tad }}</td>
                            <td class="text-center">
                                <form action="{{ route('master_tad.destroy', $t->tad_id) }}" 
                                      method="POST" 
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin menghapus TAD ini permanen?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Data TAD belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="p-3">
                    {{ $tad->withQueryString()->links() }}
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
<!-- -->