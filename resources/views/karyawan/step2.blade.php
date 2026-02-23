<h2>Step 2</h2>

<form method="POST" action="{{ route('karyawan.storestep2') }}">
    @csrf

    <input type="text" name="nama_lengkap" placeholder="Nama Depan"><br>
    <input type="text" name="nama_panggilan" placeholder="Nama Panggilan"><br>

    <button type="submit">Next</button>
</form>
