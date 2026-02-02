<h3> Tambahan Project</h3>

<form action="{{route('master_project.store')}}" method="POST">
    @csrf

<div>
    <label> Kode Project</label><br>
    <input type="text" name="kode_project" required>
</div>

<div>
    <label> Nama Project </label><br>
    <input type="text" name="nama_project" required>
</div>

<button type="submit">Simpan</button>
</form>