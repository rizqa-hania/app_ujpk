@extends('template.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">Tambah Komponen</div>
                <form action="{{ route('komponen.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Komponen</label>
                        <input type="text" name="kode" class="form-control" placeholder="Contoh: 02" value="{{old('kode')}}" required>
                        @if ($errors->has('kode'))
                        <span class="text-danger">{{ $errors->first('kode') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="komponen" class="form-label">Nama Komponen</label>
                        <input type="text" name="komponen" class="form-control" placeholder="Contoh: Tunjangan Jabatan" value="{{old('komponen')}}" required>
                        @if ($errors->has('komponen'))
                        <span class="text-danger">{{ $errors->first('komponen') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Komponen</label>
                        <select name="tipe" class="form-control">
                            <option value="pendapatan">Pendapatan</option>
                            <option value="potongan">Potongan</option>
                        </select>
                        @if ($errors->has('tipe'))
                        <span class="text-danger">{{ $errors->first('tipe') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="tipe_penghitungan" class="form-label">Tipe Penghitungan</label>
                        <select name="tipe_penghitungan" class="form-control">
                            <option value="nominal">Nominal (Tetap)</option>
                            <option value="presentase">Persentase (%)</option>
                        </select>
                        @if ($errors->has('tipe_penghitungan'))
                        <span class="text-danger">{{ $errors->first('tipe_penghitungan') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nilai</label>
                            <span class="input-group-text bg-light">Rp / %</span>
                            <input type="number" name="nilai" class="form-control" step="0.01" placeholder="Masukkan angka saja">
                        <small class="text-muted">Gunakan titik untuk desimal jika perlu.</small>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{route('komponen.index')}}" class="btn btn-success btn-sm">Kembali</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection