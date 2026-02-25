@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 3 - Data Fisik</h3>
        </div>

        <form action="{{ route('karyawan.storestep3') }}" method="POST">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', optional($karyawan)->tinggi_badan) }}" min="0">
                </div>

                <div class="form-group">
                    <label>Berat Badan (kg)</label>
                    <input type="number" name="berat_badan" class="form-control" value="{{ old('berat_badan', optional($karyawan)->berat_badan) }}" min="0">
                </div>

                <div class="form-group">
                    <label>Golongan Darah</label>
                    <select name="gol_darah" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="A" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('gol_darah', optional($karyawan)->gol_darah) == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ukuran Baju</label>
                    <input type="text" name="ukuran_baju" class="form-control" value="{{ old('ukuran_baju', optional($karyawan)->ukuran_baju) }}">
                </div>

                <div class="form-group">
                    <label>Ukuran Celana</label>
                    <input type="text" name="ukuran_celana" class="form-control" value="{{ old('ukuran_celana', optional($karyawan)->ukuran_celana) }}">
                </div>

                <div class="form-group">
                    <label>Ukuran Sepatu</label>
                    <input type="number" name="ukuran_sepatu" class="form-control" value="{{ old('ukuran_sepatu', optional($karyawan)->ukuran_sepatu) }}" min="0">
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Simpan & Lanjut</button>
            </div>
        </form>
    </div>
</div>

@endsection
