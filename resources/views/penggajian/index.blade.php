@extends('template.layout')
@section('content')
<div class="row"> 
    <div class="col-12">
        <div class="card"> 
            <div class="card-header">
                <h3 class="card-title">Data Periode Penggajian</h3> 
                <div class="card-tools">
                    <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Periode Gaji</a>
                </div>
            </div>
            <div class="card-body table-responsive"> 
                <table id="table" class="table table-striped table-hover"> 
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode Bulan</th>
                            <th>Periode Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penggajian as $v)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v->periode_bulan }}</td>
                                <td>{{ $v->periode_tahun }}</td>
                                <td>
                                    @if($v->status == 'draft')
                                        <span class="badge badge-secondary">Draft</span>
                                    @elseif($v->status == 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($v->status == 'paid')
                                        <span class="badge badge-primary">Paid</span>
                                    @else
                                        <span class="badge badge-info">{{ $v->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('penggajian.destroy', $v->penggajian_id) }}" method="POST">
                                        {{ csrf_field() }}
                                        @method('DELETE')
                                        <a href="{{ route('detail.index', $v->penggajian_id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Detail</a>
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">
                                           <i class="fas fa-trash"> Hapus</i>
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
@push('js')
<script>
    new DataTable('#table');
</script>
@endpush