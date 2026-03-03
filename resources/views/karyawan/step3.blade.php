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
            <h5>Step 3 - Data Fisik</h5>
        </div>

        <form action="{{ route('karyawan.storestep3') }}" method="POST">
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
                        <label>Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan"
                               value="{{ old('tinggi_badan', optional($karyawan)->tinggi_badan) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat_badan"
                               value="{{ old('berat_badan', optional($karyawan)->berat_badan) }}" min="0">
                    </div>

                    <div class="form-group">
                        <label>Golongan Darah</label>
                        <select name="gol_darah">
                            <option value="">Pilih</option>
                            <option value="A" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ukuran Baju</label>
                        <input type="text" name="ukuran_baju"
                               value="{{ old('ukuran_baju', optional($karyawan)->ukuran_baju) }}">
                    </div>

                    <div class="form-group">
                        <label>Ukuran Celana</label>
                        <input type="text" name="ukuran_celana"
                               value="{{ old('ukuran_celana', optional($karyawan)->ukuran_celana) }}">
                    </div>

                    <div class="form-group">
                        <label>Ukuran Sepatu</label>
                        <input type="number" name="ukuran_sepatu"
                               value="{{ old('ukuran_sepatu', optional($karyawan)->ukuran_sepatu) }}" min="0">
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