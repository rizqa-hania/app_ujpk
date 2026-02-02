<h3>Form Edit</h3>
<form action="{{ route('penggajian.update', $dataeditpenggajian->penggajian_id) }}" method="POST">
    {{ csrf_field() }}
    @method('PUT')
    <label>Periode Bulan:</label>
    <select name="periode_bulan" required>
        @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ $dataeditpenggajian->periode_bulan == $i ? 'selected' : '' }}>
                {{ $i }}
            </option>
        @endfor
    </select>
    <br>
    <label>Periode Tahun:</label>
    <input type="number" name="periode_tahun" value="{{ $dataeditpenggajian->periode_tahun }}" min="2000" max="2100" required>
    <br>
    <label>Status:</label>
    <select name="status" required>
        <option value="draft" {{ $dataeditpenggajian->status == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="approved" {{ $dataeditpenggajian->status == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="paid" {{ $dataeditpenggajian->status == 'paid' ? 'selected' : '' }}>Paid</option>
    </select>
    <br>
    <button type="submit">Update</button>
</form>