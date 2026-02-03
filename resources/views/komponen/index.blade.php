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
            <th>
                <a href="{{ route('komponen.create') }}">+ Komponen</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($komponen as $v)
        <tr>
            <td>{{ $v->kode }}</td>
            <td>{{ $v->name }}</td>
            <td>{{ $v->tipe }}</td>
            <td>{{ $v->tipe_penghitungan }}</td>
            <td>{{ $v->nilai }}</td>
            <td>
                <form action="{{ route('komponen.destroy', $v->komponen_id) }}" method="POST" style="display:inline">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('komponen.edit', $v->komponen_id) }}">Edit</a>
                    <button type="submit" onclick="return conirm('Yakin hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>