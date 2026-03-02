@extends('template.layout')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">

        <h5 class="mb-0">Data Lembur</h5>

        {{-- Hanya USER yang bisa ajukan lembur --}}
        @if(Auth::user()->role == 'user')
            <a href="{{ route('lembur.create') }}" class="btn btn-primary">
                Ajukan Lembur
            </a>
        @endif

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        @if(Auth::user()->role == 'admin')
                            <th>NIP</th>
                        @endif
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($data as $row)
                    <tr>

                        {{-- Admin bisa lihat NIP --}}
                        @if(Auth::user()->role == 'admin')
                            <td>{{ $row->nip }}</td>
                        @endif

                        <td>
                            {{ $row->tanggal_mulai }} 
                            s/d 
                            {{ $row->tanggal_selesai }}
                        </td>

                        <td>
                            {{ $row->jam_mulai }} - {{ $row->jam_selesai }}
                        </td>

                        <td>{{ $row->keterangan }}</td>

                        <td>
                            @if($row->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($row->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($row->status == 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>

                        <td>

                            {{-- ===================== --}}
                            {{-- AKSI ADMIN --}}
                            {{-- ===================== --}}
                            @if(Auth::user()->role == 'admin' && $row->status == 'pending')

                                <form action="{{ route('lembur.status', $row->lembur_id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="status" value="disetujui">

                                    <button class="btn btn-sm btn-success">
                                        Setuju
                                    </button>
                                </form>

                                <form action="{{ route('lembur.status', $row->lembur_id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="status" value="ditolak">

                                    <button class="btn btn-sm btn-danger">
                                        Tolak
                                    </button>
                                </form>

                            @endif

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data lembur
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection