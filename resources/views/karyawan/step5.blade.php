<h2>Step 5 - Kontak</h2>

<form method="POST" action="{{ route('karyawan.store.step5') }}">
    @csrf

    <input type="text" name="no_hp_utama" placeholder="No HP Utama"><br>
    <input type="text" name="no_hp_cadangan" placeholder="No HP Cadangan"><br>
    <input type="email" name="email_pribadi" placeholder="Email Pribadi"><br>
    <input type="text" name="instagram" placeholder="Instagram"><br>
    <input type="text" name="facebook" placeholder="Facebook"><br>
    <input type="text" name="nama_kontak_darurat" placeholder="Nama Kontak Darurat"><br>

    <button type="submit">Next</button>
</form>
