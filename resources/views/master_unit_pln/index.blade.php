@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3> Unit PLN </h3></div>
       <div class="card-body">
<table class="table table-striped table-hover">
   

<thead>
    <tr>
        <th>Kode</th>
        <th>Unit</th>
        <th><a href="{{route('master_unit_pln.create')}}">Tambah Unit</a></th>
</tr>
</thead>
<tbody>
@foreach($pln as $n)
<tr>
    <td>{{$n->kode_unit}}</td>
    <td>{{$n->nama_unit}}</td>
<td> <form action="{{route('master_unit_pln.destroy',$n->unitpln_id)}}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Yakin menghapus Unit ini permanen?')" class="btn btn-danger btn-sm" >
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





