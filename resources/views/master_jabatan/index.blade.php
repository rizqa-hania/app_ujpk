@extends('template.admin.layout')
@section('content')



<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">
            
            <!-- Header -->
            <div class="card-header pr-3 pl-3 m-2">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title font-weight-bold mb-0">
                        Master Jabatan
                    </h3>

                    <a href="{{ route('master_jabatan.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Jabatan
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                <table id="table" class="table table-hover table-striped mb-0 ">
                    <thead class="bg-light">
                        <tr>
                            <th width="15%">Kode</th>
                            <th>Nama Jabatan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($jabatan as $j)
                        <tr>
                            <td>{{ $j->kode_jabatan }}</td>
                            <td>{{ $j->nama_jabatan }}</td>
                            <td class="text-center">
                                <form action="{{ route('master_jabatan.destroy', $j->jabatan_id) }}" 
                                      method="POST" 
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin menghapus jabatan ini permanen?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Data Jabatan belum tersedia.
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