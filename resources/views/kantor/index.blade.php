@extends('template.admin.layout')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card shadow">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Data Kantor</h5>

                <a href="{{ route('kantor.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Kantor
                </a>
            </div>

            <div class="card-body table-responsive">

                {{-- ALERT --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <table id="table" class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Radius (m)</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kantor }}</td>
                            <td>{{ $k->alamat ?? '-' }}</td>

                            {{-- ANTI ERROR ARRAY --}}
                            <td>
                                {{ is_array($k->latitude) ? $k->latitude[0] : $k->latitude }}
                            </td>
                            <td>
                                {{ is_array($k->longitude) ? $k->longitude[0] : $k->longitude }}
                            </td>

                            <td>{{ $k->radius_meter }}</td>

                            <td>
                                <form method="POST" action="{{ route('kantor.destroy', $k->kantor_id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus kantor ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data kantor
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

@push('js')
<script>
    new DataTable('#table');
</script>
@endpush