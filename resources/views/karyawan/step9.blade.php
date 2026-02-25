@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 9 - Pengalaman Kerja</h3>
        </div>

        <form action="{{ route('karyawan.storestep9') }}" method="POST">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>Pengalaman Kerja 1</label>
                    <textarea name="pengalaman_kerja_1" class="form-control" rows="3">{{ old('pengalaman_kerja_1', optional($karyawan)->pengalaman_kerja_1) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Pengalaman Kerja 2</label>
                    <textarea name="pengalaman_kerja_2" class="form-control" rows="3">{{ old('pengalaman_kerja_2', optional($karyawan)->pengalaman_kerja_2) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Pengalaman Kerja 3</label>
                    <textarea name="pengalaman_kerja_3" class="form-control" rows="3">{{ old('pengalaman_kerja_3', optional($karyawan)->pengalaman_kerja_3) }}</textarea>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Simpan & Lanjut</button>
            </div>
        </form>
    </div>
</div>

@endsection
