<h2>Tambah Kantor</h2>

<form method="POST" action="{{ route('kantor.store') }}">
@csrf

<div>
    <label>Nama Kantor</label><br>
    <input type="text" name="nama_kantor" required>
</div>

<br>

<div>
    <label>Alamat</label><br>
    <input type="text" name="alamat">
</div>

<br>

<div>
    <label>Latitude</label><br>
    <input type="number" step="0.0000001" name="latitude" required>
</div>

<br>

<div>
    <label>Longitude</label><br>
    <input type="number" step="0.0000001" name="longitude" required>
</div>

<br>

<div>
    <label>Radius (Meter)</label><br>
    <input type="number" name="radius_meter" required>
</div>

<br>

<button type="submit">Simpan</button>
</form>
