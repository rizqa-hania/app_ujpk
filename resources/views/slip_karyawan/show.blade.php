@extends('template.karyawan.layout')
@section('content')
<div class="row no-print">
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
            <div class="card-footer text-right p-3">
                <a href="{{ route('periode_karyawan.index') }}" class="btn btn-outline-secondary btn-sm mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('slip_karyawan.pdf', $detail->penggajian_id) }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-download mr-1"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Area khusus cetak, disembunyikan di layar --}}
<div id="print-area" style="display:none;">
    <div class="slip-header">
        <h2>SLIP GAJI KARYAWAN</h2>
        <p>PT UJPK INDONESIA</p>
        <small>Periode: {{ $detail->penggajian->periode_bulan }} {{ $detail->penggajian->periode_tahun }}</small>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">NIP</td>
            <td width="35%">: {{ $detail->karyawan->nip }}</td>
            <td width="15%">Jabatan</td>
            <td width="35%">: {{ $detail->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: {{ $detail->karyawan->nama_lengkap }}</td>
            <td>Status</td>
            <td>: {{ $detail->karyawan->status_karyawan }}</td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td width="48%" style="vertical-align: top;">
                <div class="section-title">A. PENDAPATAN</div>
                <table class="content-table">
                    @foreach($detail->detailKomponen->where('tipe', 'pendapatan') as $item)
                    <tr>
                        <td>{{ $item->komponen->komponen ?? $item->kode }}</td>
                        <td class="text-right">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total Pendapatan (A)</td>
                        <td class="text-right">Rp {{ number_format($detail->total_pendapatan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
            <td width="4%"></td>
            <td width="48%" style="vertical-align: top;">
                <div class="section-title">B. POTONGAN</div>
                <table class="content-table">
                    @foreach($detail->detailKomponen->where('tipe', 'potongan') as $item)
                    <tr>
                        <td>{{ $item->komponen->komponen ?? $item->kode }}</td>
                        <td class="text-right">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total Potongan (B)</td>
                        <td class="text-right">Rp {{ number_format($detail->total_potongan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="grand-total">
        <table width="100%">
            <tr>
                <td class="grand-total-label">GAJI BERSIH</td>
                <td class="text-right">
                    <div class="grand-total-value">Rp {{ number_format($detail->gaji_bersih, 0, ',', '.') }}</div>
                    <span class="terbilang">Terbilang: {{ $terbilang }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="footer-sign">
        <tr>
            <td class="signature-box">
                <p>Penerima,</p>
                <br><br><br>
                <p><strong>( {{ $detail->karyawan->nama_lengkap }} )</strong></p>
            </td>
            <td></td>
            <td class="signature-box">
                <p>Jakarta, {{ date('d F Y') }}</p>
                <p>Hormat kami,</p>
                <br><br><br>
                <p><strong>( Finance PT UJPK )</strong></p>
            </td>
        </tr>
    </table>
</div>

<style>
    @media print {
        /* Sembunyikan semua elemen halaman saat cetak */
        body * {
            visibility: hidden !important;
        }
        /* Tampilkan hanya area cetak */
        #print-area,
        #print-area * {
            visibility: visible !important;
        }
        #print-area {
            display: block !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            padding: 20px !important;
            font-family: Arial, sans-serif !important;
            font-size: 12px !important;
            color: #333 !important;
            background: white !important;
        }
        /* Style khusus print untuk elemen di dalam print-area */
        #print-area .slip-header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        #print-area .slip-header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        #print-area .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        #print-area .info-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        #print-area .section-title {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            margin-top: 15px;
            text-transform: uppercase;
        }
        #print-area .content-table {
            width: 100%;
            border-collapse: collapse;
        }
        #print-area .content-table td {
            padding: 5px 0;
        }
        #print-area .text-right {
            text-align: right;
        }
        #print-area .total-row {
            font-weight: bold;
            border-top: 1px solid #333;
        }
        #print-area .grand-total {
            background-color: #f5f5f5;
            padding: 15px;
            border: 1px solid #ddd;
            margin-top: 30px;
        }
        #print-area .grand-total-label {
            font-size: 16px;
            font-weight: bold;
        }
        #print-area .grand-total-value {
            font-size: 18px;
            font-weight: bold;
        }
        #print-area .terbilang {
            font-style: italic;
            color: #666;
            display: block;
            margin-top: 5px;
        }
        #print-area .footer-sign {
            margin-top: 50px;
            width: 100%;
        }
        #print-area .signature-box {
            text-align: center;
            width: 200px;
        }
    }
</style>
@endsection
