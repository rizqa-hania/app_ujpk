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

    /* Full 1 baris */
    .form-full {
        grid-column: span 2;
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
            <h5>Step 2 - Data Pribadi</h5>
        </div>

        <form action="{{ route('karyawan.storestep2') }}" method="POST" enctype="multipart/form-data">
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

                    <div class="form-group">
                    <label>Foto Diri (3x4)</label>
                    <input type="file" name="foto_3x4" accept="image/*">
                </div>


                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                               value="{{ old('nama_lengkap', optional($karyawan)->nama_lengkap) }}">
                    </div>

                    <div class="form-group">
                        <label>Nama Panggilan</label>
                        <input type="text" name="nama_panggilan"
                               value="{{ old('nama_panggilan', optional($karyawan)->nama_panggilan) }}">
                    </div>

                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                               value="{{ old('tempat_lahir', optional($karyawan)->tempat_lahir) }}">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                               value="{{ old('tanggal_lahir', optional($karyawan)->tanggal_lahir) }}">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="">Pilih</option>
                            <option value="laki-laki"
                                {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="perempuan"
                                {{ old('jenis_kelamin', optional($karyawan)->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Agama</label>
                        <input type="text" name="agama"
                               value="{{ old('agama', optional($karyawan)->agama) }}">
                    </div>

                    <div class="form-group">
                        <label>Suku Bangsa</label>
                        <input type="text" name="suku_bangsa"
                               value="{{ old('suku_bangsa', optional($karyawan)->suku_bangsa) }}">
                    </div>

                    <div class="form-group">
                        <label>Status Nikah</label>
                        <select name="status_nikah">
                            <option value="">Pilih</option>
                            <option value="belum_menikah">Belum Menikah</option>
                            <option value="sudah_nikah">Sudah Menikah</option>
                            <option value="cerai">Cerai</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Anak</label>
                        <input type="number" name="jumlah_anak" min="0"
                               value="{{ old('jumlah_anak', optional($karyawan)->jumlah_anak) }}">
                    </div>

                    <div class="form-group form-full">
                        <label>Alamat</label>
                        <textarea name="alamat">{{ old('alamat', optional($karyawan)->alamat) }}</textarea>
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