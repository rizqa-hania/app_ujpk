<table border="1" cellpadding="5">
    <tr>
        <th>NIP</th>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Masuk</th>
        <th>Pulang</th>
        <th>Metode</th>
        <th>Status</th>
        <th>Verifikasi</th>
    </tr>

    @foreach($data as $a)
    <tr>
        <td>{{ $a->nip }}</td>
        <td>{{ $a->karyawan->nama ?? '-' }}</td>
        <td>{{ $a->tanggal }}</td>
        <td>{{ $a->jam_masuk ?? '-' }}</td>
        <td>{{ $a->jam_pulang ?? '-' }}</td>
        <td>{{ strtoupper($a->metode_absensi ?? '-') }}</td>
        <td>{{ $a->status }}</td>
        <td>{{ $a->verifikasi ?? '-' }}</td>
    </tr>
    @endforeach
</table>
