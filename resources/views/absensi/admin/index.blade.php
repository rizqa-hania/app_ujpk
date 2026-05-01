@extends('template.admin.layout')

@section('content')
<div class="container-fluid pt-4">
    
    {{-- =========================================================================
         HEADER FORMAL (KOP SURAT) 
         Hanya akan muncul ketika dokumen dicetak ke PDF atau Printer
         ========================================================================= --}}
    <div class="print-header">
        <table width="100%" style="border: none;">
            <tr>
                <td width="15%" align="center" style="border: none; vertical-align: middle;">
                    {{-- Ganti asset di bawah ini dengan path logo image_1cc3b8.png yang benar --}}
                    <img src="{{ asset('images/logo.png') }}" width="100" alt="Logo Perusahaan">
                </td>
                <td width="85%" class="text-center" style="border: none; vertical-align: middle;">
                    <h2 class="company-name" style="margin: 0; padding: 0; text-transform: uppercase;">PT Usaha Jaya Prima Karya</h2>
                    <p class="company-address" style="margin: 5px 0 0 0; padding: 0;">
                        Graha YPK PLN, Jalan Lebak Bulus Tengah Nomor 5, Cilandak Barat, </br> 
                        Jakarta Selatan, DKI Jakarta 12430
                    </p>
                </td>
            </tr>
        </table>
        <hr class="header-line">
        
        <div class="report-title-container" style="margin-top: 20px; text-align: center;">
            <h4 style="text-transform: uppercase; font-weight: bold; margin-bottom: 5px;">Laporan Rekapitulasi Absensi Karyawan</h4>
            <p style="font-size: 14px;">
                Periode: {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') : '...' }} 
                sampai dengan 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') : '...' }}
            </p>
        </div>
    </div>

    {{-- =========================================================================
         HEADER TAMPILAN LAYAR (UI)
         Bagian ini akan disembunyikan saat mencetak (no-print)
         ========================================================================= --}}
    <div class="row mb-3 align-items-center no-print">
        <div class="col-sm-6">
            <h3 class="font-weight-bold text-dark">
                <i class="fas fa-clipboard-check mr-2 text-primary"></i> Rekap Absensi
            </h3>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-success shadow-sm" onclick="window.print()">
                <i class="fas fa-print mr-1"></i> Cetak Laporan Absensi
            </button>
        </div>
    </div>

    {{-- =========================================================================
         CARD FILTER DATA
         Bagian ini akan disembunyikan saat mencetak (no-print)
         ========================================================================= --}}
    <div class="card shadow-sm mb-4 border-0 no-print">
        <div class="card-body">
            <form action="{{ route('absensi.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="small font-weight-bold">Mulai Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="small font-weight-bold">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="small font-weight-bold">Cari Nama Karyawan</label>
                            <input type="text" name="search" class="form-control" placeholder="Masukkan nama..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search mr-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- =========================================================================
         TABEL DATA ABSENSI
         ========================================================================= --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 print-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="tablePresensi">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Nama Karyawan</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataAbsensi as $index => $item)
                                <tr>
                                    <td class="text-center align-middle">
                                        {{ $index + $dataAbsensi->firstItem() }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/absensi/'.$item->foto_masuk) }}" 
                                                 class="rounded-circle border mr-3 no-print" 
                                                 style="width: 38px; height: 38px; object-fit: cover;"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($item->user->name ?? 'N') }}&background=random'">
                                            <div>
                                                <div class="font-weight-bold text-dark">{{ $item->user->name ?? 'Tidak Ada Nama' }}</div>
                                                <small class="text-muted">{{ $item->user->nip ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-success font-weight-bold">{{ $item->jam_masuk ?? '--:--' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-primary font-weight-bold">{{ $item->jam_pulang ?? '--:--' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
    @php
        $st = strtolower($item->status_final);
        // Mapping warna: Lengkap (Hijau), Sisanya (Merah/Info)
        $color = '#6c757d'; // Default Abu-abu
        if($st == 'lengkap') $color = '#28a745';
        elseif($st == 'terlambat' || $st == 'alpha') $color = '#dc3545';
        elseif($st == 'izin') $color = '#17a2b8';
        elseif($st == 'belum lengkap') $color = '#f5e50d';
    @endphp
    
    <span style="color: {{ $color }} !important; font-weight: bold; text-transform: uppercase; font-size: 12px;">
        {{ $item->status_final }}
    </span>
</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Tidak ada data absensi ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- PAGINATION --}}
                <div class="card-footer bg-white border-0 py-3 no-print">
                    <div class="d-flex justify-content-center">
                        {{ $dataAbsensi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =========================================================================
     CSS CUSTOM UNTUK TAMPILAN FORMAL DAN CETAK
     ========================================================================= --}}
<style>
    /* Sembunyikan Header Cetak di layar monitor */
    .print-header { 
        display: none; 
    }

    @media print {
        /* Tampilkan Header Cetak (Kop Surat) */
        .print-header { 
            display: block !important; 
        }

        /* Detail Teks Perusahaan */
        .company-name {
            font-family: "Times New Roman", Times, serif;
            font-size: 26px !important;
            font-weight: bold;
            color: #000 !important;
        }

        .company-address {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px !important;
            color: #000 !important;
        }

        /* Garis Kop Surat Ganda */
        .header-line {
            border: none;
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin-top: 10px;
        }

        /* Sembunyikan Elemen Navigasi Web */
        .no-print, 
        .main-sidebar, 
        .main-header, 
        .main-footer, 
        .btn, 
        .pagination,
        .card-footer { 
            display: none !important; 
        }

        /* Reset Layout Content */
        .content-wrapper { 
            margin-left: 0 !important; 
            padding: 0 !important;
            background-color: white !important;
        }

        /* Pengaturan Tabel Cetak */
        .table { 
            width: 100% !important; 
            border: 1px solid #000 !important;
            border-collapse: collapse !important;
        }
        
        .table th, .table td { 
            border: 1px solid #000 !important; 
            padding: 10px !important;
            color: #000 !important;
            font-size: 12px !important;
        }

        /* Pastikan background tabel muncul saat print di beberapa browser */
        .thead-light th {
            background-color: #f2f2f2 !important;
            -webkit-print-color-adjust: exact;
        }

        /* Paksa Badge menjadi teks hitam putih agar jelas */
        .badge {
            background: transparent !important;
            color: #000 !important;
            border: 1px solid #000 !important;
            font-weight: bold !important;
        }

        /* Atur Margin Kertas A4 */
       @page {
        size: A4 portrait;
        margin: 0; /* Menghilangkan header dan footer otomatis browser */
    }
    body {
        margin: 1.5cm; /* Memberikan margin manual agar konten tidak terpotong */
    }
    }
</style>
@endsection