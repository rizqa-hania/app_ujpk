<div class="container">
    <h4>Tambah Kerja Sama</h4>

    <form action="{{ route('master-sub-unit.store') }}" method="POST">
    {{ csrf_field() }}

    <div class="mb-2">
        <label>Unit PLN</label>
        <select name="unitpln_id" class="form-control" required>
            <option value="">-- Pilih Unit --</option>
            @foreach ($unitPln as $unit)
                <option value="{{ $unit->unitpln_id }}">{{ $unit->nama_unit }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-2">
        <label>Kode Sub</label>
        <input type="text" name="kode_sub" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Nama Kerja Sama</label>
        <input type="text" name="nama_sub" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Nama Mitra</label>
        <input type="text" name="nama_mitra" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Jenis Kerja Sama</label>
        <input type="text" name="jenis_kerjasama" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" class="form-control">
    </div>

    <div class="mb-3">
        <label>Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" class="form-control">
    </div>

    <button class="btn btn-success" type="submit">Simpan</button>
    <a href="{{ route('master-sub-unit.index') }}" class="btn btn-secondary">Kembali</a>
</form>

</div>
