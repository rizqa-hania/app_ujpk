<h3>Display Data Komponen</h3>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Penggajian</th>
            <th>Komponen</th>
            <th>Tipe Komponen</th>
            <th>Tipe Penghitungan</th>
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
            <td>{{ $v->name }}</td>
            <td>{{ $v->tipe }}</td>
            <td>{{ $v->tipe_penghitungan }}</td>
            <td>{{ $v->nilai }}</td>
            <td>
                <a href="{{ route('komponen.edit', $v->kode_id) }}">Edit</a>

                @if($v->is_active == 1)
                <form action="{{ route('komponen.nonaktif', $v->kode_id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Nonaktifkan data ini?')">Nonaktif</button>
                </form>
                @else
                <form action="{{ route('komponen.aktif', $v->kode_id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" onclick="return confirm('Aktifkan data ini?')">Aktif</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>