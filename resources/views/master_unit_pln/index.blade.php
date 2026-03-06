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
                        Data Unit PLN
                    </h3>

                    <a href="{{ route('master_unit_pln.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Unit
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                <table id="table" class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="20%">Kode Unit</th>
                            <th>Nama Unit</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pln as $n)
                        <tr>
                            <td>{{ $n->kode_unit }}</td>
                            <td>{{ $n->nama_unit }}</td>
                            <td class="text-center">
                                <form action="{{ route('master_unit_pln.destroy', $n->unitpln_id) }}" 
                                      method="POST" 
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin menghapus Unit ini permanen?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Data Unit belum tersedia.
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