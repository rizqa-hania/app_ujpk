<h3>Form Edit</h3>
<form action="{{ route('komponen.update', $komponen->komponen_id) }}" method="POST">
    {{ csrf_field() }}
    @method('PUT')
    <label>Komponen</label>
    <input type="text" name="name" value="{{ $komponen->name }}" required>
    <br>
    <label>Tipe Komponen</label>
    <select name="tipe" required>
        <option value="">-- Pilih Tipe Komponen --</option>
        <option value="penghasilan" {{ $komponen->tipe == 'penghasilan' ? 'selected' : '' }}>Penghasilan</option>
        <option value="potongan" {{ $komponen->tipe == 'potongan' ? 'selected' : '' }}>Potongan</option>
    </select>
    <br>
    <label>Tipe Penghitungan</label>
    <select name="tipe_penghitungan" required>
        <option value="">-- Pilih Tipe Penghitungan --</option>
        <option value="tetap" {{ $komponen->tipe_penghitungan == 'tetap' ? 'selected' : '' }}>Tetap</option>
        <option value="presentase" {{ $komponen->tipe_penghitungan == 'presentase' ? 'selected' : '' }}>Presentase</option>
    </select>
    <br>
    <label>Nilai</label>
    <input type="number" name="nilai" value="{{ $komponen->nilai }}" required>
    <br>
    <button type="submit">Update</button>
    <a href="{{ route('komponen.index') }}">Back</a>
</form>