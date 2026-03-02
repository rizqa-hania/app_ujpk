@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"> Tampilkan data karyawan</div>
            <div class="card-body">

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>NO</th>
            <th>Username</th>
            <th>NIP</th>
            <th>Role</th>
            <th><a href="{{ route('karyawan.tambah.create')}}"class="btn btn-primary btn-sm">Tambah Karyawan</a>
        </tr>
    </thead>
    <tbody>
        @foreach ($karyawans as $a )
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->name }}</td>
            <td>{{ $a->nip }}</td>
            <td>{{$a->role}}</td>
            <td>
                <form action="{{ route('karyawan.tambah.destroy', $a->user_id) }}" method="POST">
                    {{csrf_field()}}
                    @method('DELETE')
                    <button type="submit"  onclick="return confirm('Apakah kamu yakin ingin menghapus karyawan ini?')" class="btn btn-danger btn-sm">Hapus</button>
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
















