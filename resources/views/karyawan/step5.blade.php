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

    /* Full 1 baris */
    .form-full {
        grid-column: span 2;
    }

    .text-success {
        font-size: 12px;
        color: #27ae60;
        margin-top: 5px;
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
            <h5>Step 5 - Pendidikan</h5>
        </div>

        <form action="{{ route('karyawan.storestep5') }}" method="POST" enctype="multipart/form-data">
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
                        <label>Pendidikan</label>
                        <select name="pendidikan_id" required>
                            <option value="">Pilih Pendidikan</option>
                            @foreach($pendidikan as $pen)
                                <option value="{{ $pen->pendidikan_id }}"
                                    {{ old('pendidikan_id', optional($karyawan)->pendidikan_id) == $pen->pendidikan_id ? 'selected' : '' }}>
                                    {{ $pen->nama_pendidikan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Universitas / Sekolah</label>
                        <input type="text" name="nama_perguruan"
                               value="{{ old('nama_perguruan', optional($karyawan)->nama_perguruan) }}">
                    </div>

                    <div class="form-group form-full">
                        <label>File Ijazah (PDF / Foto)</label>
                        <input type="file" name="file_ijazah" accept="image/*,.pdf">

                        @if(optional($karyawan)->file_ijazah)
                            <span class="text-success">
                                File sudah ada: {{ $karyawan->file_ijazah }}
                            </span>
                        @endif
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