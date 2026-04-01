<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rinci Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .user-section { margin-bottom: 30px; page-break-inside: avoid; }
        .user-info { background: #f4f4f4; padding: 8px; font-weight: bold; border: 1px solid #ddd; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        .text-left { text-align: left; }
        .bg-summary { background-color: #fafafa; font-weight: bold; }
        .status-badge { font-weight: bold; text-transform: capitalize; }
    </style>
</head>
<body>

<div class="header">
    <h2>LAPORAN RINCIAN ABSENSI KARYAWAN</h2>
    <p>Periode: {{ $periode }}</p>
</div>

@foreach($rekap as $index => $r)
<div class="user-section">
    <div class="user-info">
        {{ $index + 1 }}. Nama: {{ $r['nama'] }} | NIP: {{ $r['nip'] }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="15%">Hari</th>
                <th width="20%">Tanggal</th>
                <th width="15%">Jam Masuk</th>
                <th width="15%">Jam Pulang</th>
                <th width="20%">Keterangan/Status</th>
                <th width="15%">Lembur</th>
            </tr>
        </thead>
        <tbody>
            @forelse($r['details'] as $detail)
            <tr>
                <td>{{ \Carbon\Carbon::parse($detail->tanggal)->translatedFormat('l') }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $detail->jam_masuk ?? '--:--' }}</td>
                <td>{{ $detail->jam_pulang ?? '--:--' }}</td>
                <td class="status-badge">{{ $detail->status_final }}</td>
                <td>{{ $detail->lembur ? 'Ya' : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="color: red;">Tidak ada data absensi pada periode ini.</td>
            </tr>
            @endforelse
            
            <tr class="bg-summary">
                <td colspan="2">TOTAL RINGKASAN</td>
                <td>Hadir: {{ $r['total_hadir'] }}</td>
                <td>Izin: {{ $r['total_izin'] }}</td>
                <td>Alpha: {{ $r['total_alpha'] }}</td>
                <td>Lembur: {{ $r['total_lembur'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endforeach

<div style="margin-top: 30px; text-align: right;">
    <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    <br><br><br>
    <p>( Direktur )</p>
</div>

</body>
</html>