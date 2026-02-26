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
            <h5>Step 7 - Bank & BPJS</h5>
        </div>

        <form action="{{ route('karyawan.storestep7') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <h5 style="color: #0d6efd; margin-bottom: 20px;">Bank</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No. Rekening Bank</label>
                        <input type="text" name="no_rg_bank" class="form-control" value="{{ old('no_rg_bank', optional($karyawan)->no_rg_bank) }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>Nama Bank</label>
                        <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', optional($karyawan)->nama_bank) }}">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label>File Buku Tabungan (PDF/Foto)</label>
                        <input type="file" name="file_buku_tabungan" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_buku_tabungan)
                        @endif
                    </div>
                </div>

                <hr style="margin: 20px 0; border-color: #dbe2ef;">

                <h5 style="color: #0d6efd; margin-bottom: 20px;">BPJS Kesehatan</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No. BPJS</label>
                        <input type="text" name="no_bpjs" class="form-control" value="{{ old('no_bpjs', optional($karyawan)->no_bpjs) }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>File BPJS (PDF/Foto)</label>
                        <input type="file" name="file_bpjs" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_bpjs)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_bpjs }}</small>
                        @endif
                    </div>
                </div>

                <hr style="margin: 20px 0; border-color: #dbe2ef;">

                <h5 style="color: #0d6efd; margin-bottom: 20px;">BPJS Ketenagakerjaan</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No. BPJSTK</label>
                        <input type="text" name="no_bpjstk" class="form-control" value="{{ old('no_bpjstk', optional($karyawan)->no_bpjstk) }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>File BPJSTK (PDF/Foto)</label>
                        <input type="file" name="file_bpjstk" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_bpjstk)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_bpjstk }}</small>
                        @endif
                    </div>
                </div>

                <hr style="margin: 20px 0; border-color: #dbe2ef;">

                <h5 style="color: #0d6efd; margin-bottom: 20px;">BPLK</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>No. Rekening BPLK</label>
                        <input type="text" name="no_rek_bplk" class="form-control" value="{{ old('no_rek_bplk', optional($karyawan)->no_rek_bplk) }}">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label>File Buku BPLK (PDF/Foto)</label>
                        <input type="file" name="file_buku_bplk" class="form-control" accept="image/*,.pdf">
                        @if(optional($karyawan)->file_buku_bplk)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_buku_bplk }}</small>
                        @endif
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
