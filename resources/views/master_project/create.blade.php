@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah Project
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('master_project.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Nama Project -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Nama Project
                        </label>
                        <input type="text"
                               name="nama_project"
                               class="form-control @error('nama_project') is-invalid @enderror"
                               value="{{ old('nama_project') }}"
                               placeholder="Masukkan nama project">

                        @error('nama_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Kode Project -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Kode Project
                        </label>
                        <input type="text"
                               name="kode_project"
                               class="form-control @error('kode_project') is-invalid @enderror"
                               value="{{ old('kode_project') }}"
                               placeholder="Masukkan kode project">

                        @error('kode_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">

                    <a href="{{ route('master_project.index') }}"
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