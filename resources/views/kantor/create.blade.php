@extends('template.admin.layout')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Kantor</h5>
            </div>

            <div class="card-body">

                {{-- ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('kantor.store') }}">
                    @csrf

                    {{-- Nama Kantor --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Nama Kantor</label>
                        <input type="text"
                               name="nama_kantor"
                               class="form-control @error('nama_kantor') is-invalid @enderror"
                               value="{{ old('nama_kantor') }}"
                               required>
                        @error('nama_kantor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Alamat</label>
                        <input type="text"
                               name="alamat"
                               class="form-control @error('alamat') is-invalid @enderror"
                               value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Latitude --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Latitude</label>
                                <input type="number"
                                       step="0.0000001"
                                       name="latitude"
                                       class="form-control @error('latitude') is-invalid @enderror"
                                       value="{{ old('latitude') }}"
                                       required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Longitude --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Longitude</label>
                                <input type="number"
                                       step="0.0000001"
                                       name="longitude"
                                       class="form-control @error('longitude') is-invalid @enderror"
                                       value="{{ old('longitude') }}"
                                       required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Radius --}}
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Radius (Meter)</label>
                        <input type="number"
                               name="radius_meter"
                               class="form-control @error('radius_meter') is-invalid @enderror"
                               value="{{ old('radius_meter', 100) }}"
                               required>
                        @error('radius_meter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kantor.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection