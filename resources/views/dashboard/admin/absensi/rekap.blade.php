@extends('template.admin.layout')

@section('content')
<div class="content pt-3">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <h3 class="font-weight-bold text-dark"><i class="fas fa-clipboard-check text-primary"></i> Rekap Absensi (Monitoring)</h3>
                <p class="text-muted">Periode: {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Filter & Cetak Rekap</h3>
                    </div>
                    <div class="card-body">
                        <!-- Quick Filters -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="quickFilter(0)">Hari Ini</button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="quickFilter(7)">Bulan Ini</button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="quickFilter(365)">Tahun Ini</button>
                        </div>
                        <form action="{{ route('absensi.rekap') }}" method="GET" class="form-inline mb-2">
                            <div class="form-group mr-3 mt-2">
                                <label for="start_date" class="mr-2">Mulai:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group mr-3 mt-2">
                                <label for="end_date" class="mr-2">Sampai:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end->format('Y-m-d') }}" required>
                            </div>

                            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                            <div class="form-group mr-3 mt-2">
                                <label for="user_id" class="mr-2">Karyawan:</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="semua" {{ request('user_id') == 'semua' ? 'selected' : '' }}>Semua Karyawan</option>
                                    @foreach($allKaryawans as $kry)
                                        <option value="{{ $kry->id }}" {{ request('user_id') == $kry->id ? 'selected' : '' }}>{{ $kry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Filter</button>
                                <a href="{{ route('absensi.rekap.cetak', ['start_date' => $start->format('Y-m-d'), 'end_date' => $end->format('Y-m-d'), 'user_id' => request('user_id', 'semua')]) }}" class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Cetak PDF
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-chart-pie text-info"></i> Diagram Kehadiran</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="kehadiranChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-list text-success"></i> Data Rekap Karyawan</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tableRekap">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>NIP</th>
                                        <th>Hadir</th>
                                        <th>Izin/Cuti</th>
                                        <th>Alpha</th>
                                        <th>Lembur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1; 
                                        $totHadir=0; $totIzin=0; $totAlpha=0;
                                    @endphp
                                    @foreach($rekap as $r)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td class="font-weight-bold">{{ $r['nama'] }}</td>
                                        <td>{{ $r['nip'] ?? '-' }}</td>
                                        <td><span class="badge badge-success px-2 py-1">{{ $r['hadir'] }}</span></td>
                                        <td><span class="badge badge-info px-2 py-1">{{ $r['izin'] }}</span></td>
                                        <td><span class="badge badge-danger px-2 py-1">{{ $r['alpha'] }}</span></td>
                                        <td><span class="badge badge-warning px-2 py-1">{{ $r['lembur'] }}</span></td>
                                    </tr>
                                    @php
                                        $totHadir += $r['hadir'];
                                        $totIzin += $r['izin'];
                                        $totAlpha += $r['alpha'];
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        $('#tableRekap').DataTable({
            "pageLength": 10,
            "language": {
                "search": "Cari Karyawan:",
                "emptyTable": "Tidak ada data pada periode ini"
            }
        });

        var ctx = document.getElementById('kehadiranChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Izin/Sakit/Cuti', 'Alpha'],
                datasets: [{
                    label: 'Total Absensi',
                    data: [{{ $totHadir }}, {{ $totIzin }}, {{ $totAlpha }}],
                    backgroundColor: [
                        '#28a745', // success
                        '#17a2b8', // info
                        '#dc3545'  // danger
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });

    function quickFilter(type) {
        let start = document.getElementById('start_date');
        let end = document.getElementById('end_date');
        let today = new Date();
        
        function fmt(d) {
            return d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
        }

        if (type === 0) { // Hari Ini
            start.value = fmt(today);
            end.value = fmt(today);
        } else if (type === 7) { // Bulan Ini
            start.value = fmt(new Date(today.getFullYear(), today.getMonth(), 1));
            end.value = fmt(new Date(today.getFullYear(), today.getMonth() + 1, 0));
        } else if (type === 365) { // Tahun Ini
            start.value = fmt(new Date(today.getFullYear(), 0, 1));
            end.value = fmt(new Date(today.getFullYear(), 11, 31));
        }
        
        start.closest('form').submit();
    }
</script>
@endpush
