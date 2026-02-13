<h2>Step 9 - Pengalaman Kerja</h2>

<form method="POST" action="{{ route('karyawan.store.step9') }}">
    @csrf

    <textarea name="pengalaman_kerja_1" placeholder="Pengalaman Kerja 1"></textarea><br>
    <textarea name="pengalaman_kerja_2" placeholder="Pengalaman Kerja 2"></textarea><br>
    <textarea name="pengalaman_kerja_3" placeholder="Pengalaman Kerja 3"></textarea><br>

    <button type="submit">Next</button>
</form>
