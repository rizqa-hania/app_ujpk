@extends('template.admin.layout')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h5>Data Lembur</h5>

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

            <table class="table table-bordered">

                <thead>
                    <tr>

                        @if(Auth::user()->role == 'admin')
                            <th>NIP</th>
                            <th>User</th>
                        @endif

                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Keterangan</th>
                        <th>Status</th>

                        @if(Auth::user()->role == 'admin')
                            <th width="200">Aksi</th>
                        @endif

                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $row)

                    <tr>

                        @if(Auth::user()->role == 'admin')

                            <td>
                                {{ $row->nip ?? '-' }}
                            </td>

                            <td>
                                {{ $row->karyawan->user->name ?? '-' }}
                            </td>

                        @endif

                        <td>
                            {{ $row->tanggal_mulai }}
                            s/d
                            {{ $row->tanggal_selesai }}
                        </td>

                        <td>
                            {{ $row->jam_mulai }}
                            -
                            {{ $row->jam_selesai }}
                        </td>

                        <td>
                            {{ $row->keterangan }}
                        </td>

                        <td>

                            @if($row->status == 'pending')
                                <span class="badge badge-warning">
                                    Pending
                                </span>

                            @elseif($row->status == 'disetujui')
                                <span class="badge badge-success">
                                    Disetujui
                                </span>

                            @elseif($row->status == 'ditolak')
                                <span class="badge badge-danger">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        @if(Auth::user()->role == 'admin')

                        <td>

                            @if($row->status == 'pending')

                                <form 
                                    action="{{ route('lembur.approve', $row->lembur_id) }}"
                                    method="POST"
                                    style="display:inline"
                                >

                                    @csrf

                                    <button class="btn btn-success btn-sm">
                                        Setujui
                                    </button>

                                </form>

                                <form 
                                    action="{{ route('lembur.reject', $row->lembur_id) }}"
                                    method="POST"
                                    style="display:inline"
                                >

                                    @csrf

                                    <button class="btn btn-danger btn-sm">
                                        Tolak
                                    </button>

                                </form>

                            @else

                                <span class="text-muted">
                                    Tidak ada aksi
                                </span>

                            @endif

                        </td>

                        @endif

                    </tr>

                    @empty

                    <tr>
                        <td colspan="{{ Auth::user()->role == 'admin' ? 7 : 5 }}" class="text-center">
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