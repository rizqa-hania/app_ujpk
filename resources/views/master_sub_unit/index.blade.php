<h4>Sub Unit</h4>
<a href="{{ route('sub-unit.create') }}" class="btn btn-success mb-2">
    + Tambah Sub Unit
</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Kode</th>
        <th>Unit PLN</th>
        <th>Nama Sub Unit</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @foreach ($subUnit as $row)
    <tr>
        <td>{{ $row->kode_sub }}</td>
        <td>{{ $row->unitPln->nama_unit }}</td>
        <td>{{ $row->nama_sub_unit }}</td>
        <td>{{ $row->is_active ? 'Aktif' : 'Nonaktif' }}</td>
        <td>
            <form method="POST" action="#">
                <button>Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<h4 class="mt-4">Kerja Sama</h4>
<a href="{{ route('kerja-sama.create') }}" class="btn btn-primary mb-2">
    + Tambah Kerja Sama
</a>

<table border="1" cellpadding="5">
    <tr>
        <th>Unit PLN</th>
        <th>Nama Kerja Sama</th>
        <th>Mitra</th>
        <th>Jenis</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @foreach ($kerjaSama as $row)
    <tr>
        <td>{{ $row->unitPln->nama_unit }}</td>
        <td>{{ $row->nama_kerja_sama }}</td>
        <td>{{ $row->mitra }}</td>
        <td>{{ $row->jenis_kerjasama }}</td>
        <td>{{ $row->is_active ? 'Aktif' : 'Nonaktif' }}</td>
        <td>
            <form method="POST" action="#">
                <button>Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

