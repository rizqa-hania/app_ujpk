@extends('template.admin.layout')

@section('content')

{{-- Notifikasi Ulang Tahun --}}
<div class="birthday-card">
<button type="button" class="close text-white" data-dismiss="alert">&times;</button>

<strong>🎉 Ulang Tahun Hari Ini</strong>

<ul class="mb-0 mt-2">
@foreach($ulangTahunHariIni as $k)
<li onclick="ucapin('{{ $k->nama_lengkap }}')" style="cursor:pointer;">
{{ $k->nama_lengkap }}
({{ \Carbon\Carbon::parse($k->tanggal_lahir)->age }} tahun)
</li>
@endforeach
</ul>
</div>

<div id="birthdayModal" class="custom-modal">
  <div class="modal-content">
    <h5>🎉 Ulang Tahun!</h5>

    <p id="namaUcapan"></p>

    <!-- INPUT UCAPAN -->
    <textarea id="pesanUcapan" placeholder="Tulis ucapan kamu di sini..."
      style="width:100%; height:80px; border-radius:8px; padding:10px; border:1px solid #ccc;"></textarea>

    <!-- BUTTON -->
    <div style="margin-top:15px;">
      <button onclick="kirimUcapan()">Kirim</button>
      <button onclick="tutupModal()" style="background:#ccc; color:#000;">Tutup</button>
    </div>
  </div>
</div>

<section class="content pt-3">
    <div class="container-fluid">
        
        {{-- PANEL REKAP LAPORAN (TAMBAHAN BARU) --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            <i class="fas fa-file-export mr-2 text-primary"></i> Pusat Unduh Laporan Absensi
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Silakan pilih periode laporan yang ingin diunduh dalam format PDF:</p>
                        <div class="d-flex flex-wrap" style="gap: 15px;">
                            <a href="{{ route('absensi.rekap', ['type' => 'harian', 'tanggal' => now()->toDateString()]) }}" 
                               class="btn btn-primary elevation-2">
                                <i class="fas fa-calendar-day mr-1"></i> Rekap Hari Ini
                            </a>

                            <a href="{{ route('absensi.rekap', ['type' => 'mingguan', 'tanggal' => now()->toDateString()]) }}" 
                               class="btn btn-info elevation-2">
                                <i class="fas fa-calendar-week mr-1"></i> Rekap Minggu Ini
                            </a>

                            <a href="{{ route('absensi.rekap', ['type' => 'bulanan', 'bulan' => now()->format('Y-m')]) }}" 
                               class="btn btn-warning text-white elevation-2">
                                <i class="fas fa-calendar-alt mr-1"></i> Rekap Bulan Ini
                            </a>

                            <a href="{{ route('absensi.rekap', ['type' => 'tahunan', 'tahun' => now()->year]) }}" 
                               class="btn btn-dark elevation-2">
                                <i class="fas fa-archive mr-1"></i> Rekap Tahun Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS STATISTIK UTAMA --}}
        <div class="row">
            {{-- Karyawan --}}
            <div class="col-lg-3 col-6 mb-4">
                <div class="small-box bg-gradient-karyawan">
                    <div class="inner">
                        <h3>{{ $totalKaryawan }}</h3>
                        <p>Total Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users icon-white"></i>
                    </div>
                    <a href="{{ route('admin.karyawan.index')}}" class="small-box-footer">
                        Lihat Data <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Absensi --}}
            <div class="col-lg-3 col-6 mb-4">
                <div class="small-box bg-gradient-absensi">
                    <div class="inner">
                        <h3>{{ $totalAbsensi ?? 0 }}</h3>
                        <p>Total Absensi (Hari Ini)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock icon-white"></i>
                    </div>
                    <a href="{{ route('absensi.index') }}" class="small-box-footer">
                        Detail Absensi <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Izin --}}
            <div class="col-lg-3 col-6 mb-4">
              <div class="small-box bg-gradient-izin">
                    <div class="inner">
                        <h3 class="text-white">{{ $totalIzin }}</h3>
                        <p class="text-white">Total Izin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-envelope-open-text text-white"></i>
                    </div>
                    <a href="{{ route('izin.index') }}" class="small-box-footer text-white">
                        Lihat Detail <i class="fas fa-arrow-circle-right text-white"></i>
                    </a>
                </div>
            </div>

            {{-- Lembur --}}
            <div class="col-lg-3 col-6 mb-4">
                <div class="small-box bg-gradient-lembur">
                    <div class="inner">
                        <h3>{{ $totalLembur }}</h3>
                        <p>Total Lembur</p>
                    </div>
                    <div class="icon">
                        <i class=" fas fa-business-time  icon-white"></i>
                    </div>
                    <a href="{{ route('lembur.index') }}" class="small-box-footer text-white">
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- MASTER DATA ROW --}}
        <h5 class="mb-3 text-muted"><i class="fas fa-database mr-2"></i> Master Data Manajemen</h5>
        <div class="row">
            {{-- TAD --}}
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <div class="small-box bg-gradient-tad">
                    <div class="inner">
                        <div class="icon">
                            <i class="fas fa-users-cog text-white"></i>
                    </div>
                        <h3>{{ $totalTad }}</h3>
                        <p>TAD</p>
                    </div>
                    <a href="{{ route('master_tad.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow"></i></a>
                </div>
            </div>

