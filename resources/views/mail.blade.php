<h3>Notifikasi {{ $tipe }}</h3>

<p>Nama : {{ $nama ?? '-' }}</p>

@if(!empty($jenis) && $tipe == 'Izin')
<p>Jenis : {{ ucfirst($jenis) }}</p>
@endif

<p>Tanggal : {{ $mulai ?? '-' }} sampai {{ $selesai ?? '-' }}</p>

@if($tipe == 'Lembur' && !empty($jam_mulai) && !empty($jam_selesai))
<p>Jam : {{ $jam_mulai }} - {{ $jam_selesai }}</p>
@endif

<p>Keterangan : {{ $keterangan ?? '-' }}</p>

@if($status == 'pengajuan')
<p>Status : Pengajuan {{ $tipe }} baru.</p>
@elseif($status == 'disetujui')
<p>Status : <b style="color:green;">{{ $tipe }} Disetujui</b></p>
@elseif($status == 'ditolak')
<p>Status : <b style="color:red;">{{ $tipe }} Ditolak</b></p>
@endif