@extends('template.layout')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"></div>
            <form action="{{ route('detail.store', $penggajian->penggajian_id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="id" class="form-label">NIP</label>
                        <select name="tipe" class="form-control">
                            <option value="">-- Pilih NIP --</option>
                            @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nip }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Komponen</label>
                        <select name="tipe" class="form-control">
                            <option value="">-- Pilih Komponen --</option>
                            @foreach($komponen as $k)
                            <option value="{{ $k->kode }}">{{ $k->kode }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection