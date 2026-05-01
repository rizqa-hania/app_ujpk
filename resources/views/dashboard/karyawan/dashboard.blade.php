@extends('template.karyawan.layout')

@section('content')

<section class="content pt-3">
    <div class="container-fluid">

        {{-- 1. NOTIFIKASI KHUSUS (PENSIUN & ULANG TAHUN) --}}
        @if(isset($isPensiun) && $isPensiun)
        <div class="birthday-card mb-3" style="background: linear-gradient(135deg, #ce1d1d, #f8d210); color: white;">
            <button class="close text-white" onclick="tutupCard(this)">&times;</button>
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Pemberitahuan:</strong> Anda sudah memasuki usia pensiun ({{ $umur }} tahun).
        </div>
        @endif

        @if(isset($ulangTahunHariIni) && count($ulangTahunHariIni) > 0)
        <div class="birthday-card mb-3">
            <button class="close text-white" onclick="tutupCard(this)">&times;</button>
            <strong>🎉 Ulang Tahun Hari Ini</strong>
            <ul class="mb-0 mt-2">
                @foreach($ulangTahunHariIni as $k)
                    <li onclick="ucapin('{{ $k->id }}','{{ addslashes($k->nama_lengkap) }}')" style="cursor:pointer;">
                        {{ $k->nama_lengkap }} ({{ \Carbon\Carbon::parse($k->tanggal_lahir)->age }} tahun)
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- 2. PROFILE CARD --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="profile-img-container mr-4">
                            <img class="img-circle elevation-2" 
                                 src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" 
                                 alt="User Image" width="80" height="80">
                        </div>
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">
                                {{ $karyawan->nama_lengkap ?? auth()->user()->name }}
                            </h4>
                            <p class="mb-1 text-primary font-weight-600">
                                <i class="fas fa-briefcase mr-1"></i> {{ $karyawan->jabatan->nama_jabatan ?? 'Jabatan Belum Diatur' }}
                            </p>
                            <span class="badge badge-secondary px-3 py-2">
                                NIP: {{ $karyawan->nip ?? '-' }}
                            </span>
                        </div>
                        <div class="ml-auto d-none d-md-block">
                            <a href="{{ route('karyawan.profile') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="fas fa-user-edit mr-1"></i> Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. STATISTIK UTAMA --}}
        <div class="row mb-4">
            {{-- Absensi --}}
            <div class="col-md-4 col-12 mb-3">
                <div class="card shadow-sm h-100 border-left-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold mb-0 text-dark">{{ $totalAbsensi ?? 0 }}</h3>
                            <small class="text-muted font-weight-bold text-uppercase">Kehadiran Bulan Ini</small>
                        </div>
                        <div class="bg-primary p-3 rounded-circle shadow-sm">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                    <a href="{{ route('absensi.create') }}" class="card-footer text-xs text-primary bg-white border-0">
                        Lihat Riwayat <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                </div>
            </div>

            {{-- Lembur --}}
            <div class="col-md-4 col-12 mb-3">
                <div class="card shadow-sm h-100 border-left-warning">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold mb-0 text-dark">{{ $totalLembur ?? 0 }}</h3>
                            <small class="text-muted font-weight-bold text-uppercase">Total Jam Lembur</small>
                        </div>
                        <div class="bg-warning p-3 rounded-circle shadow-sm">
                            <i class="fas fa-business-time text-white"></i>
                        </div>
                    </div>
                    <a href="{{ route('lembur.index') }}" class="card-footer text-xs text-warning bg-white border-0">
                        Detail Lembur <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                </div>
            </div>

            {{-- Izin --}}
            <div class="col-md-4 col-12 mb-3">
                <div class="card shadow-sm h-100 border-left-danger">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="font-weight-bold mb-0 text-dark">{{ $totalIzin ?? 0 }}</h3>
                            <small class="text-muted font-weight-bold text-uppercase">Izin & Sakit</small>
                        </div>
                        <div class="bg-danger p-3 rounded-circle shadow-sm">
                            <i class="fas fa-envelope-open-text text-white"></i>
                        </div>
                    </div>
                    <a href="{{ route('izin.index') }}" class="card-footer text-xs text-danger bg-white border-0">
                        Status Izin <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- 4. MENU CEPAT (AKSES NAVIGASI) --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fas fa-rocket mr-2 text-primary"></i> Menu Akses Cepat
                </h5>
            </div>
            <div class="card-body bg-light">
                <div class="row text-center justify-content-center">
                    <div class="col-4 col-md-3">
                        <a href="{{ route('absensi.index') }}" class="text-decoration-none">
                            <div class="p-4 rounded-lg shadow-sm hover-push bg-indigo">
                                <i class="fas fa-camera fa-2x mb-2 text-white"></i>
                                <div class="font-weight-bold text-white small">Absensi / Scan</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('izin.create') }}" class="text-decoration-none">
                            <div class="p-4 rounded-lg shadow-sm hover-push bg-info">
                                <i class="fas fa-file-signature fa-2x mb-2 text-white"></i>
                                <div class="font-weight-bold text-white small">Ajukan Izin</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-4 col-md-3">
                        <a href="{{ route('lembur.create') }}" class="text-decoration-none">
                            <div class="p-4 rounded-lg shadow-sm hover-push bg-teal">
                                <i class="fas fa-moon fa-2x mb-2 text-white"></i>
                                <div class="font-weight-bold text-white small">Input Lembur</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

    </div>

  </div>
