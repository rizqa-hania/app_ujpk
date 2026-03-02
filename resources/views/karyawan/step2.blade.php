<style>
    .form-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        padding: 20px 30px;
        color: white;
    }

    .form-header h5 {
        margin: 0;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
    }

    .form-body {
        padding: 35px;
        background-color: #ffffff;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e6ed;
        transition: 0.2s;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #34495e;
        font-size: 0.9rem;
    }

    .mb-4 {
        margin-bottom: 25px !important;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        border: none;
        border-radius: 12px;
        padding: 12px 35px;
        font-weight: 600;
        transition: 0.2s;
        color: white;
        font-size: 0.95rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13,110,253,.35);
        background: linear-gradient(135deg, #0b5ed7, #0956c9);
    }
</style>

<div class="container py-4">
    <div class="card form-card">

        <div class="form-header">
            <h5>Step 2 - Data Pribadi</h5>
        </div>

        <form action="{{ route('karyawan.storestep2') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>Foto Diri (3x4)</label>
                        <input type="file" name="file_foto_diri" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_foto_diri)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_foto_diri }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', optional($karyawan)->nama_lengkap) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', optional($karyawan)->nama_panggilan) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', optional($karyawan)->tempat_lahir) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($karyawan)->tanggal_lahir) }}">
                        @if(optional($karyawan)->tanggal_lahir)
                            <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_lahir)->format('d/m/Y') }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value=""> Pilih </option>
                            <option value="laki-laki" {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', optional($karyawan)->agama) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Suku Bangsa</label>
                        <input type="text" name="suku_bangsa" class="form-control" value="{{ old('suku_bangsa', optional($karyawan)->suku_bangsa) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Status Nikah</label>
                        <select name="status_nikah" class="form-control">
                            <option value=""> Pilih </option>
                            <option value="belum_menikah" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="sudah_nikah" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'sudah_nikah' ? 'selected' : '' }}>Sudah Menikah</option>
                            <option value="cerai" {{ old('status_nikah', optional($karyawan)->status_nikah) == 'cerai' ? 'selected' : '' }}>Cerai</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Jumlah Anak</label>
                        <input type="number" name="jumlah_anak" class="form-control" value="{{ old('jumlah_anak', optional($karyawan)->jumlah_anak) }}" min="0">
                    </div>

                    <div class="col-md-12 mb-4">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', optional($karyawan)->alamat) }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary-custom">
                        Lanjut →
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
