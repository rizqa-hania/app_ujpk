<h3>Data Komponen Gaji</h3>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Komponen</th>
            <th>Tipe Komponen</th>
            <th>Tipe Perhitungan</th>
            <th>Nilai</th>
            <th>Status</th>
            <th>
                <a href="{{ route('komponen.create') }}">+ Komponen</a>
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($komponen as $v)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $v->kode }}</td>
        <td>{{ $v->komponen }}</td>
        <td>{{ $v->tipe }}</td>
        <td>
            {{ $v->tipe_penghitungan == 'persen' ? 'Persentase' : 'Tetap' }}
        </td>
        <td>
            @if($v->tipe_penghitungan == 'persen')
               {{ $v->nilai }} %
            @else
                Rp {{ number_format($v->nilai, 0, ',', '.') }}
            @endif
        </td>
        <td>
            @if($v->status == 0)
            <form action="{{ route('komponen.aktif', $v->kode) }}" method="POST" style="display:inline">
                    @csrf 
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Aktifkan komponen ini?')">Aktifkan</button>
                </form>

                <form action="{{ route('komponen.nonaktif', $v->kode) }}" method="POST" style="display:inline">
                    @csrf 
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Nonaktifkan komponen ini?')">Nonaktifkan</button>
                </form>

            @elseif($v->status == 1)
            Aktif
                <form action="{{ route('komponen.nonaktif', $v->kode) }}" method="POST" style="display:inline">
                    @csrf 
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Nonaktifkan komponen ini?')">Nonaktifkan</button>
                </form>

            @else
                <form action="{{ route('komponen.aktif', $v->kode) }}" method="POST" class="d-inline">
                    @csrf 
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Aktifkan komponen ini?')">Aktifkan</button>
                </form>
            Nonaktif
            @endif
        </td>
        <td>
            <form action="{{ route('komponen.destroy', $v->kode) }}" method="POST">
                @csrf 
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus komponen ini?')">Hapus</button>
            </form>
        </td>
    </tr>
     @endforeach
    </tbody>
</table>
