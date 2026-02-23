@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
<h3> TAD </h3></div>
       <div class="card-body">
<table class="table table-striped table-hover">
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
   
    <td>{{$t->kode_tad}}</td>
    <td>{{$t->nama_tad}}</td>
<td> <form action="{{route('master_tad.destroy',$t->tad_id)}}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus TAD ini permanen?')" class="btn btn-danger btn-sm">
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







