@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 5 - Pendidikan</h3>
        </div>

        <form action="{{ route('karyawan.storestep5') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan_id" class="form-control" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach($pendidikan as $pen)
                            <option value="{{ $pen->pendidikan_id }}" {{ old('pendidikan_id', optional($karyawan)->pendidikan_id) == $pen->pendidikan_id ? 'selected' : '' }}>
                                {{ $pen->nama_pendidikan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Universitas/Sekolah</label>
                    <input type="text" name="nama_perguruan" class="form-control" value="{{ old('nama_perguruan', optional($karyawan)->nama_perguruan) }}">
                </div>

                <div class="form-group">
                    <label>File Ijazah (PDF/Foto)</label>
                    <input type="file" name="file_ijazah" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_ijazah)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_ijazah }}</small>
                    @endif
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Simpan & Lanjut</button>
            </div>
        </form>
    </div>
</div>

@endsection
