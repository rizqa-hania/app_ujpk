

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
            <h5>Step 10 - Kesehatan</h5>
        </div>

        <form action="{{ route('karyawan.storestep10') }}" method="POST" enctype="multipart/form-data">
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
                    Setelah step ini, Anda akan melanjutkan ke step akhir untuk mengisi data 
                    @if($isDriver && $isSatpam) Driver & Satpam
                    @elseif($isDriver) Driver (SIM A)
                    @elseif($isSatpam) Satpam (KTA & Sertifikat Garda)
                    @endif
                </div>
                @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> 
                    Setelah step ini, Anda akan langsung ke halaman terakhir untuk menyelesaikan pengisisan data.
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>Tanggal MCU</label>
                        <input type="date" name="tanggal_mcu" class="form-control" value="{{ old('tanggal_mcu', optional($karyawan)->tanggal_mcu) }}">
                        @if(optional($karyawan)->tanggal_mcu)
                            <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_mcu)->format('d/m/Y') }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>File Hasil MCU (PDF/Foto)</label>
                        <input type="file" name="file_hasil_mcu" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_hasil_mcu)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_hasil_mcu }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Perokok</label>
                        <select name="perokok" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ old('perokok', optional($karyawan)->perokok) == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('perokok', optional($karyawan)->perokok == '0') ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Penyakit Bawaan</label>
                        <textarea name="penyakit_bawaan" class="form-control" rows="2">{{ old('penyakit_bawaan', optional($karyawan)->penyakit_bawaan) }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary-custom">
                        @if($showDriverSatpam)
                            Lanjut (Driver/Satpam) →
                        @else
                            Selesai →
                        @endif
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
