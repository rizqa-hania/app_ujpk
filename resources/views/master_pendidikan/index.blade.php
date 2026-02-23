@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

<h3> Pendidikan</h3></div>
       <div class="card-body">
<table class="table table-striped table-hover">

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
    <button type="submit" onclick="return confirm('Yakin menghapus pendidikan ini permanen?')" class="btn btn-denger btn-m">
        Hapus</button>
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







