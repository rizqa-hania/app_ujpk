@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Data Lembur</h4>

    <a href="{{ route('lembur.create') }}" class="btn btn-primary mb-3">
        Ajukan Lembur
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->nip }}</td>
                <td>{{ $row->tanggal_mulai }} s/d {{ $row->tanggal_selesai }}</td>
                <td>{{ $row->jam_mulai }} - {{ $row->jam_selesai }}</td>
                <td>
                    <span class="badge 
                        @if($row->status=='pending') bg-warning
                        @elseif($row->status=='disetujui') bg-success
                        @else bg-danger @endif">
                        {{ $row->status }}
                    </span>
                </td>
                <td>{{ $row->keterangan }}</td>
                <td>
                    @if($row->status == 'pending')
                    <form action="{{ route('lembur.status', $row->lembur_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <select name="status" class="form-control mb-1">
                            <option value="disetujui">Setujui</option>
                            <option value="ditolak">Tolak</option>
                        </select>

                        <input type="text" name="keterangan"
                               class="form-control mb-1"
                               placeholder="Keterangan">

                        <button class="btn btn-sm btn-primary">
                            Simpan
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
