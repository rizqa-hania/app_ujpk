@extends('template.admin.layout')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                Update Detail Penggajian
            </div>
            <form action="{{ route('detail.store', $penggajian->penggajian_id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <!-- Data Karyawan -->
                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Nama Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawan as $k)
                                <option value="{{ $k->id }}" data-nip="{{ $k->nip }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('karyawan_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP (otomatis)</label>
                        <input type="text" name="nip" id="nip" class="form-control" readonly required placeholder="Terisi otomatis"> 
                    </div>

                    <hr>

                    <!-- Rincian Komponen Gaji -->
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <label class="form-label font-weight-bold">Komponen Gaji</label>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-add-row">Tambah Komponen</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Kode Komponen</th>
                                    <th>Tipe (otomatis)</th>
                                    <th>Nilai (otomatis)</th>
                                    <th width="50" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="komponen-list">
                                <!-- Dynamic rows go here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('detail.index', $penggajian->penggajian_id) }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Template Baris Baru --}}
<template id="row-template">
    <tr>
        <td>
            <select name="kode[]" class="form-control select-komponen" required>
                <option value="">-- Pilih Komponen --</option>
                @foreach($komponen as $ko)
                    <option value="{{ $ko->kode }}" 
                            data-tipe="{{ $ko->tipe }}" 
                            data-nilai="{{ $ko->nilai }}" 
                            data-tipe-penghitungan="{{ $ko->tipe_penghitungan }}">
                        {{ $ko->kode }} - {{ $ko->komponen }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="tipe[]" class="form-control input-tipe" readonly required>
        </td>
        <td>
            <input type="number" step="0.01" name="nilai[]" class="form-control input-nilai" readonly required>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm btn-remove-row">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Karyawan Change Handler
    $('#karyawan_id').on('change', function() {
        let selectedOption = $(this).find(':selected');
        let nip = selectedOption.data('nip');
        $('#nip').val(nip ?? '');
    });

    // Fungsi Add Row
    $('#btn-add-row').on('click', function() {
        let template = $('#row-template').html();
        $('#komponen-list').append(template);
    });

    // Remove Row
    $(document).on('click', '.btn-remove-row', function() {
        $(this).closest('tr').remove();
    });

    // Komponen Change Handler (Dynamic)
    $(document).on('change', '.select-komponen', function() {
        let selectedOption = $(this).find(':selected');
        let tr = $(this).closest('tr');
        
        let tipe = selectedOption.data('tipe');
        let nilai = selectedOption.data('nilai');

        tr.find('.input-tipe').val(tipe ?? '');
        tr.find('.input-nilai').val(nilai ?? '');
    });

    // Initialize with 1 row
    $('#btn-add-row').trigger('click');
});
</script>
@endpush