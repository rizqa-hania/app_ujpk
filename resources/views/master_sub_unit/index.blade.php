<div class="container">
    <h4>Master Sub Unit (Kerja Sama)</h4>

    <a href="{{ route('master-sub-unit.create') }}" class="btn btn-primary mb-3">
        Tambah Kerja Sama
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Unit PLN</th>
                <th>Nama Kerja Sama</th>
                <th>Mitra</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->kode_sub }}</td>
                <td>{{ $row->unitPln->nama_unit }}</td>
                <td>{{ $row->nama_sub }}</td>
                <td>{{ $row->nama_mitra }}</td>
                <td>{{ $row->jenis_kerjasama }}</td>
                <td>
                    @if ($row->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('master-sub-unit.destroy', $row->sub_id) }}" method="POST"class="d-inline">
                @csrf
                @method('DELETE')
        <button class="btn btn-sm btn-danger"
                onclick="return confirm('Yakin hapus kerja sama ini?')">
            Hapus
        </button>
    </form>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
