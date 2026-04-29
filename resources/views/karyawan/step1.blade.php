<title>Step Data Karyawan</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .form-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        padding: 22px 30px;
        color: white;
    }

    .form-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
        letter-spacing: 0.5px;
    }

    .form-body {
        padding: 35px;
    }

    /* FIX 2 KOLOM */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #2c3e50;
        font-size: 14px;
    }

    input, select, textarea {
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid #dfe6ed;
        font-size: 14px;
        transition: 0.2s ease;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    }

    textarea {
        resize: vertical;
        min-height: 90px;
    }

    .form-full {
        grid-column: 1 / -1;
    }

    .form-footer {
        margin-top: 30px;
        text-align: right;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        border: none;
        border-radius: 10px;
        padding: 12px 35px;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: 0.2s ease;
        font-size: 14px;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13,110,253,.35);
    }

    .alert {
        background-color: #ffeaea;
        color: #c0392b;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .text-muted {
        font-size: 12px;
        color: #7f8c8d;
        margin-top: 4px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <div class="form-card">

        <div class="form-header">
            <h5>Step 1 - Data Kerja</h5>
        </div>

        <form action="{{ route('karyawan.storestep1') }}" method="POST">
            @csrf

            <div class="form-body">

                @if($errors->any())
                    <div class="alert">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-grid">

                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" value="{{ $user->nip }}" required>
                    </div>

                    <div class="form-group">
                        <label>Unit PLN</label>
                        <select name="unitpln_id" required>
                            <option value="">Pilih Unit PLN</option>
                            @foreach($unitpln as $unit)
                                <option value="{{ $unit->unitpln_id }}" {{ old('unitpln_id', optional($karyawan)->unitpln_id) == $unit->unitpln_id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan_id" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach($jabatan as $j)
                                <option value="{{ $j->jabatan_id }}" {{ old('jabatan_id', optional($karyawan)->jabatan_id) == $j->jabatan_id ? 'selected' : '' }}>
                                    {{ $j->nama_jabatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sub Unit</label>
                        <select name="sub_id" required>
                            <option value="">Pilih Sub Unit</option>
                            @foreach($subunit as $sub)
                                <option value="{{ $sub->sub_id }}" {{ old('sub_id', optional($karyawan)->sub_id) == $sub->sub_id ? 'selected' : '' }}>
                                    {{ $sub->nama_sub_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>TAD</label>
                        <select name="tad_id" required>
                            <option value="">Pilih TAD</option>
                            @foreach($tad as $t)
                                <option value="{{ $t->tad_id }}" {{ old('tad_id', optional($karyawan)->tad_id) == $t->tad_id ? 'selected' : '' }}>
                                    {{ $t->nama_tad }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Proyek</label>
                        <select name="project_id" required>
                            <option value="">Pilih Proyek</option>
                            @foreach($project as $p)
                                <option value="{{ $p->project_id }}" {{ old('project_id', optional($karyawan)->project_id) == $p->project_id ? 'selected' : '' }}>
                                    {{ $p->nama_project }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pendidikan</label>
                        <select name="pendidikan_id" required>
                            <option value="">Pilih Pendidikan</option>
                            @foreach($pendidikan as $pen)
                                <option value="{{ $pen->pendidikan_id }}" {{ old('pendidikan_id', optional($karyawan)->pendidikan_id) == $pen->pendidikan_id ? 'selected' : '' }}>
                                    {{ $pen->nama_pendidikan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Mulai Aktif</label>
                        <input type="date" name="tanggal_mulai_aktif" value="value="{{ $user->tanggal_mulai_aktif }}"">
                        @if(optional($karyawan)->tanggal_mulai_aktif)
                            <small class="text-muted">
                                Terakhir: {{ \Carbon\Carbon::parse(optional($karyawan)->tanggal_mulai_aktif)->format('d/m/Y') }}
                            </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Unit Penempatan</label>
                        <input type="text" name="unit_penempatan" value="value="{{ $user->unit_penempatan }}"">
                    </div>

                    <div class="form-group">
                        <label>Status Karyawan</label>
                        <select name="status_karyawan">
                            <option value="aktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status_karyawan', optional($karyawan)->status_karyawan) == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                        </select>
                    </div>

                    <div class="form-group form-full">
                        <label>Keterangan</label>
                        <textarea name="keterangan">{{ old('keterangan', optional($karyawan)->keterangan) }}</textarea>
                    </div>

                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-primary-custom">
                        Lanjut →
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>