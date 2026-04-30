@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">
            
            <!-- Header -->
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah TAD
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('master_tad.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <!-- Kode tad -->
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Kode TAD
                        </label>
                        <input type="text"
                               name="kode_tad"
                               class="form-control @error('kode_tad') is-invalid @enderror"
                               value="{{ old('kode_tad') }}"
                               placeholder="Contoh: 03 untuk Satpam, 06 untuk Driver">
                        <small class="text-muted">Masukkan kode TAD (03=Satpam, 06=Driver)</small>
                        @error('kode_tad')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Nama tad -->
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Nama TAD
                        </label>
                        <input type="text"
                               name="nama_tad"
                               class="form-control @error('nama_tad') is-invalid @enderror"
                               value="{{ old('nama_tad') }}"
                               placeholder="Masukkan nama tad">
                        @error('nama_jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('master_tad.index') }}" 
                       class="btn btn-secondary btn-sm mr-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection