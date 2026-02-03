<h2>Master Kerja Sama</h2>

<a href="{{ route('master-kerja-sama.create') }}">
    <button>Tambah Kerja Sama</button>
</a>

<br><br>

<table border="1" cellpadding="5">
    <tr>
        <th>Unit PLN</th>
        <th>Nama Kerja Sama</th>
        <th>Mitra</th>
        <th>Jenis</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach ($data as $item)
    <tr>
        <td>{{ $item->unitPln->nama_unit ?? '-' }}</td>
        <td>{{ $item->nama_kerja_sama }}</td>
        <td>{{ $item->mitra }}</td>
        <td>{{ $item->jenis_kerjasama }}</td>
        <td>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</td>
        <td>
            <form action="{{ route('master-kerja-sama.destroy', $item->kerjasama_id) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')
                <button>Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
