<h2>Step 7 - Dokumen Pribadi</h2>

<form method="POST" action="{{ route('karyawan.store.step7') }}" enctype="multipart/form-data">
    @csrf

    <input type="text" name="no_ktp" placeholder="No KTP"><br>
    <input type="file" name="file_ktp"><br>

    <input type="text" name="no_kk" placeholder="No KK"><br>
    <input type="file" name="file_kk"><br>

    <input type="text" name="no_npwp" placeholder="No NPWP"><br>
    <input type="file" name="file_npwp"><br>

    <input type="text" name="no_rg_bank" placeholder="No Rekening"><br>
    <input type="text" name="nama_bank" placeholder="Nama Bank"><br>
    <input type="file" name="file_buku_tabungan"><br>

    <input type="text" name="no_bpjs" placeholder="No BPJS"><br>
    <input type="file" name="file_bpjs"><br>

    <input type="text" name="no_rek_bplk" placeholder="No Rek BPLK"><br>
    <input type="file" name="file_buku_bplk"><br>

    <button type="submit">Next</button>
</form>
