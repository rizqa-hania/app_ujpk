<h3>Tambah Jabatan</h3>

<form action="{{ route('master_jabatan.store') }}" method="POST">
    @csrf

    <div>
        <label>Kode Jabatan</label><br>
        <input type="text" name="kode_jabatan" required>
    </div>

    <div>
        <label>Nama Jabatan</label><br>
        <input type="text" name="nama_jabatan" required>
    </div>

    <button type="submit">Simpan</button>
</form>