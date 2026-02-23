@extends('template.layout')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3> Master Project </h3></div>
       <div class="card-body">
<table class="table table-striped table-hover">
   


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
    <button type="submit" onclick="return confirm('Yakin menghapus Project ini permanen?')"class="btn btn-danger btn-sm">
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