</div>
<!-- PROFILE CARD -->
<div class="row mb-4">
<div class="col-md-12">
<div class="card shadow-sm">
<div class="card-body d-flex align-items-center">

<img class="img-circle elevation-2 mr-4"
src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
width="80" height="80">

<div>
<h4 class="mb-1 font-weight-bold">
{{ $karyawan->nama_lengkap ?? auth()->user()->name }}
</h4>


<small class="text-muted">
NIP: {{ $karyawan->nip ?? '-' }}
</small>
</div>

<div class="ml-auto">
<a href="{{ route('karyawan.profile') }}" class="btn btn-primary btn-sm">
<i class="fas fa-user-edit mr-1"></i> Edit
</a>
</div>

</div>
</div>
</div>
</div>


<!-- STATISTIK -->
<div class="row mb-4 col-6">

<div class="col-md-4 col-6">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h3 class="font-weight-bold mb-0">
{{  $totalAbsensi ?? 0 }}
</h3>
<small class="text-muted">Total Absensi</small>
</div>

<div class="bg-light p-3 rounded">
<i class="fas fa-clock text-primary"></i>
</div>

</div>
</div>
</div>


<div class="col-md-4 col-6">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h3 class="font-weight-bold mb-0">
{{ $totalLembur ?? 0 }}
</h3>
<small class="text-muted">Total Lembur</small>
</div>

<div class="bg-light p-3 rounded">
<i class="fas fa-business-time text-warning"></i>
</div>

</div>
</div>
</div>

<div class="col-md-4 col-6">
<div class="card shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h3 class="font-weight-bold mb-0">
{{ $totalIzin ?? 0 }}
</h3>
<small class="text-muted">Total Izin</small>
</div>

<div class="bg-light p-3 rounded">
<i class="fas fa-envelope text-danger"></i>
</div>

</div>
</div>
</div>

</div>


<!-- MENU CEPAT -->
<div class="card shadow-sm">

<div class="card-header">
<h5 class="mb-0 font-weight-bold">
<i class="fas fa-th-large mr-1"></i> Menu Cepat
</h5>
</div>

<div class="card-body">
<div class="row text-center justify-content-center">


<div class="col-4 col-md-2 mb-4">
<a href="{{ route('absensi.index') }}" class="text-dark">

<div class="p-3 rounded elevation-1"
style="background:#2f4bb2;color:white;">

