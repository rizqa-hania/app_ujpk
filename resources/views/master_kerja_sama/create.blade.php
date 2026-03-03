@extends('template.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah Kerja Sama
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('master-kerja-sama.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Unit PLN -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Unit PLN
                        </label>
                        <select name="unitpln_id"
                                class="form-control @error('unitpln_id') is-invalid @enderror"
                                required>
                            <option value=""> Pilih Unit PLN </option>
                            @foreach ($unitPln as $unit)
                                <option value="{{ $unit->unitpln_id }}"
                                    {{ old('unitpln_id') == $unit->unitpln_id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>

                        @error('unitpln_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Nama Kerja Sama -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Nama Kerja Sama
                        </label>
                        <input type="text"
                               name="nama_kerja_sama"
                               class="form-control @error('nama_kerja_sama') is-invalid @enderror"
                               value="{{ old('nama_kerja_sama') }}"
                               placeholder="Masukkan nama kerja sama"
                               required>

                        @error('nama_kerja_sama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Mitra -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Mitra
                        </label>
                        <input type="text"
                               name="mitra"
                               class="form-control @error('mitra') is-invalid @enderror"
                               value="{{ old('mitra') }}"
                               placeholder="Masukkan nama mitra"
                               required>

                        @error('mitra')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Jenis Kerja Sama -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Jenis Kerja Sama
                        </label>
                        <input type="text"
                               name="jenis_kerjasama"
                               class="form-control @error('jenis_kerjasama') is-invalid @enderror"
                               value="{{ old('jenis_kerjasama') }}"
                               placeholder="Masukkan jenis kerja sama"
                               required>

                        @error('jenis_kerjasama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="font-weight-semibold">
                            Status
                        </label>
                        <select name="is_active"
                                class="form-control @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>

                        @error('is_active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('master-kerja-sama.index') }}"
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