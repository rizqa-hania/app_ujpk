<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        padding: 22px 30px;
        color: white;
    }

    .form-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        letter-spacing: 0.5px;
    }

    .form-body {
        padding: 35px;
    }

    /* GRID 2 KOLOM */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #2c3e50;
        font-size: 14px;
    }

    input, select {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #dfe6ed;
        font-size: 14px;
        transition: 0.2s ease;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    }

    .file-info, .text-muted {
        font-size: 12px;
        color: #28a745;
        margin-top: 5px;
    }

    .form-footer {
        margin-top: 25px;
        text-align: right;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        border: none;
        border-radius: 10px;
        padding: 12px 35px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: 0.2s ease;
        font-size: 14px;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13,110,253,.35);
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .alert-info {
        background-color: #e7f3fe;
        color: #0d6efd;
    }

    .alert-success {
        background-color: #e6f4ea;
        color: #28a745;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
$kodeJabatan = optional($karyawan->jabatan)->kode_jabatan ?? '';
$isDriver = (strpos($kodeJabatan, '06') !== false);
$isSatpam = (strpos($kodeJabatan, '03') !== false);
$showDriverSatpam = $isDriver || $isSatpam;
@endphp

<div class="container">
    <div class="card form-card">

        <div class="form-header">
            <h5>
                @if($showDriverSatpam)
                    Step 11 - Khusus
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
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endfore
                            ach
                        </ul>
                    </div>
                @endif

                @if($showDriverSatpam)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Anda memasuki step khusus karena jabatan: 
                        @if($isDriver) Driver @endif
                        @if($isSatpam) Satpam @endif
                    </div>
                @endif

                @if($isDriver)
                    <h5 style="color: #0d6efd; margin-bottom: 15px;">Driver (SIM A)</h5>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>No SIM A</label>
                            <input type="text" name="no_sim_a" value="{{ old('no_sim_a', optional($karyawan)->no_sim_a) }}" placeholder="Masukkan nomor SIM A">
                        </div>
                        <div class="form-group">
                            <label>Masa Berlaku SIM</label>
                            <input type="date" name="masa_berlaku_sim" value="{{ old('masa_berlaku_sim', optional($karyawan)->masa_berlaku_sim) }}">
                            @if(optional($karyawan)->masa_berlaku_sim)
                                <span class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->masa_berlaku_sim)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>File SIM A (PDF/Foto)</label>
                            <input type="file" name="file_sim" accept="image/*,.pdf">
                            @if(optional($karyawan)->file_sim)
                                <span class="file-info">File sudah ada: {{ $karyawan->file_sim }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Jumlah Tilang</label>
                            <input type="number" name="jumlah_tilang_6_bulan" min="0" value="{{ old('jumlah_tilang_6_bulan', optional($karyawan)->jumlah_tilang_6_bulan) }}">
                        </div>
                    </div>
                @endif

                @if($isSatpam)
                    <hr style="border-color: #dbe2ef;">
                    <h5 style="color: #0d6efd; margin-bottom: 15px;">Satpam (KTA & Sertifikat Garda)</h5>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>No KTA</label>
                            <input type="text" name="no_kta" value="{{ old('no_kta', optional($karyawan)->no_kta) }}">
                        </div>
                        <div class="form-group">
                            <label>Masa Berlaku KTA</label>
                            <input type="date" name="masa_berlaku_kta" value="{{ old('masa_berlaku_kta', optional($karyawan)->masa_berlaku_kta) }}">
                            @if(optional($karyawan)->masa_berlaku_kta)
                                <span class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->masa_berlaku_kta)->format('d/m/Y') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>File KTA (PDF/Foto)</label>
                            <input type="file" name="file_kta" accept="image/*,.pdf">
                            @if(optional($karyawan)->file_kta)
                                <span class="file-info">File sudah ada: {{ $karyawan->file_kta }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Pangkat Garda</label>
                            <select name="pangkat_garda">
                                <option value="">Pilih Pangkat</option>
                                <option value="pratama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'pratama' ? 'selected' : '' }}>Pratama</option>
                                <option value="madya" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'madya' ? 'selected' : '' }}>Madya</option>
                                <option value="utama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'utama' ? 'selected' : '' }}>Utama</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No Sertifikat Garda</label>
                            <input type="text" name="no_sertifikat_garda" value="{{ old('no_sertifikat_garda', optional($karyawan)->no_sertifikat_garda) }}">
                        </div>
                        <div class="form-group">
                            <label>File Sertifikat Garda (PDF/Foto)</label>
                            <input type="file" name="file_sertifikat_garda" accept="image/*,.pdf">
                            @if(optional($karyawan)->file_sertifikat_garda)
                                <span class="file-info">File sudah ada: {{ $karyawan->file_sertifikat_garda }}</span>
                            @endif
                        </div>
                    </div>
                @endif

                @if(!$showDriverSatpam)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Anda tidak memerlukan data tambahan. Silakan klik tombol selesai untuk menyelesaikan pengisian data.
                    </div>
                @endif

                <div class="form-footer">
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-check mr-1"></i> Selesai
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>