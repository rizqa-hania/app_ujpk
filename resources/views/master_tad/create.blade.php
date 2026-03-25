@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">
            
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah TAD
                </h3>
            </div>

            <form action="{{ route('master_tad.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Nama TAD
                        </label>
                        <input type="text"
                               name="nama_tad"
                               class="form-control @error('nama_tad') is-invalid @enderror"
                               value="{{ old('nama_tad') }}"
                               placeholder="Masukkan nama TAD">

                        @error('nama_tad')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Kode TAD
                        </label>
                        <input type="text"
                               name="kode_tad"
                               class="form-control @error('kode_tad') is-invalid @enderror"
                               value="{{ old('kode_tad') }}"
                               placeholder="Masukkan kode TAD">

                        @error('kode_tad')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

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