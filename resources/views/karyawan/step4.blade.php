<h2>Step 4 - Data Pribadi</h2>

<form method="POST" action="{{ route('karyawan.store.step4') }}">
    @csrf

    <input type="text" name="tempat_lahir" placeholder="Tempat Lahir"><br>
    <input type="date" name="tanggal_lahir"><br>
    <input type="text" name="jenis_kelamin" placeholder="Jenis Kelamin"><br>
    <input type="text" name="agama" placeholder="Agama"><br>
    <input type="text" name="suku_bangsa" placeholder="Suku Bangsa"><br>
    <input type="text" name="status_nikah" placeholder="Status Nikah"><br>
    <input type="number" name="jumlah_anak" placeholder="Jumlah Anak"><br>
    <input type="text" name="alamat" placeholder="Alamat"><br>

    <button type="submit">Next</button>
</form>
