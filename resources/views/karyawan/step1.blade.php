@extends('template.layout')

@section('content')

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Step 1 - Data Kerja</h3>
        </div>

        <form action="{{ route('karyawan.storestep1') }}" method="POST">
            @csrf

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ old('nip', optional($karyawan)->nip) }}" required>
                </div>

                <div class="form-group">
                    <label>Unit PLN</label>
                    <select name="unitpln_id" class="form-control" required>
                        <option value="">-- Pilih Unit PLN --</option>
                        @foreach($unitpln as $unit)
                            <option value="{{ $unit->unitpln_id }}" {{ old('unitpln_id', optional($karyawan)->unitpln_id) == $unit->unitpln_id ? 'selected' : '' }}>
                                {{ $unit->nama_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan_id" class="form-control" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->jabatan_id }}" {{ old('jabatan_id', optional($karyawan)->jabatan_id) == $j->jabatan_id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Sub Unit</label>
                    <select name="sub_id" class="form-control" required>
                        <option value="">-- Pilih Sub Unit --</option>
                        @foreach($subunit as $sub)
                            <option value="{{ $sub->sub_id }}" {{ old('sub_id', optional($karyawan)->sub_id) == $sub->sub_id ? 'selected' : '' }}>
                                {{ $sub->nama_sub_unit }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>TAD</label>
                    <select name="tad_id" class="form-control" required>
                        <option value="">-- Pilih TAD --</option>
                        @foreach($tad as $t)
                            <option value="{{ $t->tad_id }}" {{ old('tad_id', optional($karyawan)->tad_id) == $t->tad_id ? 'selected' : '' }}>
                                {{ $t->nama_tad }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Project</label>
                    <select name="project_id" class="form-control" required>
                        <option value="">-- Pilih Project --</option>
                        @foreach($project as $p)
                            <option value="{{ $p->project_id }}" {{ old('project_id', optional($karyawan)->project_id) == $p->project_id ? 'selected' : '' }}>
                                {{ $p->nama_project }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan_id" class="form-control" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach($pendidikan as $pen)
                            <option value="{{ $pen->pendidikan_id }}" {{ old('pendidikan_id', optional($karyawan)->pendidikan_id) == $pen->pendidikan_id ? 'selected' : '' }}>
                                {{ $pen->nama_pendidikan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai Aktif</label>
                    <input type="date" name="tanggal_mulai_aktif" class="form-control" value="{{ old('tanggal_mulai_aktif', optional($karyawan)->tanggal_mulai_aktif) }}">
                    @if(optional($karyawan)->tanggal_mulai_aktif)
                        <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_mulai_aktif)->format('d/m/Y') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Unit Penempatan</label>
                    <input type="text" name="unit_penempatan" class="form-control" value="{{ old('unit_penempatan', optional($karyawan)->unit_penempatan) }}">
                </div>

                <div class="form-group">
                    <label>Status Karyawan</label>
                    <select name="status_karyawan" class="form-control">
                        <option value="aktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', optional($karyawan)->keterangan) }}</textarea>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">Simpan & Lanjut</button>
            </div>
        </form>
    </div>
</div>

@endsection
