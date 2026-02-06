<h3> Data user </h3>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th><a href="{{route('users.create')}}"> Tambah User </a></th>
</tr>
</thead>
<tbody>
    @foreach($datauser as $du)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$du->name}}</td>
        <td>{{$du->email}}</td>
        <td>{{$du->role}}</td>

       <td> <form action="{{route('users.destroy',$du->user_id)}}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus User ini permanen?')">
        Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
