@extends('template.karyawan.layout')

@section('content')

@php
    $isMyBirthday = $isMyBirthday ?? false;
    $ulangTahunSelainSaya = $ulangTahunSelainSaya ?? collect();
    $namaKaryawan = $namaKaryawan ?? '';
@endphp

<section class="content pt-3">
<div class="container-fluid">


@if($ulangTahunHariIni->count() > 0)
<div class="birthday-card mb-3" style="background: linear-gradient(135deg, #667eea, #764ba2); color:white; position:relative;">
    
    <button class="close text-white" onclick="tutupCard(this)" style="position:absolute; right:15px; top:10px;">&times;</button>

    {{-- 🎂 UCAPAN DIRI SENDIRI --}}
    @if($isMyBirthday)
        <div class="mb-2">
            🎉 <strong>
                Selamat ulang tahun {{ $namaKaryawan }} 🎂
            </strong>
            <div style="font-size: 14px;">
                Semoga sehat selalu dan rezekinya lancar
            </div>
        </div>
    @endif

    {{-- 🎉 LIST SEMUA YANG ULTAH --}}
    @if($ulangTahunHariIni->count() > 0)

        @if($isMyBirthday)
            <hr style="border-color: rgba(255,255,255,0.3);">
        @endif

        <div class="mb-1">
            🎉 <strong>Ulang Tahun Hari Ini:</strong>
        </div>

        <ul class="mb-0 pl-3">
            @foreach($ulangTahunHariIni as $k)
                <li 
                    onclick="ucapin('{{ $k->id }}','{{ addslashes($k->nama_lengkap) }}')" 
                    style="cursor:pointer;">
                    
                    {{ $k->nama_lengkap }}

                    {{-- tandai kalau itu diri sendiri --}}
                    @if($isMyBirthday && $k->id == $karyawan->id)
                        <span style="font-size:12px;">(Kamu)</span>
                    @endif

                </li>
            @endforeach
        </ul>

    @endif

</div>
@endif

    {{-- 🎂 MODAL --}}
    <div id="birthdayModal" class="custom-modal">
        <div class="modal-content border-0 shadow-lg">
            <div class="text-right">
                <button type="button" class="close" onclick="tutupModal()">&times;</button>
            </div>
            <div class="py-2">
                <i class="fas fa-birthday-cake fa-3x text-warning mb-3"></i>
                <h5 class="font-weight-bold">Kirim Ucapan Selamat</h5>
                <p id="namaUcapan" class="text-muted"></p>

                <textarea id="pesanUcapan" class="form-control" rows="3"
                    placeholder="Tulis ucapan hangat kamu di sini..."></textarea>

                <div class="mt-4 d-flex justify-content-between">
                    <button class="btn btn-light px-4" onclick="tutupModal()">Batal</button>
                    <button class="btn btn-primary px-4" onclick="kirimUcapan()">
                        Kirim Sekarang <i class="fas fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ⚠️ NOTIF PENSIUN --}}
    @if(isset($isPensiun) && $isPensiun)
    <div class="birthday-card mb-3" style="background: linear-gradient(135deg, #ce1d1d, #f8d210); color: white;">
        <button class="close text-white" onclick="tutupCard(this)">&times;</button>
        <i class="fas fa-exclamation-triangle mr-2"></i>
        <strong>Pemberitahuan:</strong> Anda sudah memasuki usia pensiun ({{ $umur }} tahun).
    </div>
    @endif

    {{-- 👤 PROFILE --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-4">
                        <img class="img-circle elevation-2"
                             src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                             width="80" height="80">
                    </div>

                    <div>
                        <h4 class="mb-1 font-weight-bold text-dark">
                            {{ $karyawan->nama_lengkap ?? auth()->user()->name }}
                        </h4>
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

    {{-- 📊 STATISTIK --}}
    <div class="row mb-4">

        <div class="col-md-4 col-12 mb-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h3>{{ $totalAbsensi ?? 0 }}</h3>
                        <small>Kehadiran Bulan Ini</small>
                    </div>
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 mb-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h3>{{ $totalLembur ?? 0 }}</h3>
                        <small>Total Jam Lembur</small>
                    </div>
                    <i class="fas fa-business-time"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12 mb-3">
            <div class="card shadow-sm border-left-danger">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h3>{{ $totalIzin ?? 0 }}</h3>
                        <small>Izin & Sakit</small>
                    </div>
                    <i class="fas fa-envelope-open-text"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- 🚀 MENU CEPAT --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-rocket mr-2 text-primary"></i> Menu Akses Cepat
            </h5>
        </div>

        <div class="card-body bg-light">
            <div class="row text-center justify-content-center">

                <div class="col-4 col-md-3">
                    <a href="{{ route('absensi.index') }}">
                        <div class="p-4 rounded-lg shadow-sm bg-indigo text-white">
                            <i class="fas fa-camera fa-2x mb-2"></i>
                            <div class="small font-weight-bold">Absensi</div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-md-3">
                    <a href="{{ route('izin.create') }}">
                        <div class="p-4 rounded-lg shadow-sm bg-info text-white">
                            <i class="fas fa-file-signature fa-2x mb-2"></i>
                            <div class="small font-weight-bold">Izin</div>
                        </div>
                    </a>
                </div>

                <div class="col-4 col-md-3">
                    <a href="{{ route('lembur.create') }}">
                        <div class="p-4 rounded-lg shadow-sm bg-teal text-white">
                            <i class="fas fa-moon fa-2x mb-2"></i>
                            <div class="small font-weight-bold">Lembur</div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- ✅ ALERT SUCCESS (HANYA 1) --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    @endif

</div>
</section>


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

// buka modal
function ucapin(id, nama) {
    idKaryawan = id;
    namaTerpilih = nama;

    document.getElementById("namaUcapan").innerText = 
        "Kirim pesan spesial untuk " + nama;

    document.getElementById("birthdayModal").style.display = "flex"; // biar center
}

// tutup modal
function tutupModal() {
    document.getElementById("birthdayModal").style.display = "none";
}

// kirim ucapan
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
    .then(res => {
        if (!res.ok) throw new Error("Gagal kirim");
        return res.json();
    })
    .then(data => {
        alert("Ucapan berhasil dikirim!");
        document.getElementById("pesanUcapan").value = "";
        tutupModal();
    })
    .catch(err => {
        console.error(err);
        alert("Terjadi kesalahan saat mengirim ucapan.");
    });
}

// tutup card notif
function tutupCard(btn) {
    btn.closest('.birthday-card').style.display = "none";
}
</script>

@endsection