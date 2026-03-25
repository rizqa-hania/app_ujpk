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
                        <label for="id" class="form-label">Nama Karyawan</label>
                        <select name="karyawan_id" class="form-control" id="karyawan_id">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawan as $k)
                            <option value="{{ $k->id }}"  data-nip="{{$k->nip}}">{{ $k->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nip">NIP (otomatis)</label>
                        <input type="number" name="nip" id="nip" class="form-control" value="{{ auth()->user()->nip }}"  readonly required> 
                    </div>

                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Komponen</label>
                        <select name="kode" id="tipe_id" class="form-control">
                            <option value="">-- Pilih Komponen --</option>
                            @foreach($komponen as $k)
                            <option value="{{ $k->kode }}" data-tipe="{{ $k->tipe }}" data-nilai="{{ $k->nilai }}">{{ $k->kode }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipe">Tipe (otomatis)</label>
                        <input type="text" name="tipe" id="tipe" class="form-control" readonly required> 
                    </div>
                    <div class="mb-3">
                        <label for="nilai">Nilai (otomatis)</label>
                        <input type="number" name="nilai" id="value" class="form-control" readonly required> 
                    </div>
                    <div>
                        <a href="{{route('detail.index', $penggajian->penggajian_id )}}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ini yang asli, yang punya mu ris hehe
<script>
    document.getElementById('tipe').addEventListener('change', function () {
        let karyawanId = this.value;
        const nipInput = document.getElementById('tipe');

        if (karyawanId) {
            fetch('/get-user-nip/' + karyawanId)
                .then(response => response.json())
                .then(data => {
                    nipInput.value = data.nip || '';
                })
                .catch(error => {
                    console.error('Error fetching nip:', error);
                    nipInput.value = '';
                });
        } else {
            nipInput.value = '';
        }
    });
</script>
-->
<script>
document.getElementById('karyawan_id').addEventListener('change', function() {

    let selectedOption = this.options[this.selectedIndex];

    let nip = selectedOption.getAttribute('data-nip');
    
    document.getElementById('nip').value = nip ?? '';
});
</script>
<script>
document.getElementById('tipe_id').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];

    if (this.value === "") {
        document.getElementById('tipe').value = '';
        document.getElementById('value').value = '';
    } else {
        let tipe = selectedOption.getAttribute('data-tipe');
        let nilai = selectedOption.getAttribute('data-nilai');

        document.getElementById('tipe').value = tipe ?? '';
        document.getElementById('value').value = nilai ?? '';
    }
});
</script>
@endsection