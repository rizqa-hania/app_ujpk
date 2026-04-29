<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji - {{ $detail->karyawan->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .section-title {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            margin-top: 15px;
            text-transform: uppercase;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
        }
        .content-table td {
            padding: 5px 0;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            border-top: 1px solid #333;
        }
        .grand-total {
            background-color: #f5f5f5;
            padding: 15px;
            border: 1px solid #ddd;
            margin-top: 30px;
        }
        .grand-total-label {
            font-size: 16px;
            font-weight: bold;
        }
        .grand-total-value {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .terbilang {
            font-style: italic;
            margin-top: 5px;
            display: block;
            color: #666;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="header">
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

    <table class="footer">
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
</body>
</html>
