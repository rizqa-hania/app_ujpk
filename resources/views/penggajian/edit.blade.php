@extends('template.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-warning mt-4">
            <div class="card-header">
                <h3 class="card-title text-white"><i class="fas fa-edit mr-1"></i> Edit Data Penggajian</h3>
            </div>
            
            <form action="{{ route('penggajian.update', $dataeditpenggajian->penggajian_id) }}" method="POST">
                {{ csrf_field() }}
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Periode Bulan</label>
                        <select name="periode_bulan" class="form-control select2" required>
                            @php
                                $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $dataeditpenggajian->periode_bulan == $i ? 'selected' : '' }}>
                                    {{ $bulan[$i] }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Periode Tahun</label>
                        <input type="number" name="periode_tahun" class="form-control" 
                               value="{{ $dataeditpenggajian->periode_tahun }}" min="2000" max="2100" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control custom-select" required>
                            <option value="draft" {{ $dataeditpenggajian->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="approved" {{ $dataeditpenggajian->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="paid" {{ $dataeditpenggajian->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning text-white">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection