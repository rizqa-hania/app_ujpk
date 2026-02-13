<h2>Step 6 - Pendidikan</h2>

<form method="POST" action="{{ route('karyawan.store.step6') }}" enctype="multipart/form-data">
    @csrf

    <input type="text" name="pendidikan_id" placeholder="Pendidikan"><br>
    <input type="text" name="nama_perguruan" placeholder="Nama Perguruan"><br>
    <input type="file" name="file_ijazah"><br>

    <button type="submit">Next</button>
</form>
