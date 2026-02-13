@extends('template.layout')

@section('content')
<div class="row"> <div class="col-12">
        <div class="card mt-3"> <div class="card-header">
                <h3 class="card-title">Gaji</h3> <div class="card-tools">
                    <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Penggajian
                    </a>
                </div>
            </div>
            
            <div class="card-body table-responsive p-0"> <table class="table table-hover text-nowrap"> <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Periode Bulan</th>
                            <th>Periode Tahun</th>
                            <th>Status</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penggajian as $v)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v->periode_bulan }}</td>
                                <td>{{ $v->periode_tahun }}</td>
                                <td>
                                    <span class="badge {{ $v->status == 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $v->status }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('penggajian.destroy', $v->penggajian_id) }}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection