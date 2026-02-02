<h3> Tambah Pendidikan </h3>

<form action="{{route('master_pendidikan.store')}}" method="POST">
    @csrf

<div>
    <label>Kode Pendidikan</label><br>
    <input type="text" name="kode_pendidikan" required>
</div>

<div>
    <label>Name Pendidikan</label><br>
    <input type="text" name="nama_pendidikan" required>
</div>

<button type="submit">Simpan</button>
</form>

