@extends('template.admin.layout')
@section('content')


<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">

            <!-- Header -->
             <div class="card-header pr-3 pl-3 m-2">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="card-title font-weight-bold mb-0">
            Data Master Project
        </h3>

        <a href="{{ route('master_project.create') }}" 
           class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Proyek
        </a>
    </div>

    <!-- Form Search -->
    <form method="GET" action="{{ route('master_project.index') }}">
        <div class="input-group input-group-sm" style="max-width: 300px;">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari kode / nama Project..."
                   value="{{ request('search') }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">
                    Cari
                </button>

                <a href="{{ route('master_project.index') }}"
                   class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </div>
    </form>

</div>


            <!-- Body -->
            <div class="card-body p-0">
                <table  id="table" class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="20%">Kode Proyek</th>
                            <th>Nama Proyek</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($project as $p)
                        <tr>
                            <td>{{ $p->kode_project }}</td>
                            <td>{{ $p->nama_project }}</td>
                            <td class="text-center">
                                <form action="{{ route('master_project.destroy', $p->project_id) }}" 
                                      method="POST" 
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Yakin menghapus Project ini permanen?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Data Project belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="p-3">
                    {{ $project->withQueryString()->links() }}
                </div>
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