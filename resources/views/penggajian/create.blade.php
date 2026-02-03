<h3>Form Penggajian</h3>
<form action="{{ route('penggajian.store') }}" method="POST">
    {{ csrf_field() }}
    <label>Periode Bulan:</label>
    <select name="periode_bulan" required>
        <option value="">-- Pilih Bulan --</option>
        @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>
    <br>
    <label>Periode Tahun:</label>
    <input type="number" name="periode_tahun" min="2000" max="2100" required>
    <br>
    <label>Status:</label>
    <select name="status" required>
        <option value="draft">Draft</option>
        <option value="approved">Approved</option>
        <option value="paid">Paid</option>
    </select>
    <br>
    <button type="submit">Simpan</button>
    <a href="{{ route('penggajian.index') }}">Kembali</a>
</form>
