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
            <h5>Step 8 - Dokumen</h5>
        </div>

        <form action="{{ route('karyawan.storestep8') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>File Surat Lamaran (PDF)</label>
                        <input type="file" name="file_surat_lamaran" class="form-control" accept="application/pdf,.pdf">
                        @if(optional($karyawan)->file_surat_lamaran)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_surat_lamaran }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>File CV (PDF)</label>
                        <input type="file" name="file_cv" class="form-control" accept="application/pdf,.pdf">
                        @if(optional($karyawan)->file_cv)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_cv }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>File Pakta Integritas (PDF)</label>
                        <input type="file" name="file_pakta_integritas" class="form-control" accept="application/pdf,.pdf">
                        @if(optional($karyawan)->file_pakta_integritas)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_pakta_integritas }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>File Data Consist (PDF)</label>
                        <input type="file" name="file_data_consist" class="form-control" accept="application/pdf,.pdf">
                        @if(optional($karyawan)->file_data_consist)
                            <small class="text-success">File sudah ada: {{ $karyawan->file_data_consist }}</small>
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
