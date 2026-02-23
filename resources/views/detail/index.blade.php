@extends('template.layout')
@section('content')
<div class="row"> 
    <div class="col-12">
        <div class="card"> 
            <div class="card-header">
                <h3 class="card-title">Detail Penggajian</h3><br>
                <p>Periode: {{ $penggajian->periode_bulan }} / {{ $penggajian->periode_tahun }}</p>
                <div class="card-tools">
                    <a href="{{ route('detail.create', $penggajian->penggajian_id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Detail Penggajian
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive"> 
                <table class="table table-stripped table-hover"> 
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Total Pendapatan</th>
                            <th>Total Potongan</th>
                            <th>Gaji Bersih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detail as $v)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v->karyawan->nip ?? '-' }}</td>
                                <td>{{ $v->total_pendapatan }}</td>
                                <td>{{ $v->total_potongan }}</td>
                                <td>{{ $v->gaji_bersih }}</td>
                                <td>
                                    <span class="badge {{ $v->status == 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $v->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('detail.show', $v->detail_id) }}" class="btn btn-info btn-sm" title="Slip Gaji">
                                            <i class="fas fa-file-invoice"></i> Slip Gaji
                                        </a>
                                        <form action="{{ route('detail.destroy', $v->detail_id) }}" method="POST" class="d-inline">
                                            {{ csrf_field() }}
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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