
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
            <h3 class="card-title">Step 10 - Kesehatan</h3>
        </div>

        <form action="{{ route('karyawan.storestep10') }}" method="POST" enctype="multipart/form-data">
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
                    Setelah step ini, Anda akan melanjutkan ke step akhir untuk mengisi data 
                    @if($isDriver && $isSatpam) Driver & Satpam
                    @elseif($isDriver) Driver (SIM A)
                    @elseif($isSatpam) Satpam (KTA & Sertifikat Garda)
                    @endif
                </div>
                @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> 
                    Setelah step ini, Anda akan langsung ke halaman terakhir untuk menyelesaikan pengisisan data.
                </div>
                @endif

                <div class="form-group">
                    <label>Tanggal MCU</label>
                    <input type="date" name="tanggal_mcu" class="form-control" value="{{ old('tanggal_mcu', optional($karyawan)->tanggal_mcu) }}">
                    @if(optional($karyawan)->tanggal_mcu)
                        <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_mcu)->format('d/m/Y') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>File Hasil MCU (PDF/Foto)</label>
                    <input type="file" name="file_hasil_mcu" class="form-control" accept="image/*,.pdf">
                    @if(optional($karyawan)->file_hasil_mcu)
                        <small class="text-success">File sudah ada: {{ $karyawan->file_hasil_mcu }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Perokok</label>
                    <select name="perokok" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('perokok', optional($karyawan)->perokok) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('perokok', optional($karyawan)->perokok == '0') ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Penyakit Bawaan</label>
                    <textarea name="penyakit_bawaan" class="form-control" rows="2">{{ old('penyakit_bawaan', optional($karyawan)->penyakit_bawaan) }}</textarea>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    @if($showDriverSatpam)
                        Simpan & Lanjut (Driver/Satpam)
                    @else
                        Simpan & Selesai
                    @endif
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