<<<<<<< HEAD
               <div class="col-lg-3 col-6">
                <div class="small-box bg-indigo elevation-3 dashboard-box">
                <div class="small-box bg-indigo dashboard-box">
=======
            {{-- Unit PLN --}}
            <div class="col-lg-2 col-md-4 col-6 mb-4">
              <div class="small-box bg-gradient-unit">
>>>>>>> 1d77f844fed00ef16c6702469cdf2c1ba33f6e34
                    <div class="inner">
                        <div class="icon">
                        <i class="fas fa-building text-white"></i>
                    </div>
                        <h3>{{ $totalUnitPln }}</h3>
                        <p>Unit PLN</p>
                    </div>
                    <a href="{{ route('master_unit_pln.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow"></i></a>
                </div>
            </div>

            {{-- Project --}}
            <div class="col-lg-2 col-md-4 col-6 mb-4">
               <div class="small-box bg-gradient-project">
                    <div class="inner">
                        <div class="icon">
                        <i class="fas fa-project-diagram text-white"></i>
                    </div>
                        <h3>{{ $totalProject }}</h3>
                        <p>Project</p>
                    </div>
                    <a href="{{ route('master_project.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow"></i></a>
                </div>
            </div>

             {{-- Jabatan --}}
             <div class="col-lg-2 col-md-4 col-6 mb-4">
                <div class="small-box bg-gradient-jabatan">
                    <div class="inner text-white">
                          <div class="icon">
                        <i class="fas fa-user-tie text-white"></i>
                    </div>
                        <h3>{{ $totalJabatan }}</h3>
                        <p>Jabatan</p>
                    </div>
                    <a href="{{ route('master_jabatan.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow"></i></a>
                </div>
            </div>

            {{-- Sub Unit --}}
            <div class="col-lg-2 col-md-4 col-6 mb-4">
              <div class="small-box bg-gradient-subunit">
                    <div class="inner text-white">
                         <div class="icon">
                        <i class="fas fa-sitemap text-white"></i>
                    </div>
                        <h3>{{ $totalSubUnit }}</h3>
                        <p>Sub Unit</p>
                    </div>
                    <a href="{{ route('master-sub-unit.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow"></i></a>
                </div>
            </div>

            {{-- Pendidikan --}}
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <div class="small-box bg-gradient-pendidikan">
                    <div class="inner">
                        <div class="icon">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                        <h3>{{ $totalPendidikan }}</h3>
                        <p>Pendidikan</p>
                    </div>
                    <a href="{{ route('master_pendidikan.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.icon-white {
    color: white;
}

