<h3>Form Komponen</h3>
    <form action="{{ route('komponen.store') }}" method="POST">
        @csrf
        <label>Kode Penggajian</label>
        <input type="text" name="kode" required>
        <br>
        <label>Komponen</label>
        <input type="text" name="name" required>
        <br>
        <label>Tipe Komponen</label>
        <select name="tipe" required>
            <option value="">-- Pilih Tipe Komponen --</option>
            <option value="penghasilan">Penghasilan</option>
            <option value="potongan">Potongan</option>
        </select>
        <br>
        <label>Tipe Penghitungan</label>
        <select name="tipe_penghitungan" required>
            <option value="">-- Pilih Tipe Penghitungan --</option>
            <option value="tetap">Tetap</option>
            <option value="presentase">Presentase</option>
        </select>
        <br>
        <label>Nilai</label>
        <input type="number" name="nilai" required>
        <br>
        <button type="submit">Simpan</button>
        <a href="{{ route('komponen.index') }}">Kembali</a>
    </form>
