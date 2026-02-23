@extends('template.layout')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold text-primary mb-0">SLIP GAJI</h2>
                        <p class="text-muted mb-0">Periode: {{ $detail->penggajian->periode_bulan }} {{ $detail->penggajian->periode_tahun }}</p>
                    </div>
                    <div class="text-right">
                        <img src="https://via.placeholder.com/150x50?text=UJPK+LOGO" alt="Logo" class="img-fluid mb-2">
                        <h5 class="mb-0 font-weight-bold">PT. UJPK</h5>
                    </div>
                </div>
            </div>
            <hr class="mx-4">
            <div class="card-body px-4">
                <!-- Employee Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="150">NIP</th>
                                <td>: {{ $detail->karyawan->nip }}</td>
                            </tr>
                            <tr>
                                <th>Nama Karyawan</th>
                                <td>: {{ $detail->karyawan->nama_depan }} {{ $detail->karyawan->nama_belakang }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="150">Jabatan</th>
                                <td>: {{ $detail->karyawan->jabatan->nama_jabatan ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: <span class="badge badge-success">{{ $detail->karyawan->status_karyawan }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Salary Breakdown -->
                <div class="row mt-4">
                    <!-- Income Section -->
                    <div class="col-md-6 border-right">
                        <h5 class="border-bottom pb-2 font-weight-bold text-success">
                            <i class="fas fa-plus-circle mr-2"></i> Pendapatan
                        </h5>
                        <table class="table table-borderless table-sm">
                            @php $totalPendapatan = 0; @endphp
                            @foreach($detail->detailKomponen->filter(function($item) { 
                                return strtolower($item->tipe) == 'pendapatan' || (isset($item->komponen) && strtolower($item->komponen->tipe) == 'pendapatan'); 
                            }) as $item)
                                <tr>
                                    <td>{{ $item->komponen->komponen ?? $item->kode }}</td>
                                    <td class="text-right">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                </tr>
                                @php $totalPendapatan += $item->nilai; @endphp
                            @endforeach
                            <!-- Default Base Salary if not in components -->
                            @if($detail->total_pendapatan > $totalPendapatan)
                                <tr>
                                    <td>Lain-lain</td>
                                    <td class="text-right">Rp {{ number_format($detail->total_pendapatan - $totalPendapatan, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr class="font-weight-bold border-top">
                                <td>Total Pendapatan</td>
                                <td class="text-right text-success">Rp {{ number_format($detail->total_pendapatan, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Deductions Section -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 font-weight-bold text-danger">
                            <i class="fas fa-minus-circle mr-2"></i> Potongan
                        </h5>
                        <table class="table table-borderless table-sm">
                            @php $totalPotongan = 0; @endphp
                            @foreach($detail->detailKomponen->filter(function($item) { 
                                return strtolower($item->tipe) == 'potongan' || (isset($item->komponen) && strtolower($item->komponen->tipe) == 'potongan'); 
                            }) as $item)
                                <tr>
                                    <td>{{ $item->komponen->komponen ?? $item->kode }}</td>
                                    <td class="text-right">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                </tr>
                                @php $totalPotongan += $item->nilai; @endphp
                            @endforeach
                             @if($detail->total_potongan > $totalPotongan)
                                <tr>
                                    <td>Potongan Lainnya</td>
                                    <td class="text-right">Rp {{ number_format($detail->total_potongan - $totalPotongan, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr class="font-weight-bold border-top">
                                <td>Total Potongan</td>
                                <td class="text-right text-danger">Rp {{ number_format($detail->total_potongan, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="alert alert-info py-4 shadow-sm border-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 font-weight-bold">GAJI BERSIH (TAKE HOME PAY)</h4>
                            <h3 class="mb-0 font-weight-bold">Rp {{ number_format($detail->gaji_bersih, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Footer / Signatures -->
                <div class="row mt-5 pt-4">
                    <div class="col-md-8">
                        <p class="text-muted small">
                            * Ini adalah slip gaji resmi yang dihasilkan secara otomatis oleh sistem.<br>
                            * Segala pertanyaan terkait rincian gaji dapat ditujukan ke bagian HRD.
                        </p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="mb-5">Dicetak pada: {{ date('d F Y') }}</p>
                        <div style="height: 80px;"></div>
                        <p class="font-weight-bold border-top pt-2">Manajer Keuangan</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pb-4 px-4 text-right no-print">
                <button onclick="window.print()" class="btn btn-secondary shadow-sm">
                    <i class="fas fa-print mr-2"></i> Cetak Slip
                </button>
                <a href="{{ route('detail.index', $detail->penggajian_id) }}" class="btn btn-outline-primary shadow-sm ml-2">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .main-sidebar, .main-header, .no-print, .btn, .card-footer {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        body {
            background-color: white !important;
        }
        .container-fluid {
            padding: 0 !important;
        }
    }
    .badge {
        padding: 6px 12px;
        font-weight: 500;
    }
    .card-header h2 {
        letter-spacing: 2px;
    }
</style>
@endsection