/* Karyawan – Biru Cerah */
.bg-gradient-karyawan {
    background: linear-gradient(45deg, #36d1dc, #5b86e5);
    color: white;
}

/* Absensi – Biru Gelap */
.bg-gradient-absensi {
    background: linear-gradient(45deg, #4a828d, #6c8e9d);
    color: white;
}

/* Izin – Biru Soft */
.bg-gradient-izin {
    background: linear-gradient(45deg, #56ccf2, #2f80ed);
    color: white;
}

/* Lembur – Biru Medium */
.bg-gradient-lembur {
    background: linear-gradient(45deg, #237ab4, #2a5298);
    color: white;
}

/* Unit PLN – Biru Sky */
.bg-gradient-unit {
    background: linear-gradient(45deg, #4facfe, #00c6ff);
    color: white;
}

/* Sub Unit – Biru Tosca */
.bg-gradient-subunit {
    background: linear-gradient(45deg, #2193b0, #6dd5ed);
    color: white;
}

/* Jabatan – Biru Ungu */
.bg-gradient-jabatan {
    background: linear-gradient(45deg, #4776e6, #7cb7bd);
    color: white;
}

/* Project – Biru Navy */
.bg-gradient-project {
    background: linear-gradient(45deg, #6bc9bd, #2a5298);
    color: white;
}

/* Pendidikan – Biru Soft */
.bg-gradient-pendidikan {
    background: linear-gradient(45deg, #56ccf2, #2f80ed);
    color: white;
}

/* TAD – Biru Hijau */
.bg-gradient-tad {
    background: linear-gradient(45deg, #79a4aa, #58a1eb);
    color: white;
}

.dashboard-box {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
}

.dashboard-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.2) !important;
}

.small-box h3 {
    font-weight: 700;
    font-size: 1.8rem;
}

.small-box p {
    font-size: 0.9rem;
}

/* Biar teks tombol footer selalu putih */
.small-box-footer {
    background-color: rgba(0,0,0,0.1) !important;
    color: #ffffff !important;
    font-size: 0.85rem;
}

.small-box-footer:hover {
    background-color: rgba(0,0,0,0.2) !important;
}



</style>
<style>

  .alert.alert-warning li {
  cursor: pointer;
  transition: 0.2s;
}

.alert.alert-warning li:hover {
  transform: translateX(5px);
  opacity: 0.9;
}

 .birthday-card {
  position: relative;
  padding: 20px 25px;
  border-radius: 15px;

  /* warna elegan */
  background: linear-gradient(135deg, #4facfe, #00f2fe);
  color: #fff;

  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  overflow: hidden;
}

/* efek glow halus */
.birthday-card::before {
  content: "";
  position: absolute;
  width: 200%;
  height: 200%;
  top: -50%;
  left: -50%;
  background: radial-gradient(circle, rgba(255,255,255,0.2), transparent 60%);
  transform: rotate(25deg);
}

/* judul */
.birthday-card strong {
  font-size: 16px;
  font-weight: 600;
}

/* list */
.birthday-card ul {
  margin-top: 10px;
  padding-left: 18px;
}

.birthday-card li {
  margin-bottom: 5px;
  font-size: 14px;
}

/* umur */
.birthday-card .age {
  opacity: 0.85;
  font-size: 13px;
}

/* tombol close */
.birthday-card .close {
  position: absolute;
  top: 10px;
  right: 15px;
  opacity: 0.8;
}
.custom-modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
}

.modal-content {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  width: 320px;
  margin: 15% auto;
  text-align: center;
  animation: fadeIn 0.3s ease;
}

.modal-content h5 {
  margin-bottom: 10px;
}

.modal-content button {
  margin-top: 15px;
  padding: 8px 15px;
  border: none;
  background: #4facfe;
  color: #fff;
  border-radius: 6px;
  cursor: pointer;
}

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(-20px);}
  to {opacity: 1; transform: translateY(0);}
}
  </style>
  <script>
let namaTerpilih = "";

function ucapin(nama) {
    namaTerpilih = nama;

    document.getElementById("namaUcapan").innerText =
        "Berikan ucapan untuk " + nama;

    document.getElementById("birthdayModal").style.display = "block";
}

function tutupModal() {
    document.getElementById("birthdayModal").style.display = "none";
}

function kirimUcapan() {
    let pesan = document.getElementById("pesanUcapan").value;

    if (pesan.trim() === "") {
        alert("Isi ucapan dulu ya!");
        return;
    }

    alert("Ucapan untuk " + namaTerpilih + ":\n\n" + pesan);

    // reset
    document.getElementById("pesanUcapan").value = "";
    tutupModal();
}
</script>
@endsection