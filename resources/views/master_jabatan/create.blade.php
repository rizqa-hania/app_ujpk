@extends('template.layout')
@section('content')


<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Tambah Jabatan </div>

<form action="{{ route ('master_jabatan.store') }}" method="POST">
    {{ csrf_field( ) }}
            <div class="card-body">

 <div class="mb-3">
<label name="nama_jabatan" class="form-table">Jabatan: </label>
    <input type="text" class = "form-control" name="nama_jabatan" value="{{old('nama_jabatan')}}">
@if($errors->has('nama_jabatan'))
<span class="text-danger">{{ $errors->first('nama_jabatan')}}</span>   
@endif
 </div>

<div class="mb-3">
<label name="kode_jabatan" class="form-table">Kode Jabatan:</label>
  <input type="text" class = "form-control" name="kode_jabatan"
   value="{{old('kode_jabatan')}}" placeholder="Contoh: 03 untuk Satpam, 06 untuk Driver">
   <small class="text-muted">Masukkan kode jabatan (03=Satpam, 06=Driver)</small>
</div>

     <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{route('master_jabatan.index')}}" class="btn btn-success btn-sm">Kembali</a>
        </div>
</form>
        </div>
    </div>
</div>
</div>

@endsection




 
