<h3>Form Komponen</h3>
<form action="{{ route('komponen.store')}}" method="POST">
    {{ csrf_field() }}
    <label>Kode Komponen</label>
    <input type="text" name="kode" required>
    <br>
    <label>Komponen</label>
    <input type="text" name="komponen" required>
    <br>
    <label>Tipe Komponen</label>
    <select name="tipe">
        <option value="pendapatan">Pendapatan</option>
        <option value="potongan">Potongan</option>
    </select>
    <br>
    <label>Tipe Penghitungan</label>
    <select name="tipe_penghitungan">
        <option value="nominal">Nominal</option>
        <option value="presentase">Presentase (%)</option>
    </select>
    <br>
    <label>Nilai</label>
    <input type="number" name="nilai" step="0.01">
    <button type="submit">Simpan</button>
    <a href="{{ route('komponen.index') }}">Back</a>
</form>