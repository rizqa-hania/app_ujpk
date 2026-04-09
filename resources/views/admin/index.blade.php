@extends('template.admin.layout')
@section('content')

<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-weight-bold">
                        Data Admin
                    </h4>

                    <a href="{{ route('admin.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <table id="table" class="table table-hover">

                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th class="text-center">Email</th>
                            <th width="10%" class="text-center">Role</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($admins as $e)
                        <tr>

                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $e->name }}</td>
                            <td class="text-center">{{ $e->email }}</td>

                            <td class="text-center">
                                <span class="badge badge-danger">
                                    {{ ucfirst($e->role) }}
                                </span>
                            </td>

                            <td class="text-center">

                                <form action="{{ route('admin.destroy', $e->user_id) }}" 
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                     <button type="submit"
                                        onclick="return confirm('Apakah kamu yakin ingin menghapus Admin ini?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Data admin belum tersedia
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