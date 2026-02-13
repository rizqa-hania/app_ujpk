<h2>Step 2</h2>

<form method="POST" action="{{ route('karyawan.store.step2') }}">
    @csrf

    <input type="text" name="nama_depan" placeholder="Nama Depan"><br>
    <input type="text" name="nama_belakang" placeholder="Nama Belakang"><br>
    <input type="text" name="nama_panggilan" placeholder="Nama Panggilan"><br>

    <button type="submit">Next</button>
</form>
