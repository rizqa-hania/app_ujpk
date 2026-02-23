@extends('template.layout')
@section('content')


<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Tambah Pendidikan</div>

<form action="{{ route ('master_pendidikan.store') }}" method="POST">
    {{ csrf_field( ) }}
            <div class="card-body">

 <div class="mb-3">
<label name="nama_pendidikan" class="form-table">Pendidikan: </label>
    <input type="text" class = "form-control" name="nama_pendidikan" value="{{old('nama_pendidikan')}}">
@if($errors->has('nama_pendidikan'))
<span class="text-danger">{{ $errors->first('nama_pendidikan')}}</span>   
@endif
 </div>

<div class="mb-3">
<label name="kode_pendidikan" class="form-table">Kode Pendidikan:</label>
  <input type="text" class = "form-control" name="kode_pendidikan"
   value="{{old('kode_pendidikan')}}">
</div>

     <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{route('master_pendidikan.index')}}" class="btn btn-success btn-sm">Kembali</a>
        </div>
</form>
        </div>
    </div>
</div>
</div>

@endsection




 
