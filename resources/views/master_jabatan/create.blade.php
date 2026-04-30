@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah Jabatan
                </h3>
            </div>

            <form action="{{ route('master_jabatan.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Kode Jabatan
                        </label>
                        <input type="text"
                               name="kode_jabatan"
                               class="form-control @error('kode_jabatan') is-invalid @enderror"
                               value="{{ old('kode_jabatan') }}"
                               placeholder="Masukkan kode jabatan">

                        @error('kode_jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                     <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Nama Jabatan
                        </label>
                        <input type="text"
                               name="nama_jabatan"
                               class="form-control @error('nama_jabatan') is-invalid @enderror"
                               value="{{ old('nama_jabatan') }}"
                               placeholder="Masukkan nama jabatan">

                        @error('nama_jabatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer d-flex justify-content-end">
                    
                    <a href="{{ route('master_jabatan.index') }}" 
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