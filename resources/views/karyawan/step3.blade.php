<h2>Step 3</h2>

<form method="POST" action="{{ route('karyawan.store.step3') }}">
    @csrf

    <input type="number" name="tinggi_badan" placeholder="Tinggi Badan"><br>
    <input type="number" name="berat_badan" placeholder="Berat Badan"><br>
    <input type="text" name="gol_darah" placeholder="Golongan Darah"><br>
    <input type="text" name="ukuran_baju" placeholder="Ukuran Baju"><br>
    <input type="text" name="ukuran_celana" placeholder="Ukuran Celana"><br>

    @if($karyawan && $karyawan->jabatan && $karyawan->jabatan->is_satpam)
        <input type="number" name="ukuran_sepatu" placeholder="Ukuran Sepatu"><br>
    @endif

    <button type="submit">Next</button>
</form>
