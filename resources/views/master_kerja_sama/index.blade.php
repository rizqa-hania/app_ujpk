@extends('template.layout')
@section('content')

<!-- Tombol Kembali -->
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="card-title font-weight-bold mb-0">
                        Data Master Kerja Sama
                    </h3>

                    <a href="{{ route('master-kerja-sama.create') }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kerja Sama
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Unit PLN</th>
                            <th>Nama Kerja Sama</th>
                            <th>Mitra</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $item)
                        <tr>
                            <td>{{ $item->unitPln->nama_unit ?? '-' }}</td>
                            <td>{{ $item->nama_kerja_sama }}</td>
                            <td>{{ $item->mitra }}</td>
                            <td>{{ $item->jenis_kerjasama }}</td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('master-kerja-sama.destroy', $item->kerjasama_id) }}"
                                      method="POST"
                                      style="display:inline"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Data kerja sama belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>
@push('js')
<script>
    new DataTable('#table');
</script>
@endpush
@endsection