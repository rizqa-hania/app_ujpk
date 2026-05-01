<head>
    <title>Step Data Karyawan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logojya-removebg-preview.png') }}">>
</head>
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

    input, select, textarea {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #dfe6ed;
        font-size: 14px;
        transition: 0.2s ease;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    }

    textarea {
        resize: vertical;
    }

    .file-info, .text-muted {
        font-size: 12px;
        color: #28a745;
        margin-top: 5px;
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
$kodetad = optional($karyawan->tad)->kode_tad ?? '';
$isDriver = (strpos($kodetad, '06') !== false);
$isSatpam = (strpos($kodetad, '03') !== false);
$showDriverSatpam = $isDriver || $isSatpam;
@endphp

<div class="container">
    <div class="card form-card">

        <div class="form-header">
            <h5>Step 10 - Kesehatan</h5>
        </div>

        <form action="{{ route('karyawan.storestep10') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-body">

                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($showDriverSatpam)
                    <div class="alert alert-success mb-4">
                        Setelah step ini, Anda akan langsung ke halaman terakhir untuk menyelesaikan pengisian data.
                    </div>
                @endif

                <div class="form-grid">
                    <div class="form-group">
                        <label>Tanggal MCU</label>
                        <input type="date" name="tanggal_mcu" value="{{ old('tanggal_mcu', optional($karyawan)->tanggal_mcu) }}">
                        @if(optional($karyawan)->tanggal_mcu)
                            <span class="text-muted">
                                Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_mcu)->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>File Hasil MCU (PDF/Foto)</label>
                        <input type="file" name="file_hasil_mcu" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_hasil_mcu)
                            <span class="file-info">File sudah diupload</span>
                        @endif
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Perokok</label>
                        <select name="perokok">
                            <option value="">Pilih</option>
                            <option value="1" {{ old('perokok', optional($karyawan)->perokok) == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('perokok', optional($karyawan)->perokok) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Penyakit Bawaan</label>
                        <textarea name="penyakit_bawaan" rows="3">{{ old('penyakit_bawaan', optional($karyawan)->penyakit_bawaan) }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn-primary-custom">
                        @if($showDriverSatpam)
                            Lanjut →
                        @else
                            Selesai 
                        @endif
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>