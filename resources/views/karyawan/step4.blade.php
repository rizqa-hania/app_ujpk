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

    /* ✅ 2 KOLOM KE BAWAH */
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

    input {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #dfe6ed;
        font-size: 14px;
        transition: 0.2s ease;
    }

    input:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    }

    .section-title {
        grid-column: span 2;
        font-weight: 600;
        color: #0d6efd;
        margin-top: 10px;
        margin-bottom: 5px;
        font-size: 16px;
    }

    .form-footer {
        margin-top: 35px;
        text-align: right;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        border: none;
        border-radius: 12px;
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
</style>

<div class="container">
    <div class="form-card">

        <div class="form-header">
            <h5>Step 4 - Data Kontak</h5>
        </div>

        <form action="{{ route('karyawan.storestep4') }}" method="POST">
            @csrf

            <div class="form-body">

                @if($errors->any())
                    <div class="alert">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-grid">

                    <!-- Kontak Pribadi -->
                    <div class="form-group">
                        <label>No. HP Utama</label>
                        <input type="text" name="no_HP_utama"
                               value="{{ old('no_HP_utama', optional($karyawan)->no_HP_utama) }}">
                    </div>

                    <div class="form-group">
                        <label>No. HP Cadangan</label>
                        <input type="text" name="no_HP_cadangan"
                               value="{{ old('no_HP_cadangan', optional($karyawan)->no_HP_cadangan) }}">
                    </div>

                    <div class="form-group">
                        <label>Email Pribadi</label>
                        <input type="email" name="email_pribadi"
                               value="{{ old('email_pribadi', optional($karyawan)->email_pribadi) }}">
                    </div>

                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" name="instagram"
                               value="{{ old('instagram', optional($karyawan)->instagram) }}">
                    </div>

                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" name="facebook"
                               value="{{ old('facebook', optional($karyawan)->facebook) }}">
                    </div>

                    <!-- Judul Kontak Darurat -->
                    <div class="section-title">
                        Kontak Darurat
                    </div>

                    <div class="form-group">
                        <label>Nama Kontak Darurat</label>
                        <input type="text" name="nama_kontak_darurat"
                               value="{{ old('nama_kontak_darurat', optional($karyawan)->nama_kontak_darurat) }}">
                    </div>

                    <div class="form-group">
                        <label>Nomor Darurat</label>
                        <input type="text" name="nomor_darurat"
                               value="{{ old('nomor_darurat', optional($karyawan)->nomor_darurat) }}">
                    </div>

                    <div class="form-group">
                        <label>Email Darurat</label>
                        <input type="email" name="email_darurat"
                               value="{{ old('email_darurat', optional($karyawan)->email_darurat) }}">
                    </div>

                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-primary-custom">
                        Lanjut →
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>