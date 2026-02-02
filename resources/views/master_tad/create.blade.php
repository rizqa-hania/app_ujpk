<h3> Tambahan TAD</h3>

<form action="{{route('master_tad.store')}}" method="POST">
    @csrf

<div>
    <label> Kode TAD</label><br>
    <input type="text" name="kode_tad" required>
</div>

<div>
    <label> Nama TAD </label><br>
    <input type="text" name="nama_tad" required>
</div>

<button type="submit">Simpan</button>
</form>