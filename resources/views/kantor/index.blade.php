<h2>Data Kantor</h2>

<a href="{{ route('kantor.create') }}">Tambah Kantor</a>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Lat</th>
        <th>Long</th>
        <th>Radius</th>
    </tr>

    @foreach($data as $k)
    <tr>
        <td>{{ $k->nama_kantor }}</td>
        <td>{{ $k->alamat }}</td>
        <td>{{ $k->latitude }}</td>
        <td>{{ $k->longitude }}</td>
        <td>{{ $k->radius_meter }}</td>
    </tr>
    @endforeach
</table>
