@extends('template.admin.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title">Laporan Penggajian</h5>
            </div>
            <div class="card-body">
                <label for="" class="form-title">Silahkan Pilih Tanggal</label>

                <div class="d-flex align-items-center gap-2 mb-3">
                    <!--Form untuk Filter -->
                    <form action="{{ route('report.filter') }}" method="GET" class="d-flex">
                        <input type="text" id="date_range" name="date_range" class="form-control" placeholder="Select date range">
                        <button type="submit" class="btn btn-secondary ms-2">Filter</button>
                    </form>

                    <!--Form untuk Print -->
                    <form action="{{ route('report.generate') }}" method="POST" class="d-inline" target="_blank">
                        @csrf
                        <input type="hidden" id="start_date" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" id="end_date" name="end_date" value="{{ $endDate }}">
                        <button type="submit" target="_blank" class="btn btn-dark ms-2">Print</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>NIP</th>
                                <th>Nama Karyawan</th>
                                <th>Jabatan</th>
                                <th>Total Pendapatan</th>
                                <th>Total Potongan</th>
                                <th>Gaji Bersih</th>
                                <th>Tanggal Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @forelse($transaksi as $trans)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trans->penggajian->periode_bulan }} - {{ $trans->penggajian->periode_tahun }}</td>
                                <td>{{ $trans->karyawan->nip ?? '-' }}</td>
                                <td>{{ $trans->karyawan->nama_lengkap ?? '-' }}</td>
                                <td>{{ $trans->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                                <td>Rp {{ number_format($trans->total_pendapatan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($trans->total_potongan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($trans->gaji_bersih, 0, ',', '.') }}</td>
                                <td>{{ $trans->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('laporan.generateid', $trans->detail_id) }}" class="btn btn-danger btn-sm" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Cetak PDF
                                    </a>
                                </td>
                            </tr>
                            @php $grandTotal += $trans->gaji_bersih; @endphp
                            @empty
                            <tr>
                                <td colspan="10" align="center">Data Kosong</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot style="font-weight: bold;">
                            <tr>
                                <td colspan="7" style="text-align: center;">Total Seluruh Gaji Bersih</td>
                                <td colspan="3">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>  
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(function() {
  $('#date_range').daterangepicker({
    opens: 'left',
    locale: {
        format: 'YYYY-MM-DD'
    }
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    $('#start_date').val(start.format('YYYY-MM-DD'));
    $('#end_date').val(end.format('YYYY-MM-DD'));
  });
});
</script>
@endpush