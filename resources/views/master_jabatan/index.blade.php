@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3>Master Jabatan</h3></div>
       <div class="card-body">
<table class="table table-striped table-hover">
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
    <button type="submit" onclick="return confirm('Yakin menghapus jabatan ini Permnen?')" class="btn btn-danger btn-sm">
       Hapus</button>
</from>
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