<h2>Step 10</h2>

<form method="POST" action="{{ route('karyawan.storestep10') }}">
    @csrf

    <input type="date" name="tanggal_mcu"><br>
    <input type="file" name="file_hasil_mcu"><br>
    <input type="text" name="perokok" placeholder="Perokok"><br>
    <input type="text" name="penyakit_bawaan" placeholder="Penyakit Bawaan"><br>

    <button type="submit">simpan</button>
</form>
