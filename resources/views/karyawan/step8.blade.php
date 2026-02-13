<h2>Step 8 - Dokumen Lamaran</h2>

<form method="POST" action="{{ route('karyawan.store.step8') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" name="file_surat_lamaran"><br>
    <input type="file" name="file_cv"><br>
    <input type="file" name="file_pakta_integritas"><br>
    <input type="file" name="file_date_consist"><br>

    <button type="submit">Next</button>
</form>
