@extends('template.layout')
@section('content')

<!-- Tombol Kembali -->
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
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title font-weight-bold mb-0">
                        Data Pendidikan
                    </h3>

                    <a href="{{ route('master_pendidikan.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Pendidikan
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="20%">Kode Pendidikan</th>
                            <th>Nama Pendidikan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pendidikan as $d)
                        <tr>
                            <td>{{ $d->kode_pendidikan }}</td>
                            <td>{{ $d->nama_pendidikan }}</td>
                            <td class="text-center">
                                <form action="{{ route('master_pendidikan.destroy', $d->pendidikan_id) }}" 
                                      method="POST" 
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin menghapus pendidikan ini permanen?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Data Pendidikan belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>
@push('js')
<script>
    new DataTable('#table');
</script>
@endpush
@endsection