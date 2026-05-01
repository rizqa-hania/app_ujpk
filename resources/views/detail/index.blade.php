@extends('template.admin.layout')
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
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <table id="table" class="table table-stripped table-hover"> 
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
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
                                <td>{{ $v->karyawan->nama_lengkap ?? '-' }}</td>
                                <td>Rp {{ number_format($v->total_pendapatan, 0, ',', '.') }}</td>
                                <td>
                                    @if($v->total_pendapatan > 0)
                                        {{ number_format(($v->total_potongan / $v->total_pendapatan) * 100, 1) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td>Rp {{ number_format($v->gaji_bersih, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('detail.show', $v->detail_id) }}" class="btn btn-info btn-sm mr-1" title="Lihat Slip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('slip.pdf', $v->detail_id) }}" class="btn btn-success btn-sm mr-1" title="Download Slip">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{ route('detail.destroy', $v->detail_id) }}" method="POST" class="d-inline">
                                            @csrf
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
@push('js')
<script>
    new DataTable('#table');
</script>
@endpush