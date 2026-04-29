@extends('template.admin.layout')
@section('content')

<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-weight-bold">
                        Data Karyawan
                    </h4>

                    <a href="{{ route('karyawan.tambah.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Karyawan
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <table id="table"  class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th class="text-center">Username</th>
                            <th  class="text-center">NIP</th>
                            <th  class="text-center">Email</th>
                            <th class="text-center" width="10%">Role</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($karyawans as $a)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $a->name }}</td>
                            <td  class="text-center">{{ $a->nip }}</td>
                            <td class="text-center">{{ $a->email }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">
                                    {{ ucfirst($a->role) }}
                                </span>
                            </td>

                            <td class="text-center">

                                <form action="{{ route('karyawan.tambah.destroy', $a->user_id) }}" 
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Apakah kamu yakin ingin menghapus karyawan ini?')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> 
                                    </button>
                                </form>

                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Data karyawan belum tersedia
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