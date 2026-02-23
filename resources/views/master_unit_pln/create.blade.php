@extends('template.layout')
@section('content')


<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Tambah Unit  </div>

<form action="{{ route ('master_unit_pln.store') }}" method="POST">
    {{ csrf_field( ) }}
            <div class="card-body">

 <div class="mb-3">
<label name="nama_unit" class="form-table">Unit: </label>
    <input type="text" class = "form-control" name="nama_unit" value="{{old('nama_unit')}}">
@if($errors->has('nama_unit'))
<span class="text-danger">{{ $errors->first('nama_unit')}}</span>   
@endif
 </div>

<div class="mb-3">
<label name="kode_unit" class="form-table">Kode Unit:</label>
  <input type="text" class = "form-control" name="kode_unit"
   value="{{old('kode_unit')}}">
</div>

     <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{route('master_unit_pln.index')}}" class="btn btn-success btn-sm">Kembali</a>
        </div>
</form>
        </div>
    </div>
</div>
</div>

@endsection




 
