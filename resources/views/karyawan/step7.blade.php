@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 7 - Bank & BPJS</h3>
        </div>

        <form action="{{ route('karyawan.storestep7') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <h5>Bank</h5>
                <div class="form-group">
                    <label>No. Rekening Bank</label>
                    <input type="text" name="no_rg_bank" class="form-control" value="{{ old('no_rg_bank', optional($karyawan)->no_rg_bank) }}">
                </div>
                <div class="form-group">
                    <label>Nama Bank</label>
                    <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', optional($karyawan)->nama_bank) }}">
                </div>
                <div class="form-group">
                    <label>File Buku Tabungan (PDF/Foto)</label>
                    <input type="file" name="file_buku_tabungan" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_buku_tabungan)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_buku_tabungan }}</small>
                    @endif
                </div>

                <h5>BPJS Kesehatan</h5>
                <div class="form-group">
                    <label>No. BPJS</label>
                    <input type="text" name="no_bpjs" class="form-control" value="{{ old('no_bpjs', optional($karyawan)->no_bpjs) }}">
                </div>
                <div class="form-group">
                    <label>File BPJS (PDF/Foto)</label>
                    <input type="file" name="file_bpjs" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_bpjs)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_bpjs }}</small>
                    @endif
                </div>

                <h5>BPJS Ketenagakerjaan</h5>
                <div class="form-group">
                    <label>No. BPJSTK</label>
                    <input type="text" name="no_bpjstk" class="form-control" value="{{ old('no_bpjstk', optional($karyawan)->no_bpjstk) }}">
                </div>
                <div class="form-group">
                    <label>File BPJSTK (PDF/Foto)</label>
                    <input type="file" name="file_bpjstk" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_bpjstk)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_bpjstk }}</small>
                    @endif
                </div>

                <h5>BPLK</h5>
                <div class="form-group">
                    <label>No. Rekening BPLK</label>
                    <input type="text" name="no_rek_bplk" class="form-control" value="{{ old('no_rek_bplk', optional($karyawan)->no_rek_bplk) }}">
                </div>
                <div class="form-group">
                    <label>File Buku BPLK (PDF/Foto)</label>
                    <input type="file" name="file_buku_bplk" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_buku_bplk)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_buku_bplk }}</small>
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
