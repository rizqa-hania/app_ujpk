@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 4 - Data Kontak</h3>
        </div>

        <form action="{{ route('karyawan.storestep4') }}" method="POST">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>No. HP Utama</label>
                    <input type="text" name="no_HP_utama" class="form-control" value="{{ old('no_HP_utama', optional($karyawan)->no_HP_utama) }}">
                </div>

                <div class="form-group">
                    <label>No. HP Cadangan</label>
                    <input type="text" name="no_HP_cadangan" class="form-control" value="{{ old('no_HP_cadangan', optional($karyawan)->no_HP_cadangan) }}">
                </div>

                <div class="form-group">
                    <label>Email Pribadi</label>
                    <input type="email" name="email_pribadi" class="form-control" value="{{ old('email_pribadi', optional($karyawan)->email_pribadi) }}">
                </div>

                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', optional($karyawan)->instagram) }}">
                </div>

                <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" name="facebook" class="form-control" value="{{ old('facebook', optional($karyawan)->facebook) }}">
                </div>

                <hr>
                <h5>Kontak Darurat</h5>

                <div class="form-group">
                    <label>Nama Kontak Darurat</label>
                    <input type="text" name="nama_kontak_darurat" class="form-control" value="{{ old('nama_kontak_darurat', optional($karyawan)->nama_kontak_darurat) }}">
                </div>

                <div class="form-group">
                    <label>Nomor Darurat</label>
                    <input type="text" name="nomor_darurat" class="form-control" value="{{ old('nomor_darurat', optional($karyawan)->nomor_darurat) }}">
                </div>

                <div class="form-group">
                    <label>Email Darurat</label>
                    <input type="email" name="email_darurat" class="form-control" value="{{ old('email_darurat', optional($karyawan)->email_darurat) }}">
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Simpan & Lanjut</button>
            </div>
        </form>
    </div>
</div>

@endsection
