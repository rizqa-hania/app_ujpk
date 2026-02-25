@extends('template.layout')

@php
// Check if karyawan is driver or satpam based on kode_jabatan
// 03 = Satpam, 06 = Driver
$kodeJabatan = optional($karyawan->jabatan)->kode_jabatan ?? '';
$isDriver = (strpos($kodeJabatan, '06') !== false);
$isSatpam = (strpos($kodeJabatan, '03') !== false);
$showDriverSatpam = $isDriver || $isSatpam;
@endphp

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                @if($showDriverSatpam)
                    Step 11 - Driver/Satpam
                @else
                    Step 11 - Final
                @endif
            </h3>
        </div>

        <form action="{{ route('karyawan.storestep11') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                @if($showDriverSatpam)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Anda memasuki step khusus karena jabatan Anda adalah 
                    @if($isDriver && $isSatpam) Driver & Satpam
                    @elseif($isDriver) Driver
                    @elseif($isSatpam) Satpam
                    @endif
                </div>
                @endif

                {{-- DRIVER (SIM A) FIELDS --}}
                @if($isDriver)
                <h5 class="text-primary"><i class="fas fa-car mr-1"></i> Driver (SIM A)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No SIM A</label>
                            <input type="text" name="no_sim_a" class="form-control" value="{{ old('no_sim_a', optional($karyawan)->no_sim_a) }}" placeholder="Masukkan nomor SIM A">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Masa Berlaku SIM</label>
                            <input type="date" name="masa_berlaku_sim" class="form-control" value="{{ old('masa_berlaku_sim', optional($karyawan)->masa_berlaku_sim) }}">
                            @if(optional($karyawan)->masa_berlaku_sim)
                                <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->masa_berlaku_sim)->format('d/m/Y') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File SIM A (PDF/Foto)</label>
                            <input type="file" name="file_sim" class="form-control" accept="image/*,.pdf">
                            @if(optional($karyawan)->file_sim)
                                <small class="text-success">File sudah ada: {{ $karyawan->file_sim }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jumlah Tilang 6 Bulan Terakhir</label>
                            <input type="number" name="jumlah_tilang_6_bulan" class="form-control" value="{{ old('jumlah_tilang_6_bulan', optional($karyawan)->jumlah_tilang_6_bulan) }}" min="0" placeholder="0">
                        </div>
                    </div>
                </div>
                @endif

                {{-- SATPAM (KTA & SERTIFIKAT GARDA) FIELDS --}}
                @if($isSatpam)
                <h5 class="text-primary mt-3"><i class="fas fa-shield-alt mr-1"></i> Satpam (KTA & Sertifikat Garda)</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No KTA</label>
                            <input type="text" name="no_kta" class="form-control" value="{{ old('no_kta', optional($karyawan)->no_kta) }}" placeholder="Masukkan nomor KTA">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Masa Berlaku KTA</label>
                            <input type="date" name="masa_berlaku_kta" class="form-control" value="{{ old('masa_berlaku_kta', optional($karyawan)->masa_berlaku_kta) }}">
                            @if(optional($karyawan)->masa_berlaku_kta)
                                <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->masa_berlaku_kta)->format('d/m/Y') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File KTA (PDF/Foto)</label>
                            <input type="file" name="file_kta" class="form-control" accept="image/*,.pdf">
                            @if(optional($karyawan)->file_kta)
                                <small class="text-success">File sudah ada: {{ $karyawan->file_kta }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pangkat Garda</label>
                            <select name="pangkat_garda" class="form-control">
                                <option value="">-- Pilih Pangkat --</option>
                                <option value="pratama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'pratama' ? 'selected' : '' }}>Pratama</option>
                                <option value="madya" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'madya' ? 'selected' : '' }}>Madya</option>
                                <option value="utama" {{ old('pangkat_garda', optional($karyawan)->pangkat_garda) == 'utama' ? 'selected' : '' }}>Utama</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No Sertifikat Garda</label>
                            <input type="text" name="no_sertifikat_garda" class="form-control" value="{{ old('no_sertifikat_garda', optional($karyawan)->no_sertifikat_garda) }}" placeholder="Masukkan nomor sertifikat">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>File Sertifikat Garda (PDF/Foto)</label>
                            <input type="file" name="file_sertifikat_garda" class="form-control" accept="image/*,.pdf">
                            @if(optional($karyawan)->file_sertifikat_garda)
                                <small class="text-success">File sudah ada: {{ $karyawan->file_sertifikat_garda }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if(!$showDriverSatpam)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> 
                    Anda tidak memerlukan data tambahan Driver/Satpam. Silakan klik tombol selesai untuk menyelesaikan pengisisan data.
                </div>
                @endif
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check mr-1"></i> Simpan & Selesai
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
