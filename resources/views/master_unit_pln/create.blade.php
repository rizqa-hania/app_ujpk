@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah Unit PLN
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('master_unit_pln.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Kode Unit -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Kode Unit
                        </label>
                        <input type="text"
                               name="kode_unit"
                               class="form-control @error('kode_unit') is-invalid @enderror"
                               value="{{ old('kode_unit') }}"
                               placeholder="Masukkan kode unit">

                        @error('kode_unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Nama Unit -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Nama Unit
                        </label>
                        <input type="text"
                               name="nama_unit"
                               class="form-control @error('nama_unit') is-invalid @enderror"
                               value="{{ old('nama_unit') }}"
                               placeholder="Masukkan nama unit">

                        @error('nama_unit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">
                    
                    <a href="{{ route('master_unit_pln.index') }}" 
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