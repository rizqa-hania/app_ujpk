@extends('template.karyawan.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pengajuan Izin</h4>
                </div>

                <div class="card-body">

                    {{-- Error Validation Umum --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Jenis Izin --}}
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold">Jenis Pengajuan</label>
                            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="cuti" {{ old('jenis') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Tanggal Mulai --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold">Tanggal Mulai</label>
                                    <input type="date"
                                           name="tanggal_mulai"
                                           class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           value="{{ old('tanggal_mulai') }}"
                                           required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tanggal Selesai --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold">Tanggal Selesai</label>
                                    <input type="date"
                                           name="tanggal_selesai"
                                           class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                           value="{{ old('tanggal_selesai') }}"
                                           required>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold">Keterangan / Alasan</label>
                            <textarea name="keterangan"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Contoh: Sakit demam, Keperluan keluarga, dll"
                                      required>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Bukti --}}
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">Upload Bukti <span class="text-muted">(Opsional)</span></label>
                            <div class="custom-file">
                                <input type="file"
                                       name="file_bukti"
                                       class="form-control @error('file_bukti') is-invalid @enderror">
                            </div>
                            <small class="text-muted d-block mt-1">
                                Format yang diizinkan: <strong>JPG, PNG, PDF</strong> (Maksimal 2MB).
                            </small>
                            @error('file_bukti')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('karyawan.dashboard') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection