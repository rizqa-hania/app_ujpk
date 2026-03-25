@extends('template.admin.layout')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Pengaturan Jadwal Absensi</h5>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('jadwal.update') }}" method="POST">
            @csrf

            @foreach(['senin','selasa','rabu','kamis','jumat','sabtu','minggu'] as $hari)

            <div class="border rounded p-3 mb-4">

                <div class="row align-items-center">

                    {{-- Nama Hari --}}
                    <div class="col-md-3">
                        <h6 class="mb-1 text-capitalize">{{ $hari }}</h6>

                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox"
                                   class="custom-control-input"
                                   id="{{ $hari }}"
                                   name="{{ $hari }}"
                                   {{ $jadwal->$hari ? 'checked' : '' }}>
                            <label class="custom-control-label" for="{{ $hari }}">
                                Aktifkan
                            </label>
                        </div>
                    </div>

                    {{-- Jam Masuk --}}
                    <div class="col-md-4">
                        <label>Jam Masuk</label>
                        <input type="time"
                               name="jam_masuk_{{ $hari }}"
                               class="form-control"
                               value="{{ $jadwal->{'jam_masuk_'.$hari} }}">
                    </div>

                    {{-- Jam Pulang --}}
                    <div class="col-md-4">
                        <label>Jam Pulang</label>
                        <input type="time"
                               name="jam_pulang_{{ $hari }}"
                               class="form-control"
                               value="{{ $jadwal->{'jam_pulang_'.$hari} }}">
                    </div>

                </div>

                {{-- Badge Status --}}
                <div class="mt-3">
                    @if($jadwal->$hari)
                        <span class="badge badge-success">
                            Hari Aktif
                        </span>
                    @else
                        <span class="badge badge-danger">
                            Hari Nonaktif
                        </span>
                    @endif
                </div>

            </div>

            @endforeach

            <div class="text-right">
                <button class="btn btn-primary px-4">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>
@push('js')
<script>
    new DataTable('#table');
</script>
@endpush
@endsection