<h3> TAD </h3>

<table border="1" cellpadding="5">
<thead>
    <tr>
        <th>Kode</th>
        <th>TAD</th>
        <th><a href="{{route('master_tad.create')}}">Tambah TAD</a></th>
</tr>
</thead>
<tbody>
@foreach($tad as $t)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$t->kode_tad}}</td>
    <td>{{$t->nama_tad}}</td>
<td> <form action="{{route('master_tad.destroy',$t->tad_id)}}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus TAD ini permanen?')">
        Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>

