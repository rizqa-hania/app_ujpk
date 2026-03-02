<style>
    .form-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        padding: 20px 30px;
        color: white;
    }

    .form-header h5 {
        margin: 0;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.1rem;
    }

    .form-body {
        padding: 35px;
        background-color: #ffffff;
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e6ed;
        transition: 0.2s;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #34495e;
        font-size: 0.9rem;
    }

    .mb-4 {
        margin-bottom: 25px !important;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        border: none;
        border-radius: 10px;
        padding: 12px 35px;
        font-weight: 600;
        transition: 0.2s;
        color: white;
        font-size: 0.95rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13,110,253,.35);
        background: linear-gradient(135deg, #0b5ed7, #0956c9);
    }
</style>

<div class="container py-4">
    <div class="card form-card">

        <div class="form-header">
            <h5>Step 1 - Data Kerja</h5>
        </div>

        <form action="{{ route('karyawan.storestep1') }}" method="POST">
            @csrf

            <div class="form-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ $user->nip }}" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Unit PLN</label>
                        <select name="unitpln_id" class="form-control" required>
                            <option value=""> Pilih Unit PLN </option>
                            @foreach($unitpln as $unit)
                                <option value="{{ $unit->unitpln_id }}" {{ old('unitpln_id', optional($karyawan)->unitpln_id) == $unit->unitpln_id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Jabatan</label>
                        <select name="jabatan_id" class="form-control" required>
                            <option value=""> Pilih Jabatan </option>
                            @foreach($jabatan as $j)
                                <option value="{{ $j->jabatan_id }}" {{ old('jabatan_id', optional($karyawan)->jabatan_id) == $j->jabatan_id ? 'selected' : '' }}>
                                    {{ $j->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Sub Unit</label>
                        <select name="sub_id" class="form-control" required>
                            <option value=""> Pilih Sub Unit </option>
                            @foreach($subunit as $sub)
                                <option value="{{ $sub->sub_id }}" {{ old('sub_id', optional($karyawan)->sub_id) == $sub->sub_id ? 'selected' : '' }}>
                                    {{ $sub->nama_sub_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>TAD</label>
                        <select name="tad_id" class="form-control" required>
                            <option value=""> Pilih TAD </option>
                            @foreach($tad as $t)
                                <option value="{{ $t->tad_id }}" {{ old('tad_id', optional($karyawan)->tad_id) == $t->tad_id ? 'selected' : '' }}>
                                    {{ $t->nama_tad }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Project</label>
                        <select name="project_id" class="form-control" required>
                            <option value=""> Pilih Project </option>
                            @foreach($project as $p)
                                <option value="{{ $p->project_id }}" {{ old('project_id', optional($karyawan)->project_id) == $p->project_id ? 'selected' : '' }}>
                                    {{ $p->nama_project }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Pendidikan</label>
                        <select name="pendidikan_id" class="form-control" required>
                            <option value=""> Pilih Pendidikan </option>
                            @foreach($pendidikan as $pen)
                                <option value="{{ $pen->pendidikan_id }}" {{ old('pendidikan_id', optional($karyawan)->pendidikan_id) == $pen->pendidikan_id ? 'selected' : '' }}>
                                    {{ $pen->nama_pendidikan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Tanggal Mulai Aktif</label>
                        <input type="date" name="tanggal_mulai_aktif" class="form-control" value="{{ old('tanggal_mulai_aktif', optional($karyawan)->tanggal_mulai_aktif) }}">
                        @if(optional($karyawan)->tanggal_mulai_aktif)
                            <small class="text-muted">Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_mulai_aktif)->format('d/m/Y') }}</small>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Unit Penempatan</label>
                        <input type="text" name="unit_penempatan" class="form-control" value="{{ old('unit_penempatan', optional($karyawan)->unit_penempatan) }}">
                    </div>

                    <div class="col-md-6 mb-4">
                        <label>Status Karyawan</label>
                        <select name="status_karyawan" class="form-control">
                            <option value="aktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', optional($karyawan)->keterangan) }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary-custom">
                        Lanjut →
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>
