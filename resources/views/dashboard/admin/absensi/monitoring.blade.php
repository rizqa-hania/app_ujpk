@extends('template.admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="font-weight-bold text-dark">Monitoring Presensi</h3>
            <p class="text-muted mb-1">Status kehadiran karyawan hari ini: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong></p>
            <p class="text-muted small">
                Kantor: <strong>{{ $kantor ? $kantor->nama_kantor : 'Belum Diatur' }}</strong> | 
                Jadwal: <strong>{{ $isHariKerja ? 'Hari Kerja' : 'Hari Libur' }}</strong>
            </p>
        </div>
        <div class="col-md-4 text-right">
            <button onclick="window.location.reload()" class="btn btn-outline-primary shadow-sm">
                <i class="fas fa-sync-alt"></i> Refresh Data
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Kehadiran Karyawan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="tableMonitoring">
                            <thead class="thead-light">
                                <tr>
                                    <th>Karyawan</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Status Presensi</th>
                                    <th>Keterangan Sistem</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($karyawan as $k)
                                @php 
                                    $absen = $k->absen_hari_ini; 
                                    $izin = $k->izin_hari_ini ?? null;
                                    $lembur = $k->lembur_hari_ini ?? null;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm mr-3">
                                                <span class="btn btn-sm btn-info btn-circle font-weight-bold">
                                                    {{ strtoupper(substr($k->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="font-weight-bold d-block">{{ $k->name }}</span>
                                                <small class="text-muted">NIP: {{ $k->nip ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($absen && $absen->jam_masuk)
                                            <span class="badge badge-light border text-dark p-2">
                                                <i class="far fa-clock text-success mr-1"></i> {{ $absen->jam_masuk }}
                                            </span>
                                        @else
                                            <span class="text-danger font-italic small">Belum Masuk</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($absen && $absen->jam_pulang)
                                            <span class="badge badge-light border text-dark p-2">
                                                <i class="far fa-clock text-primary mr-1"></i> {{ $absen->jam_pulang }}
                                            </span>
                                        @elseif($absen && $absen->jam_masuk)
                                            <span class="text-warning font-italic small">Belum Pulang</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($izin)
                                            <span class="badge badge-info px-3 py-2 shadow-sm text-uppercase">{{ $izin->jenis }}</span>
                                        @elseif(!$isHariKerja && !$absen)
                                            <span class="badge badge-secondary px-3 py-2 shadow-sm text-uppercase">LIBUR</span>
                                        @elseif(!$absen)
                                            <span class="badge badge-warning px-3 py-2 shadow-sm">BELUM ABSEN</span>
                                        @elseif(in_array($absen->status_final, ['izin', 'sakit', 'cuti']))
                                            <span class="badge badge-info px-3 py-2 shadow-sm text-uppercase">{{ $absen->status_final }}</span>
                                        @elseif($absen->status_final == 'belum lengkap' || $absen->status_final == 'tidak lengkap')
                                            <span class="badge badge-secondary px-3 py-2 shadow-sm text-uppercase">{{ $absen->status_final }}</span>
                                        @else
                                            <span class="badge badge-success px-3 py-2 shadow-sm text-uppercase">{{ $absen->status_final }}</span>
                                        @endif

                                        @if($lembur)
                                            <div class="mt-1">
                                                <span class="badge badge-primary px-3 py-1 shadow-sm">LEMBUR ({{ $lembur->jam_mulai }} - {{ $lembur->jam_selesai }})</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($izin)
                                            <small class="text-info font-weight-bold"><i class="fas fa-info-circle"></i> {{ $izin->keterangan }}</small>
                                        @elseif($absen)
                                            <small class="text-capitalize font-weight-bold">
                                                @if($absen->status_final == 'lengkap')
                                                    <i class="fas fa-check-circle text-success"></i> Tepat Waktu
                                                @else
                                                    <i class="fas fa-exclamation-triangle text-warning"></i> {{ $absen->status_final }}
                                                @endif
                                            </small>
                                        @elseif(!$isHariKerja)
                                            <small class="text-secondary"><i class="fas fa-bed"></i> Libur Jadwal</small>
                                        @else
                                            <small class="text-danger">Tidak Ada Rekam Jejak</small>
                                        @endif

                                        @if($lembur)
                                            <br>
                                            <small class="text-primary font-weight-bold"><i class="fas fa-tasks"></i> Lembur Disetujui</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($absen && $absen->latitude)
                                        <a href="https://www.google.com/maps?q={{ $absen->latitude }},{{ $absen->longitude }}" 
                                           target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-map-marker-alt"></i> Lokasi
                                        </a>
                                        @else
                                        <button class="btn btn-sm btn-light disabled"><i class="fas fa-map-marker-alt"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#tableMonitoring').DataTable({
            "pageLength": 25,
            "language": {
                "search": "Cari Karyawan:",
                "emptyTable": "Tidak ada data karyawan ditemukan"
            }
        });
    });
</script>
@endpush