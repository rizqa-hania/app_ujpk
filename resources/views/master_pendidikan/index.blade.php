<h3> Pendidikan</h3>
<table border="1" cellpadding="5">
<thead>
    <tr>
        <th>Kode</th>
        <th>Pendidikan</th>
        <th><a href="{{route('master_pendidikan.create')}}"> Tambah Pendidikan</a></th>
</tr>
</thead>
<tbody>
@foreach($pendidikan as $d)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$d->kode_pendidikan}}</td>
    <td>{{$d->nama_pendidikan}}</td>
    <td> <form action="{{route('master_pendidikan.destroy',$d->pendidikan_id)}}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus pendidikan ini permanen?')">
        Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>