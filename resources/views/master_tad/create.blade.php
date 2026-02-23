@extends('template.layout')
@section('content')


<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Tambah TAD </div>

<form action="{{ route ('master_tad.store') }}" method="POST">
    {{ csrf_field( ) }}
            <div class="card-body">

 <div class="mb-3">
<label name="nama_tad" class="form-table"> TAD: </label>
    <input type="text" class = "form-control" name="nama_tad" value="{{old('nama_tad')}}">
@if($errors->has('nama_tad'))
<span class="text-danger">{{ $errors->first('nama_tad')}}</span>   
@endif
 </div>

<div class="mb-3">
<label name="kode_tad" class="form-table">Kode TAD:</label>
  <input type="text" class = "form-control" name="kode_tad"
   value="{{old('kode_tad')}}">
</div>

     <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{route('master_tad.index')}}" class="btn btn-success btn-sm">Kembali</a>
        </div>
</form>
        </div>
    </div>
</div>
</div>

@endsection




 
