<h3> Master Project </h3>

<table border="1" cellpadding="5">
<thead>
    <tr>
        <th>Kode</th>
        <th>Project</th>
        <th><a href="{{route('master_project.create')}}">Tambah Project</a></th>
</tr>
</thead>
<tbody>
@foreach($project as $p)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$p->kode_project}}</td>
    <td>{{$p->nama_project}}</td>
<td> <form action="{{route('master_project.destroy',$p->project_id)}}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus Project ini permanen?')">
        Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>

