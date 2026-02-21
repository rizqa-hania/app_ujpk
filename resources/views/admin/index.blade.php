<h2>Data Admin</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif


<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th><a href="{{ route('admin.create') }}">Tambah User</a>
</th>
    </tr>

    @foreach($admins as $index => $admin)
    <tr>
        <td>{{ $index+1 }}</td>
        <td>{{ $admin->name }}</td>
        <td>{{ $admin->email }}</td>
        <td>{{ $admin->role }}</td>
        <td>
           <form action="{{ route('admin.destroy', $admin->user_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>