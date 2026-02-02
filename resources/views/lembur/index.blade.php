<h4>Data Lembur</h4>

<p>
    <a href="{{ route('lembur.create') }}">Ajukan Lembur</a>
</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>NIP</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->nip }}</td>
            <td>
                {{ $row->tanggal_mulai }} s/d {{ $row->tanggal_selesai }}
            </td>
            <td>
                {{ $row->jam_mulai }} - {{ $row->jam_selesai }}
            </td>
            <td>{{ $row->status }}</td>
            <td>{{ $row->keterangan }}</td>
            <td>
                @if($row->status == 'pending')
                <form action="{{ route('lembur.status', $row->lembur_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <select name="status">
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <br><br>

                    <input type="text" name="keterangan" placeholder="Keterangan">
                    <br><br>

                    <button type="submit">Simpan</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
