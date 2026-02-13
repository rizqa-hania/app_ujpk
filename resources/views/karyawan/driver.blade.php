<h2>Data Driver</h2>

<form method="POST" action="{{ route('karyawan.store.stepkhusus') }}">
    @csrf

    <input type="text" name="no_sim_a" placeholder="No SIM A"><br>
    <input type="date" name="masa_berlaku_sim"><br>
    <input type="number" name="jumlah_tilang_6_bulan" placeholder="Jumlah Tilang"><br>

    <button type="submit">Finish</button>
</form>
