<h3> Tambahan Unit</h3>

<form action="{{route('master_unit_pln.store')}}" method="POST">
    @csrf

<div>
    <label> Kode Unit</label><br>
    <input type="text" name="kode_unit" required>
</div>

<div>
    <label> Nama Unit </label><br>
    <input type="text" name="nama_unit" required>
</div>

<button type="submit">Simpan</button>
</form>