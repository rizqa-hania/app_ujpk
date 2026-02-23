@extends('template.layout')
@section('content')


<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Tambah Project </div>

<form action="{{ route ('master_project.store') }}" method="POST">
    {{ csrf_field( ) }}
            <div class="card-body">

 <div class="mb-3">
<label name="nama_project" class="form-table">Jabatan: </label>
    <input type="text" class = "form-control" name="nama_project" value="{{old('nama_project')}}">
@if($errors->has('nama_jabatan'))
<span class="text-danger">{{ $errors->first('nama_jabatan')}}</span>   
@endif
 </div>

<div class="mb-3">
<label name="kode_project" class="form-table">Kode Project:</label>
  <input type="text" class = "form-control" name="kode_project"
   value="{{old('kode_project')}}">
</div>

     <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{route('master_project.index')}}" class="btn btn-success btn-sm">Kembali</a>
        </div>
</form>
        </div>
    </div>
</div>
</div>

@endsection




 
