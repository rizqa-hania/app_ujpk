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
            <h5>Step 4 - Data Kontak</h5>
        </div>

        <form action="{{ route('karyawan.storestep4') }}" method="POST">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No. HP Utama</label>
                        <input type="text" name="no_HP_utama" class="form-control" value="{{ old('no_HP_utama', optional($karyawan)->no_HP_utama) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>No. HP Cadangan</label>
                        <input type="text" name="no_HP_cadangan" class="form-control" value="{{ old('no_HP_cadangan', optional($karyawan)->no_HP_cadangan) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Email Pribadi</label>
                        <input type="email" name="email_pribadi" class="form-control" value="{{ old('email_pribadi', optional($karyawan)->email_pribadi) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{ old('instagram', optional($karyawan)->instagram) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Facebook</label>
                        <input type="text" name="facebook" class="form-control" value="{{ old('facebook', optional($karyawan)->facebook) }}">
                    </div>
                </div>

                <hr style="margin: 25px 0; border-color: #e0e6ed;">

                <h5 style="color: #0d6efd; margin-bottom: 20px;">Kontak Darurat</h5>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>Nama Kontak Darurat</label>
                        <input type="text" name="nama_kontak_darurat" class="form-control" value="{{ old('nama_kontak_darurat', optional($karyawan)->nama_kontak_darurat) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Nomor Darurat</label>
                        <input type="text" name="nomor_darurat" class="form-control" value="{{ old('nomor_darurat', optional($karyawan)->nomor_darurat) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Email Darurat</label>
                        <input type="email" name="email_darurat" class="form-control" value="{{ old('email_darurat', optional($karyawan)->email_darurat) }}">
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
