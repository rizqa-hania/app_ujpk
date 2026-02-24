@extends('template.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <h4>Form Pengajuan Izin</h4>
                </div>

                <div class="card-body">

                    {{-- Error Validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Tanggal Mulai --}}
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date"
                                   name="tanggal_mulai"
                                   class="form-control"
                                   value="{{ old('tanggal_mulai') }}"
                                   required>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date"
                                   name="tanggal_selesai"
                                   class="form-control"
                                   value="{{ old('tanggal_selesai') }}"
                                   required>
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan"
                                      class="form-control"
                                      rows="4"
                                      required>{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- Upload Bukti --}}
                        <div class="form-group">
                            <label>Upload Bukti (Opsional)</label>
                            <input type="file"
                                   name="file_bukti"
                                   class="form-control">
                            <small class="text-muted">
                                Format: jpg, png, pdf (max 2MB)
                            </small>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('izin.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Kirim Pengajuan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection