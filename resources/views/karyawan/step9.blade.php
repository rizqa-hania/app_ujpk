<title>Step Data Karyawan</title>
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

    textarea {
        width: 100%;
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #dfe6ed;
        font-size: 14px;
        resize: vertical;
        min-height: 90px;
        transition: 0.2s ease;
    }

    textarea:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
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
        background-color: #ffeaea;
        color: #c0392b;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
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
            <h5>Step 9 - Pengalaman Kerja</h5>
        </div>

        <form action="{{ route('karyawan.storestep9') }}" method="POST">
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

                    <div class="form-group form-full">
                        <label>Pengalaman Kerja 1</label>
                        <textarea name="pengalaman_kerja_1">{{ old('pengalaman_kerja_1', optional($karyawan)->pengalaman_kerja_1) }}</textarea>
                    </div>

                    <div class="form-group form-full">
                        <label>Pengalaman Kerja 2</label>
                        <textarea name="pengalaman_kerja_2">{{ old('pengalaman_kerja_2', optional($karyawan)->pengalaman_kerja_2) }}</textarea>
                    </div>

                    <div class="form-group form-full">
                        <label>Pengalaman Kerja 3</label>
                        <textarea name="pengalaman_kerja_3">{{ old('pengalaman_kerja_3', optional($karyawan)->pengalaman_kerja_3) }}</textarea>
                    </div>

                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-primary-custom">Lanjut →</button>
                </div>

            </div>
        </form>

    </div>
</div>