<i class="fas fa-clock fa-2x mb-2"></i>

<div>Absensi</div>

</div>

</a>
</div>


<div class="col-4 col-md-2 mb-4">
<a href="{{ route('izin.create') }}" class="text-dark">

<div class="p-3 rounded elevation-1"
style="background:#2f4bb2;color:white;">

<i class="fas fa-envelope fa-2x mb-2"></i>

<div>Izin</div>

</div>

</a>
</div>


<div class="col-4 col-md-2 mb-4">
<a href="{{ route('lembur.create') }}" class="text-dark">

<div class="p-3 rounded elevation-1"
style="background:#2f4bb2;color:white;">

<i class="fas fa-business-time fa-2x mb-2"></i>

<div>Lembur</div>

</div>

</a>
</div>


</div>
</div>
</div>


<!-- ALERT -->
@if(session('success'))
<div class="alert alert-success alert-dismissible mt-3">
<button type="button" class="close" data-dismiss="alert">&times;</button>
{{ session('success') }}
</div>
@endif

</div>

</section>

{{-- MODAL ULANG TAHUN --}}
<div id="birthdayModal" class="custom-modal">
    <div class="modal-content border-0 shadow-lg">
        <div class="text-right">
            <button type="button" class="close" onclick="tutupModal()">&times;</button>
        </div>
        <div class="py-2">
            <i class="fas fa-birthday-cake fa-3x text-warning mb-3"></i>
            <h5 class="font-weight-bold">Kirim Ucapan Selamat</h5>
            <p id="namaUcapan" class="text-muted"></p>
            <textarea id="pesanUcapan" class="form-control" rows="3" placeholder="Tulis ucapan hangat kamu di sini..."></textarea>
            <div class="mt-4 d-flex justify-content-between">
                <button class="btn btn-light px-4" onclick="tutupModal()">Batal</button>
                <button class="btn btn-primary px-4" onclick="kirimUcapan()">Kirim Sekarang <i class="fas fa-paper-plane ml-1"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Color & Effects */
    .bg-indigo { background-color: #4e73df; }
    .bg-teal { background-color: #20c997; }
    .bg-info { background-color: #36b9cc; }
    
    .border-left-primary { border-left: 4.5px solid #4e73df !important; }
    .border-left-warning { border-left: 4.5px solid #f6c23e !important; }
    .border-left-danger { border-left: 4.5px solid #e74a3b !important; }

    .hover-push {
        transition: all 0.25s ease-in-out;
    }
    .hover-push:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.15) !important;
        filter: brightness(1.1);
    }

    .text-xs { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; }

    .birthday-card {
        position: relative;
        padding: 1.5rem;
        border-radius: 1rem;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1060;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: #fff;
        padding: 2rem;
        border-radius: 1rem;
        width: 90%;
        max-width: 400px;
        margin: 10% auto;
        text-align: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    let idKaryawan = "";
    let namaTerpilih = "";

    function ucapin(id, nama) {
        idKaryawan = id;
        namaTerpilih = nama;
        document.getElementById("namaUcapan").innerText = "Kirim pesan spesial untuk " + nama;
        document.getElementById("birthdayModal").style.display = "block";
    }

    function tutupModal() {
        document.getElementById("birthdayModal").style.display = "none";
    }

    function kirimUcapan() {
        let pesan = document.getElementById("pesanUcapan").value;
        if (pesan.trim() === "") {
            alert("Silakan tulis ucapan terlebih dahulu.");
            return;
        }

        fetch('/kirimucapan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                karyawan_id: idKaryawan,
                pesan: pesan
            })
        })
        .then(res => res.json())
        .then(data => {
            alert("Ucapan berhasil dikirim!");
            document.getElementById("pesanUcapan").value = "";
            tutupModal();
        });
    }

    function tutupCard(btn) {
        btn.parentElement.style.display = "none";
    }
</script>

@endsection