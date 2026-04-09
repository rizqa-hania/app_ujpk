@extends('template.karyawan.layout')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Absensi Karyawan</h5>
            </div>

            <div class="card-body">

                {{-- ERROR VALIDATION --}}
                @if ($errors->any())
                    <div class="alert alert-danger" >
                        
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- SESSION ALERT --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- ============================= --}}
                {{-- SECTION ABSEN --}}
                {{-- ============================= --}}
                <div class="row mb-4">

                    <div class="col-md-12 text-center mb-3">
                        <button type="button" class="btn btn-success" onclick="openCamera('masuk')">
                            Absen Masuk
                        </button>

                        <button type="button" class="btn btn-primary" onclick="openCamera('pulang')">
                            Absen Pulang
                        </button>
                    </div>


                    <div class="col-md-12 text-center" id="cameraSection" style="display:none;">
                        <div class="camera-box">
                            <video id="video" autoplay playsinline></video>
                        </div>

                        <button type="button" class="btn btn-warning mt-3" onclick="submitAbsen()">
                            Absen Sekarang
                        </button>

                        <button type="button" class="btn btn-danger mt-2" onclick="closeCamera()">
                            Batal
                        </button>
                    </div>

                </div>

                {{-- FORM HIDDEN --}}
                <form method="POST" action="{{ route('absensi.store') }}" id="absenForm">
                    @csrf
                    <input type="hidden" name="photo" id="photo">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="type" id="absenType">
                </form>

                <hr>

                {{-- ============================= --}}
                {{-- RIWAYAT --}}
                {{-- ============================= --}}
                <h5 class="mb-3">Riwayat Absensi</h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($dataAbsensi as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->jam_masuk ?? '-' }}</td>
                                <td>{{ $item->jam_pulang ?? '-' }}</td>
                                <td>
                                    @php
                                        $status = $item->status_final ?? '-';
                                    @endphp

                                    @if($status == 'lengkap')
                                        <span class="badge badge-success">Lengkap</span>
                                    @elseif($status == 'terlambat')
                                        <span class="badge badge-warning">Terlambat</span>
                                    @elseif($status == 'pulang cepat')
                                        <span class="badge badge-danger">Pulang Cepat</span>
                                    @elseif($status == 'terlambat dan pulang cepat')
                                        <span class="badge badge-danger">Terlambat & Pulang Cepat</span>
                                    @elseif($status == 'belum lengkap')
                                        <span class="badge badge-secondary">Belum Lengkap</span>
                                    @else
                                        <span class="badge badge-dark">{{ $status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data absensi
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.camera-box {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 10px;
    background: #f8f9fa;
}

#video {
    width: 100%;
    max-height: 350px;
    border-radius: 8px;
}
</style>

<script>
const video = document.getElementById('video');
const cameraSection = document.getElementById('cameraSection');

let stream = null;

async function openCamera(type) {

    document.getElementById('absenType').value = type;
    cameraSection.style.display = "block";

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user" },
            audio: false
        });

        video.srcObject = stream;

    } catch (err) {
        alert("Kamera tidak bisa diakses. Pastikan izin kamera aktif.");
    }
}

function closeCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    cameraSection.style.display = "none";
}

function submitAbsen() {

    const type = document.getElementById('absenType').value;

    if (!type) {
        alert("Tipe absen tidak terdeteksi");
        return;
    }

    if (!video.videoWidth) {
        alert("Kamera belum siap");
        return;
    }

    const canvas = document.createElement('canvas');
    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    document.getElementById('photo').value = canvas.toDataURL('image/png');

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value  = parseFloat(position.coords.latitude);
                document.getElementById('longitude').value = parseFloat(position.coords.longitude);
                document.getElementById('absenForm').submit();
            },
            function() {
    alert("Lokasi wajib aktif!");
}
        );

    } else {
        document.getElementById('absenForm').submit();
    }

    closeCamera();
}
</script>
@push('js')
<script>
    new DataTable('#table');

    // Menghilangkan notifikasi setelah 5 detik (5000ms)
    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(function() {
                alert.style.display = "none";
            }, 500);
        });
    }, 5000);
</script>

@endpush
@endsection