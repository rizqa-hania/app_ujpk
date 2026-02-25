@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 2 - Data Pribadi</h3>
        </div>

        <form action="{{ route('karyawan.storestep2') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>Foto Diri (3x4)</label>
                    <input type="file" name="file_foto_diri" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_foto_diri)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_foto_diri }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', optional($karyawan)->nama_lengkap) }}">
                </div>

                <div class="form-group">
                    <label>Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', optional($karyawan)->nama_panggilan) }}">
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', optional($karyawan)->tempat_lahir) }}">
                </div>

                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($karyawan)->tanggal_lahir) }}">
                    @if(optional($karyawan)->tanggal_lahir)
                        <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_lahir)->format('d/m/Y') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="laki-laki" {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Agama</label>
                    <input type="text" name="agama" class="form-control" value="{{ old('agama', optional($karyawan)->agama) }}">
                </div>

                <div class="form-group">
                    <label>Suku Bangsa</label>
                    <input type="text" name="suku_bangsa" class="form-control" value="{{ old('suku_bangsa', optional($karyawan)->suku_bangsa) }}">
                </div>

                <div class="form-group">
                    <label>Status Nikah</label>
                    <select name="status_nikah" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="belum_menikah" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="sudah_nikah" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'sudah_nikah' ? 'selected' : '' }}>Sudah Menikah</option>
                        <option value="cerai" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'cerai' ? 'selected' : '' }}>Cerai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah Anak</label>
                    <input type="number" name="jumlah_anak" class="form-control" value="{{ old('jumlah_anak', optional($karyawan)->jumlah_anak) }}" min="0">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', optional($karyawan)->alamat) }}</textarea>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Simpan & Lanjut</button>
            </div>
        </form>
    </div>
</div>

@endsection
