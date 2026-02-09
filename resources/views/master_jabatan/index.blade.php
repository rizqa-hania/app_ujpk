<h3>Master Jabatan</h3>

<table border="1" cellpadding="5">
    <thead>
    <tr>
        <th>Kode</th>
        <th>Jabatan</th>
        <th><a href="{{route('master_jabatan.create')}}">Tambah Jabatan</a></th>
</tr>
</thead>
<tbody>
@foreach($jabatan as $j)
<tr>
    
<td>{{$j->kode_jabatan}}</td>
<td>{{$j->nama_jabatan}}</td>

<td>

<form action="{{route('master_jabatan.destroy', $j->jabatan_id )}}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus jabatan ini Permnen?')">
       Hapus</button>
</from>
</td>
</tr>
@endforeach
</tbody>
</table>