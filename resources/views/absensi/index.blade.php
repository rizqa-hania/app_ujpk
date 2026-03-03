@extends('template.layout')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Absensi Karyawan</h5>
            </div>

            <div class="card-body">

                {{-- ALERT --}}
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
                        <button class="btn btn-success" onclick="openCamera('masuk')">
                            Absen Masuk
                        </button>

                        <button class="btn btn-primary" onclick="openCamera('pulang')">
                            Absen Pulang
                        </button>
                    </div>

                    <div class="col-md-12 text-center" id="cameraSection" style="display:none;">
                        <div class="camera-box">
                            <video id="video" autoplay playsinline></video>
                        </div>

                        <button class="btn btn-warning mt-3" onclick="submitAbsen()">
                            Absen Sekarang
                        </button>

                        <button class="btn btn-danger mt-2" onclick="closeCamera()">
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
                                @switch($item->status)

                                    @case('tepat waktu')
                                        <span class="badge badge-success">Tepat Waktu</span>
                                    @break

                                    @case('terlambat')
                                        <span class="badge badge-warning">Terlambat</span>
                                    @break

                                    @case('lengkap')
                                        <span class="badge badge-primary">Lengkap</span>
                                    @break

                                    @case('tidak lengkap')
                                        <span class="badge badge-secondary">Tidak Lengkap</span>
                                    @break

                                    @case('terlambat dan tidak lengkap')
                                        <span class="badge badge-danger">Terlambat & Tidak Lengkap</span>
                                    @break

                                    @case('izin')
                                        <span class="badge badge-info">Izin</span>
                                    @break

                                    @default
                                        <span class="badge badge-dark">
                                            {{ $item->status ?? '-' }}
                                        </span>

                                @endswitch
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
let currentType = null;

// ===========================
// BUKA KAMERA
// ===========================
async function openCamera(type) {

    currentType = type;
    document.getElementById('absenType').value = type;

    cameraSection.style.display = "block";

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: "user" },
            audio: false
        });

        video.srcObject = stream;

    } catch (err) {
        console.error("Camera error:", err);
        alert("Kamera tidak bisa diakses. Izinkan akses kamera.");
    }
}

// ===========================
// TUTUP KAMERA
// ===========================
function closeCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    cameraSection.style.display = "none";
}

// ===========================
// SUBMIT ABSEN
// ===========================
function submitAbsen() {

    if (!video.videoWidth) {
        alert("Kamera belum siap");
        return;
    }

    const canvas = document.createElement('canvas');
    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    const imageData = canvas.toDataURL('image/png');

    document.getElementById('photo').value = imageData;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {

            document.getElementById('latitude').value  = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;

            document.getElementById('absenForm').submit();
            closeCamera();
        });
    } else {
        document.getElementById('absenForm').submit();
        closeCamera();
    }
}
</script>

@endsection