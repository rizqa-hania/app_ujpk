@extends('template.layout')

@section('content')

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">

                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Form Input Data Sub Unit</h3>
                        </div>

                        <form action="{{ route('master-sub-unit.store') }}" method="POST">
                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    <!-- Unit PLN -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Unit PLN</label>
                                            <select name="unitpln_id" class="form-control" required>
                                                <option value=""> Pilih Unit PLN </option>
                                                @foreach ($unitPln as $unit)
                                                    <option value="{{ $unit->unitpln_id }}">
                                                        {{ $unit->nama_unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Kode Sub Unit -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kode Sub Unit</label>
                                            <input type="text"
                                                   name="kode_sub"
                                                   class="form-control"
                                                   placeholder="Masukkan kode sub unit"
                                                   required>
                                        </div>
                                    </div>

                                    <!-- Nama Sub Unit -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Sub Unit</label>
                                            <input type="text"
                                                   name="nama_sub_unit"
                                                   class="form-control"
                                                   placeholder="Masukkan nama sub unit"
                                                   required>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="is_active" class="form-control">
                                                <option value="1">Aktif</option>
                                                <option value="0">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>

                                <a href="{{ route('master-sub-unit.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </section>


@endsection