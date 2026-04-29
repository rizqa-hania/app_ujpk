@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah Pendidikan
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('master_pendidikan.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Kode Pendidikan -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Kode Pendidikan
                        </label>
                        <input type="text"
                               name="kode_pendidikan"
                               class="form-control @error('kode_pendidikan') is-invalid @enderror"
                               value="{{ old('kode_pendidikan') }}"
                               placeholder="Masukkan kode pendidikan">

                        @error('kode_pendidikan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <!-- Nama Pendidikan -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Nama Pendidikan
                        </label>
                        <input type="text"
                               name="nama_pendidikan"
                               class="form-control @error('nama_pendidikan') is-invalid @enderror"
                               value="{{ old('nama_pendidikan') }}"
                               placeholder="Masukkan nama pendidikan">

                        @error('nama_pendidikan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">

                    <a href="{{ route('master_pendidikan.index') }}"
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