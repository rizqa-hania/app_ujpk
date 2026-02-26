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
                        <select name="nama" class="form-control" id="karyawan">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawan as $k)
                            <option value="{{ $k->id }}" {{ old('id') == $k->id ? 'selected' : '' }}">{{ $k->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nip">NIP (otomatis)</label>
                        <input type="number" name="nip" id="nip" class="form-control" readonly required> 
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
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('karyawan').addEventListener('change', function () {
        let karyawanId = this.value;
        const nipInput = document.getElementById('nip');

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
@endsection