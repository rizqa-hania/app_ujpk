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

@php
$kodeJabatan = optional($karyawan->jabatan)->kode_jabatan ?? '';
$isDriver = (strpos($kodeJabatan, '06') !== false);
$isSatpam = (strpos($kodeJabatan, '03') !== false);
$showDriverSatpam = $isDriver || $isSatpam;
@endphp

<div class="container py-4">
    <div class="card form-card">

        <div class="form-header">
            <h5>
                @if($showDriverSatpam)
                    Step 11 - Driver/Satpam
                @else
                    Step 11 - Final
                @endif
            </h5>
        </div>

        <form action="{{ route('karyawan.storestep11') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                @if($showDriverSatpam)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Anda memasuki step khusus karena jabatan Anda adalah 
                    @if($isDriver && $isSatpam) 
                    @elseif($isDriver) Driver
                    @elseif($isSatpam) Satpam
                    @endif
                </div>
                @endif

                @if($isDriver)
                <h5 style="color: #0d6efd; margin-bottom: 20px;"><i class="fas fa-car mr-1"></i> Driver (SIM A)</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No SIM A</label>
                        <input type="text" name="no_sim_a" class="form-control" value="{{ old('no_sim_a', optional($karyawan)->no_sim_a) }}" placeholder="Masukkan nomor SIM A">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>Masa Berlaku SIM</label>
                        <input type="date" name="masa_berlaku_sim" class="form-control" value="{{ old('masa_berlaku_sim', optional($karyawan)->masa_berlaku_sim) }}">
                        @if(optional($karyawan)->masa_berlaku_sim)
                            <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->masa_berlaku_sim)->format('d/m/Y') }}</small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>File SIM A (PDF/Foto)</label>
                        <input type="file" name="file_sim" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_sim)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_sim }}</small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>Jumlah Tilang</label>
                        <input type="number" name="jumlah_tilang_6_bulan" class="form-control" value="{{ old('jumlah_tilang_6_bulan', optional($karyawan)->jumlah_tilang_6_bulan) }}" min="0" placeholder="0">
                    </div>
                </div>
                @endif

                @if($isSatpam)
                <hr style="margin: 20px 0; border-color: #dbe2ef;">
                <h5 style="color: #0d6efd; margin-bottom: 20px;"><i class="fas fa-shield-alt mr-1"></i> Satpam (KTA & Sertifikat Garda)</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No KTA</label>
                        <input type="text" name="no_kta" class="form-control" value="{{ old('no_kta', optional($karyawan)->no_kta) }}" placeholder="Masukkan nomor KTA">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>Masa Berlaku KTA</label>
                        <input type="date" name="masa_berlaku_kta" class="form-control" value="{{ old('masa_berlaku_kta', optional($karyawan)->masa_berlaku_kta) }}">
                        @if(optional($karyawan)->masa_berlaku_kta)
                            <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->masa_berlaku_kta)->format('d/m/Y') }}</small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>File KTA (PDF/Foto)</label>
                        <input type="file" name="file_kta" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_kta)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_kta }}</small>
                        @endif
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>Pangkat Garda</label>
                        <select name="pangkat_garda" class="form-control">
                            <option value=""> Pilih Pangkat </option>
                            <option value="pratama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'pratama' ? 'selected' : '' }}>Pratama</option>
                            <option value="madya" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'madya' ? 'selected' : '' }}>Madya</option>
                            <option value="utama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'utama' ? 'selected' : '' }}>Utama</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>No Sertifikat Garda</label>
                        <input type="text" name="no_sertifikat_garda" class="form-control" value="{{ old('no_sertifikat_garda', optional($karyawan)->no_sertifikat_garda) }}" placeholder="Masukkan nomor sertifikat">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>File Sertifikat Garda (PDF/Foto)</label>
                        <input type="file" name="file_sertifikat_garda" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_sertifikat_garda)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_sertifikat_garda }}</small>
                        @endif
                    </div>
                </div>
                @endif

                @if(!$showDriverSatpam)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> 
                    Anda tidak memerlukan data tambahan. Silakan klik tombol selesai untuk menyelesaikan pengisisan data.
                </div>
                @endif

                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-check mr-1"></i> Selesai
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
