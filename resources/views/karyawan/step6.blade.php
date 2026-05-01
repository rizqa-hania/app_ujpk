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
        min-height: 90px;
    }

    .form-full {
        grid-column: 1 / -1;
    }

    .form-footer {
        margin-top: 30px;
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
        background-color: #ffeaea;
        color: #c0392b;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .file-info {
        font-size: 12px;
        color: #28a745;
        margin-top: 5px;
    }

    .section-title {
        font-weight: 600;
        font-size: 14px;
        color: #0d6efd;
        margin-top: 30px;
        margin-bottom: 15px;
        grid-column: 1 / -1;
        border-bottom: 1px solid #eef2f7;
        padding-bottom: 6px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <div class="card form-card">

        <div class="form-header">
            <h5>Step 6 - Identitas Resmi</h5>
        </div>

        <form action="{{ route('karyawan.storestep6') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-body">

                @if($errors->any())
                    <div class="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-grid">

                    <!-- KTP -->
                    <div class="section-title">KTP</div>
                    <div class="form-group">
                        <label>No. KTP</label>
                        <input type="text" name="no_ktp" value="{{ old('no_ktp', optional($karyawan)->no_ktp) }}">
                    </div>
                    <div class="form-group">
                        <label>File KTP (PDF/Foto)</label>
                        <input type="file" name="file_ktp" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_ktp)
                            <span class="file-info">✓ File sudah diupload</span>
                        @endif
                    </div>

                    <!-- KK -->
                    <div class="section-title">Kartu Keluarga</div>
                    <div class="form-group">
                        <label>No. KK</label>
                        <input type="text" name="no_kk" value="{{ old('no_kk', optional($karyawan)->no_kk) }}">
                    </div>
                    <div class="form-group">
                        <label>File KK (PDF/Foto)</label>
                        <input type="file" name="file_kk" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_kk)
                            <span class="file-info">✓ File sudah diupload</span>
                        @endif
                    </div>

                    <!-- NPWP -->
                    <div class="section-title">NPWP</div>
                    <div class="form-group">
                        <label>No. NPWP</label>
                        <input type="text" name="no_npwp" value="{{ old('no_npwp', optional($karyawan)->no_npwp) }}">
                    </div>
                    <div class="form-group">
                        <label>File NPWP (PDF/Foto)</label>
                        <input type="file" name="file_npwp" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_npwp)
                            <span class="file-info">✓ File sudah diupload</span>
                        @endif
                    </div>

                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-primary-custom">Lanjut →</button>
                </div>

            </div>
        </form>
    </div>
</div>