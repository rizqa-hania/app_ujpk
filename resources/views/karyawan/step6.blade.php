@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 6 - Identitas Resmi</h3>
        </div>

        <form action="{{ route('karyawan.storestep6') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <h5>KTP</h5>
                <div class="form-group">
                    <label>No. KTP</label>
                    <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp', optional($karyawan)->no_ktp) }}">
                </div>
                <div class="form-group">
                    <label>File KTP (PDF/Foto)</label>
                    <input type="file" name="file_ktp" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_ktp)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_ktp }}</small>
                    @endif
                </div>

                <h5>Kartu Keluarga</h5>
                <div class="form-group">
                    <label>No. KK</label>
                    <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', optional($karyawan)->no_kk) }}">
                </div>
                <div class="form-group">
                    <label>File KK (PDF/Foto)</label>
                    <input type="file" name="file_kk" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_kk)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_kk }}</small>
                    @endif
                </div>

                <h5>NPWP</h5>
                <div class="form-group">
                    <label>No. NPWP</label>
                    <input type="text" name="no_npwp" class="form-control" value="{{ old('no_npwp', optional($karyawan)->no_npwp) }}">
                </div>
                <div class="form-group">
                    <label>File NPWP (PDF/Foto)</label>
                    <input type="file" name="file_npwp" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_npwp)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_npwp }}</small>
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
