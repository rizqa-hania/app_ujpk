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

<div class="container py-4">
    <div class="card form-card">

        <div class="form-header">
            <h5>Step 3 - Data Fisik</h5>
        </div>

        <form action="{{ route('karyawan.storestep3') }}" method="POST">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', optional($karyawan)->tinggi_badan) }}" min="0">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" class="form-control" value="{{ old('berat_badan', optional($karyawan)->berat_badan) }}" min="0">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Golongan Darah</label>
                        <select name="gol_darah" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="A" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Ukuran Baju</label>
                        <input type="text" name="ukuran_baju" class="form-control" value="{{ old('ukuran_baju', optional($karyawan)->ukuran_baju) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Ukuran Celana</label>
                        <input type="text" name="ukuran_celana" class="form-control" value="{{ old('ukuran_celana', optional($karyawan)->ukuran_celana) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Ukuran Sepatu</label>
                        <input type="number" name="ukuran_sepatu" class="form-control" value="{{ old('ukuran_sepatu', optional($karyawan)->ukuran_sepatu) }}" min="0">
                    </div>
                </div>

                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary-custom">
                        Lanjut →
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
