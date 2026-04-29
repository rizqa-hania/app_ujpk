@extends('template.admin.layout')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Update Komponen
            </div>
            <form action="{{ route('komponen.update', $komponen->kode) }}" method="POST"> 
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Komponen</label> 
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode', $komponen->kode) }}" readonly>
                        @error('kode')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="komponen" class="form-label">Nama Komponen</label> 
                        <input type="text" class="form-control @error('komponen') is-invalid @enderror" name="komponen" value="{{ old('komponen', $komponen->komponen) }}">
                        @error('komponen')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Komponen</label> 
                        <select name="tipe" class="form-control @error('tipe') is-invalid @enderror"> 
                            <option value="">-- Pilih Tipe Komponen --</option>
                            <option value="pendapatan" {{ old('tipe', $komponen->tipe) == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                            <option value="potongan" {{ old('tipe', $komponen->tipe) == 'potongan' ? 'selected' : '' }}>Potongan</option>
                        </select>
                        @error('tipe')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipe_penghitungan" class="form-label">Tipe Penghitungan</label> 
                        <select name="tipe_penghitungan" class="form-control @error('tipe_penghitungan') is-invalid @enderror"> 
                            <option value="">-- Pilih Tipe Penghitungan --</option> 
                            <option value="nominal" {{ old('tipe_penghitungan', $komponen->tipe_penghitungan) == 'nominal' ? 'selected' : '' }}>Nominal (Tetap)</option>
                            <option value="presentase" {{ old('tipe_penghitungan', $komponen->tipe_penghitungan) == 'presentase' ? 'selected' : '' }}>Presentase (%)</option>
                        </select>
                        @error('tipe_penghitungan')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                        
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp / %</span>
                            <input type="number" name="nilai" id="nilai" class="form-control @error('nilai') is-invalid @enderror" step="0.01" value="{{ old('nilai', $komponen->nilai) }}" placeholder="Masukkan angka saja">
                        </div>
                        <small class="text-muted">Gunakan titik untuk desimal jika perlu.</small>
                        @error('nilai')
                            <span class="text-danger d-block small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    <a href="{{ route('komponen.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection