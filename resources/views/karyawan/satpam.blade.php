<h2>Data Satpam</h2>

<form method="POST" action="{{ route('karyawan.store.stepkhusus') }}">
    @csrf

    <input type="text" name="no_kta" placeholder="No KTA"><br>
    <input type="date" name="masa_berlaku_kta"><br>
    <input type="text" name="pangkat_garda" placeholder="Pangkat Garda"><br>

    <button type="submit">Finish</button>
</form>
