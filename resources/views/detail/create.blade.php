@extends('template.admin.layout')
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
                        <select name="tipe" class="form-control">
                            <option value="">-- Pilih Komponen --</option>
                            @foreach($komponen as $k)
                            <option value="{{ $k->kode }}">{{ $k->kode }}</option>
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
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{route('detail.index', $penggajian->penggajian_id )}}" class="btn btn-success btn-sm">Kembali</a>
                </div>
                
            </form>
            </div>
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
@endsection