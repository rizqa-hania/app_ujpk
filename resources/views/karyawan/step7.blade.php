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

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <div class="card form-card">

        <div class="form-header">
            <h5>Step 7 - Bank & BPJS</h5>
        </div>

        <form action="{{ route('karyawan.storestep7') }}" method="POST" enctype="multipart/form-data">
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

                    <!-- BANK -->
                    <div class="section-title">Bank</div>
                    <div class="form-group">
                        <label>No. Rekening Bank</label>
                        <input type="text" name="no_rg_bank" value="{{ old('no_rg_bank', optional($karyawan)->no_rg_bank) }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Bank</label>
                        <input type="text" name="nama_bank" value="{{ old('nama_bank', optional($karyawan)->nama_bank) }}">
                    </div>
                    <div class="form-group form-full">
                        <label>File Buku Tabungan (PDF/Foto)</label>
                        <input type="file" name="file_buku_tabungan" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_buku_tabungan)
                            <span class="file-info">✓ File sudah diupload</span>
                        @endif
                    </div>

                    <!-- BPJS Kesehatan -->
                    <div class="section-title">BPJS Kesehatan</div>
                    <div class="form-group">
                        <label>No. BPJS</label>
                        <input type="text" name="no_bpjs" value="{{ old('no_bpjs', optional($karyawan)->no_bpjs) }}">
                    </div>
                    <div class="form-group form-full">
                        <label>File BPJS (PDF/Foto)</label>
                        <input type="file" name="file_bpjs" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_bpjs)
                            <span class="file-info">✓ File sudah diupload</span>
                        @endif
                    </div>

                    <!-- BPJS TK -->
                    <div class="section-title">BPJS Ketenagakerjaan</div>
                    <div class="form-group">
                        <label>No. BPJSTK</label>
                        <input type="text" name="no_bpjstk" value="{{ old('no_bpjstk', optional($karyawan)->no_bpjstk) }}">
                    </div>
                    <div class="form-group form-full">
                        <label>File BPJSTK (PDF/Foto)</label>
                        <input type="file" name="file_bpjstk" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_bpjstk)
                            <span class="file-info">✓ File sudah diupload</span>
                        @endif
                    </div>

                    <!-- BPLK -->
                    <div class="section-title">BPLK</div>
                    <div class="form-group">
                        <label>No. Rekening BPLK</label>
                        <input type="text" name="no_rek_bplk" value="{{ old('no_rek_bplk', optional($karyawan)->no_rek_bplk) }}">
                    </div>
                    <div class="form-group form-full">
                        <label>File Buku BPLK (PDF/Foto)</label>
                        <input type="file" name="file_buku_bplk" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_buku_bplk)
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