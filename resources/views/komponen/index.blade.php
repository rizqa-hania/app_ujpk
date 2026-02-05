<h3>Display Data Komponen Gaji</h3>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Komponen</th>
            <th>Komponen</th>
            <th>Tipe Komponen</th>
            <th>Tipe Penghitungan</th>
            <th>Nominal/Persen</th>
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
                @if($v->tipe_penghitungan == 'persen')
                    Persentase
                @else
                    Tetap
                @endif
            </td>
            <td>
                @if($v->tipe_penghitungan == 'persen')
                    {{ $v->nilai }} %
                @else
                    Rp {{ number_format($v->nilai) }}
                @endif
            </td>
            <td>
                @if($v->status == 1)
                    Aktif
                @else
                    Nonaktif
                @endif
            </td>
            <td>
                @if($v->status == 1)
                    <form action="{{ route('komponen.nonaktif', $v->kode) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PUT')
                        <button onclick="return confirm('Nonaktifkan komponen ini?')">Nonaktifkan</button>
                    </form>
                @else
                    <form action="{{ route('komponen.aktif', $v->kode) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PUT')
                        <button onclick="return confirm('Aktifkan komponen ini?')">Aktifkan</button>
                    </form>
                @endif
                <form action="{{ route('komponen.destroy', $v->kode) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('YAkin hapus komponen ini?')">Hapus</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>