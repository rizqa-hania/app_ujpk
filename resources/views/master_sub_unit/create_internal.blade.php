<div class="container">
    <h4>Tambah Sub Unit (Internal)</h4>

    <form action="{{ route('master-sub-unit.store') }}" method="POST">
        @csrf

        <div class="mb-2">
            <label>Unit PLN</label>
            <select name="unitpln_id" class="form-control" required>
                <option value="">-- Pilih Unit --</option>
                @foreach ($unitPln as $unit)
                    <option value="{{ $unit->unitpln_id }}">
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Kode Sub Unit</label>
            <input type="text" name="kode_sub" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Nama Sub Unit</label>
            <input type="text" name="nama_sub" class="form-control" required>
        </div>

        {{-- FIELD KERJA SAMA (DISEMBUNYIKAN) --}}
        <input type="hidden" name="nama_mitra" value="-">
        <input type="hidden" name="jenis_kerjasama" value="Internal">
        <input type="hidden" name="is_active" value="1">

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('master-sub-unit.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>