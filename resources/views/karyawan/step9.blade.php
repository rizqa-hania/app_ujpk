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
            <h5>Step 9 - Pengalaman Kerja</h5>
        </div>

        <form action="{{ route('karyawan.storestep9') }}" method="POST">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label>Pengalaman Kerja 1</label>
                        <textarea name="pengalaman_kerja_1" class="form-control" rows="3">{{ old('pengalaman_kerja_1', optional($karyawan)->pengalaman_kerja_1) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label>Pengalaman Kerja 2</label>
                        <textarea name="pengalaman_kerja_2" class="form-control" rows="3">{{ old('pengalaman_kerja_2', optional($karyawan)->pengalaman_kerja_2) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label>Pengalaman Kerja 3</label>
                        <textarea name="pengalaman_kerja_3" class="form-control" rows="3">{{ old('pengalaman_kerja_3', optional($karyawan)->pengalaman_kerja_3) }}</textarea>
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
