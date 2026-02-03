<h2>Tambah Kerja Sama</h2>

<form action="{{ route('master-kerja-sama.store') }}" method="POST">
    @csrf

    <label>Unit PLN</label><br>
    <select name="unitpln_id" required>
        <option value="">-- Pilih Unit PLN --</option>
        @foreach ($unitPln as $unit)
            <option value="{{ $unit->unitpln_id }}">
                {{ $unit->nama_unit }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Nama Kerja Sama</label><br>
    <input type="text" name="nama_kerja_sama" required>
    <br><br>

    <label>Mitra</label><br>
    <input type="text" name="mitra" required>
    <br><br>

    <label>Jenis Kerja Sama</label><br>
    <input type="text" name="jenis_kerjasama" required>
    <br><br>

    <label>Status</label><br>
    <select name="is_active">
        <option value="1">Aktif</option>
        <option value="0">Nonaktif</option>
    </select>
    <br><br>

    <button type="submit">Simpan</button>
    <a href="{{ route('master-kerja-sama.index') }}">Kembali</a>
</form>
