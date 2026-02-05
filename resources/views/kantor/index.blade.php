<h2>Data Kantor</h2>

<a href="{{ route('kantor.create') }}">Tambah Kantor</a>

<br><br>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Radius</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $k)
    <tr>
        <td>{{ $k->nama_kantor }}</td>
        <td>{{ $k->alamat }}</td>
        <td>{{ $k->latitude }}</td>
        <td>{{ $k->longitude }}</td>
        <td>{{ $k->radius_meter }}</td>
        <td>
            <form method="POST" action="{{ route('kantor.destroy', $k->kantor_id) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
