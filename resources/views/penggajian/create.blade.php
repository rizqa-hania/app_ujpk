@extends('template.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('penggajian.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="mb-3">
                        <label for="periode_bulan" class="form-label">Periode Bulan</label>
                        <select name="periode_bulan" class="form-control" id="periode_bulan" required>
                            <option value="">-- Pilih Bulan --</option>
                            @php
                                $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $bulan[$i] }}">{{ $bulan[$i] }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="periode_tahun" class="form-label">Periode Tahun</label>
                        <input type="number" name="periode_tahun" class="form-control" id="periode_tahun" placeholder="Contoh: 2024" min="2000" max="2100" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control" id="status" required>
                            <option value="draft">Draft</option>
                            <option value="approved">Approved</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-secondary px-4">Kembali</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection