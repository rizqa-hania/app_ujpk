


      


<h2>Step 1</h2>

<form action="{{ route('karyawan.store.step1') }}" method="POST">
    @csrf
    <input type="text" name="nip" placeholder="NIP"><br>
     <div class="form-group mb-3">
            <label>Unit PLN</label>
            <select name="unitpln_id" class="form-control" required>
                <option value="">-- Pilih Unit PLN --</option>
                @foreach(\App\MasterUnitPln::all() as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Jabatan</label>
            <select name="jabatan_id" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach(\App\Jabatan::all() as $jabatan)
                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Sub Unit</label>
            <select name="sub_id" class="form-control">
                <option value="">-- Pilih Sub Unit --</option>
                @foreach(\App\MasterSubUnit::all() as $subUnits)
                    <option value="{{ $subUnits->id }}">{{ $subUnits->nama_sub_unit }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>TAD</label>
            <select name="tad_id" class="form-control">
                <option value="">-- Pilih TAD --</option>
                @foreach(\App\MasterTad::all() as $tad)
                    <option value="{{ $tad->id }}">{{ $tad->nama_tad }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Project</label>
            <select name="project_id" class="form-control">
                <option value="">-- Pilih Project --</option>
                @foreach(\App\MasterProject::all() as $project)
                    <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Tanggal Mulai Aktif</label>
            <input type="date" name="tanggal_mulai_aktif" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Unit Penempatan</label>
            <input type="text" name="unit_penempatan" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>Status Karyawan</label>
            <select name="status_karyawan" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Non Aktif</option>
            </select>
        </div>

        <div class="form-group mb-4">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>


    <button type="submit">Next</button>
</form>
