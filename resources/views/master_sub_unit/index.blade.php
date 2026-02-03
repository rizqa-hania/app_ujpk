<h2>Master Sub Unit</h2>

{{-- ================= SUB UNIT (ATAS) ================= --}}
<h3>Tambah Sub Unit</h3>

<form action="{{ route('master-sub-unit.store') }}" method="POST">
    @csrf

    <select name="unitpln_id" required>
        <option value="">-- Pilih Unit PLN --</option>
        @foreach ($units as $unit)
            <option value="{{ $unit->unitpln_id }}">
                {{ $unit->nama_unit }}
            </option>
        @endforeach
    </select>

    <input type="text" name="kode_sub" placeholder="Kode Sub Unit" required>
    <input type="text" name="nama_sub" placeholder="Nama Sub Unit" required>

    <button type="submit">Tambah</button>
</form>

<br>

<table border="1" cellpadding="5">
    <tr>
        <th>Kode</th>
        <th>Unit PLN</th>
        <th>Nama Sub Unit</th>
        <th>Aksi</th>
    </tr>

    @foreach ($subUnits as $item)
    <tr>
        <td>{{ $item->kode_sub }}</td>
        <td>{{ $item->unitPln->nama_unit ?? '-' }}</td>
        <td>{{ $item->nama_sub }}</td>
        <td>
            <form action="{{ route('master-sub-unit.destroy', $item->sub_id) }}"
                  method="POST"
                  style="display:inline;">
                @csrf
                <button type="submit"
                        onclick="return confirm('Yakin hapus?')">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<hr>

{{-- ================= KERJA SAMA (BAWAH) ================= --}}
<h3>Data Kerja Sama</h3>

<table border="1" cellpadding="5">
    <tr>
        <th>Kode</th>
        <th>Unit PLN</th>
        <th>Nama Kerja Sama</th>
        <th>Mitra</th>
        <th>Jenis</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    {{-- nanti diisi dari tabel kerja sama --}}
</table>
