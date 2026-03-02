@extends('template.layout')
@section('content')


<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">Tambah Karyawan</div>

<form action="{{ route ('karyawan.tambah.store') }}" method="POST">
    {{ csrf_field( ) }}
            <div class="card-body">

 <div class="mb-3">
<label name="name" class="form-table">Nama: </label>
    <input type="text" class = "form-control" name="name" value="{{old('name')}}">
@if($errors->has('name'))
<span class="text-danger">{{ $errors->first('name')}}</span>   
@endif
 </div>

<div class="mb-3">
<label name="nip" class="form-table">NIP</label>
  <input type="text" class = "form-control" name="nip"
   value="{{old('nip
   ')}}">
</div>

<div class="mb-3">
<label name="password" class="form-table">Password</label>
<input type="text" class = "form-control" name="password"
   value="{{old('password
   ')}}">
</div>

<div class="mb-3">
  <label class="form-label">Role</label><br>

<input type="radio" class="btn-check" name="role" id="karyawan" value="karyawan" checked>
<label class="btn btn-outline-secondary btn-sm" for="karyawan">Karyawan</label>
</div>                     



  

            </div>
     <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a href="{{route('karyawan.tambah.index')}}" class="btn btn-success btn-sm">Kembali</a>
        </div>
</form>
        </div>
    </div>
</div>

@endsection




 
