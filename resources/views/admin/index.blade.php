@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"> Tampilkan data admin</div>
            <div class="card-body">

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>NO</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th><a href="{{ route('admin.create')}}"class="btn btn-primary btn-sm">Tambah Admin</a>
        </tr>
    </thead>
    <tbody>
        @foreach ($admins as $e )
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $e->name }}</td>
            <td>{{ $e->email }}</td>
            <td>{{$e->role}}</td>
            <td>
                <form action="{{ route('admin.destroy', $e->user_id) }}" method="POST">
                    {{csrf_field()}}
                    @method('DELETE')
                    <button type="submit"  onclick="return confirm('Are you sure you want to delete this users?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>           
             </td>
        </tr>
        
        @endforeach
    </tbody>
</table>
        </div>
    </div>
</div>
</div>
@endsection
















