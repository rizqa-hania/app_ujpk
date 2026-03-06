<!-- -->
@extends('template.layout')
@section('content')
 <div class="col-12">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
<div class="row"> 
    
    <div class="col-12">
        <div class="card"> 
            <div class="card-header">
                <h3 class="card-title">Master Sub Unit</h3> 
                <div class="card-tools">
                    <a href="{{ route('master-sub-unit.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Master Sub Unit
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive"> 
                <table id="table" class="table table-stripped table-hover"> 
                     <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Unit PLN</th>
                                        <th>Nama Sub Unit</th>
                                        <th>Status</th>
                                        <th width="120px">Aksi</th>
                                    </tr>
                                </thead>
                   <tbody>
                                    @forelse ($subUnits as $item)
                                        <tr>
                                            <td>{{ $item->kode_sub }}</td>
                                            <td>{{ $item->unitPln->nama_unit ?? '-' }}</td>
                                            <td>{{ $item->nama_sub_unit }}</td>
                                            <td>
                                                @if($item->is_active)
                                                    <span class="badge badge-success">Aktif</span>
                                                @else
                                                    <span class="badge badge-danger">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('master-sub-unit.destroy', $item->sub_id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Yakin hapus?')"
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                Data tidak ditemukan
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
