@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold mb-0">
                        Data Admin
                    </h3>

                    <a href="{{ route('admin.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($admins as $e)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $e->name }}</td>
                            <td>{{ $e->email }}</td>
                            <td>
                                <span class="badge badge-danger">
                                    {{ $e->role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.destroy', $e->user_id) }}" 
                                      method="POST" 
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Apakah kamu yakin ingin menghapus user ini?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Data admin belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>

@endsection