<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Form Tambah Komponen Gaji</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('komponen.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Kode Komponen</label>
                                <input type="text" name="kode" class="form-control" placeholder="Contoh: 02" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nama Komponen</label>
                                <input type="text" name="komponen" class="form-control" placeholder="Contoh: Tunjangan IT" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tipe Komponen</label>
                                <select name="tipe" class="form-select">
                                    <option value="pendapatan">Pendapatan</option>
                                    <option value="potongan">Potongan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tipe Penghitungan</label>
                                <select name="tipe_penghitungan" class="form-select">
                                    <option value="nominal">Nominal (Tetap)</option>
                                    <option value="presentase">Persentase (%)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nilai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp / %</span>
                                <input type="number" name="nilai" class="form-control" step="0.01" placeholder="Masukkan angka saja">
                            </div>
                            <small class="text-muted">Gunakan titik untuk desimal jika perlu.</small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('komponen.index') }}" class="btn btn-light border">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                Simpan Komponen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>