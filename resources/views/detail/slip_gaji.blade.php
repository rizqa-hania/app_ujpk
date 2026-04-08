@extends('template.admin.layout')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card shadow-sm border">
            <div class="card-header bg-white border-bottom text-center py-4">
                <h4 class="mb-0 font-weight-bold">SLIP GAJI KARYAWAN</h4>
                <p class="mb-0">PT UJPK INDONESIA</p>
                <small class="text-uppercase">Periode: {{ $detail->penggajian->periode_bulan }} {{ $detail->penggajian->periode_tahun }}</small>
            </div>
            <div class="card-body p-4">
                <table class="table table-sm table-borderless mb-4" style="width: 100%;">
                    <tr>
                        <td width="150">NIP</td>
                        <td width="350">: {{ $detail->karyawan->nip }}</td>
                        <td width="150">Jabatan</td>
                        <td>: {{ $detail->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Karyawan</td>
                        <td>: {{ $detail->karyawan->nama_lengkap }}</td>
                        <td>Status</td>
                        <td>: {{ $detail->karyawan->status_karyawan }}</td>
                    </tr>
                </table>

                <div class="row">
                    <div class="col-md-6 pr-md-4 border-right">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th colspan="2" class="border-bottom pb-1 mb-2">A. PENDAPATAN</th>
                            </tr>
                            @foreach($detail->detailKomponen->where('tipe', 'pendapatan') as $item)
                            <tr>
                                <td>{{ $item->komponen->komponen ?? $item->kode }}</td>
                                <td class="text-right">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="font-weight-bold border-top">
                                <td>Total Pendapatan (A)</td>
                                <td class="text-right">Rp {{ number_format($detail->total_pendapatan, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 pl-md-4">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th colspan="2" class="border-bottom pb-1 mb-2">B. POTONGAN</th>
                            </tr>
                            @foreach($detail->detailKomponen->where('tipe', 'potongan') as $item)
                            <tr>
                                <td>{{ $item->komponen->komponen ?? $item->kode }}</td>
                                <td class="text-right">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr class="font-weight-bold border-top">
                                <td>Total Potongan (B)</td>
                                <td class="text-right">Rp {{ number_format($detail->total_potongan, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-light border">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0 font-weight-bold">GAJI BERSIH</span>
                        <div class="text-right">
                            <span class="h5 mb-0 font-weight-bold text-primary">Rp {{ number_format($detail->gaji_bersih, 0, ',', '.') }}</span>
                            <br>
                            <small class="text-muted font-italic">Terbilang: {{ $terbilang }}</small>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer no-print text-right p-3">
                <a href="{{ route('laporan.generateid', $detail->detail_id) }}" class="btn btn-danger btn-sm" target="_blank" title="Cetak PDF">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
                {{-- Tombol cetak dihapus agar user bisa membuat custom button sendiri --}}
                <a href="{{ route('detail.index', $detail->penggajian_id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .main-sidebar, .main-header, .no-print, .card-footer, .navbar {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        body {
            background-color: white !important;
        }
    }
</style>
@endsection
