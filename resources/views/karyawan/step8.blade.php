@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 8 - Dokumen</h3>
        </div>

        <form action="{{ route('karyawan.storestep8') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>File Surat Lamaran (PDF)</label>
                    <input type="file" name="file_surat_lamaran" class="form-control" accept="application/pdf,.pdf">
                    @if(optional($karyawan)->file_surat_lamaran)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_surat_lamaran }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>File CV (PDF)</label>
                    <input type="file" name="file_cv" class="form-control" accept="application/pdf,.pdf">
                    @if(optional($karyawan)->file_cv)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_cv }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>File Pakta Integritas (PDF)</label>
                    <input type="file" name="file_pakta_integritas" class="form-control" accept="application/pdf,.pdf">
                    @if(optional($karyawan)->file_pakta_integritas)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_pakta_integritas }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>File Data Consist (PDF)</label>
                    <input type="file" name="file_data_consist" class="form-control" accept="application/pdf,.pdf">
                    @if(optional($karyawan)->file_data_consist)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_data_consist }}</small>
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
