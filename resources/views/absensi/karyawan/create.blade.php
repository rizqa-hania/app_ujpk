@extends('template.karyawan.layout')

@section('content')
<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-camera-retro mr-2"></i> Absensi Digital Scan Wajah</h5>
                </div>
                <div class="card-body text-center bg-light">
                    
                    {{-- ALERT NOTIFIKASI --}}
                    @if(session('error')) 
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div> 
                    @endif
                    @if(session('success')) 
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div> 
                    @endif

                    {{-- PILIHAN ABSEN --}}
                    <div id="actionButtons" class="mb-4">
                        <p class="text-muted mb-3 font-italic">Pilih jenis absensi untuk mengaktifkan kamera</p>
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-2">
                                <button class="btn btn-success btn-lg btn-block shadow-sm py-3" onclick="openCamera('masuk')">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Absen Masuk
                                </button>
                            </div>
                            <div class="col-md-4 mb-2">
                                <button class="btn btn-primary btn-lg btn-block shadow-sm py-3" onclick="openCamera('pulang')">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Absen Pulang
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- KAMERA SECTION --}}
                    <div id="cameraSection" style="display:none; max-width: 500px; margin: 0 auto;">
                        <div class="camera-wrapper position-relative shadow-lg mb-3 bg-dark p-1" style="border-radius: 20px; overflow: hidden;">
                            <video id="video" autoplay playsinline class="w-100" style="border-radius: 18px; transform: scaleX(-1); background: #000;"></video>
                            
                            {{-- Overlay AI Status --}}
                            <div class="position-absolute w-100" style="top: 20px; left: 0; z-index: 10;">
                                <span id="faceStatus" class="badge badge-warning py-2 px-4 shadow" style="font-size: 14px; border-radius: 50px;">
                                    <i class="fas fa-spinner fa-spin mr-2"></i> Memuat AI...
                                </span>
                            </div>

                            {{-- Frame Guide --}}
                            <div class="face-guide"></div>
                        </div>
                        
                        <button class="btn btn-warning btn-block btn-lg mb-2 shadow font-weight-bold" id="btnJepret" onclick="submitAbsen()" disabled>
                            <i class="fas fa-fingerprint mr-2"></i> Verifikasi & Simpan
                        </button>
                        <button class="btn btn-link text-muted" onclick="closeCamera()">Batal / Ganti Jenis Absen</button>
                    </div>

                    <hr class="my-5">

                    {{-- TABEL RIWAYAT --}}
                    <div class="text-left mb-3 d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-history text-primary mr-2"></i> Riwayat 30 Hari Terakhir</h5>
                        <span class="badge badge-pill badge-secondary">{{ count($dataAbsensi ?? []) }} Hari</span>
                    </div>

                    <div class="table-responsive rounded shadow-sm">
                        <table class="table table-hover bg-white mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Bukti</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($dataAbsensi) && count($dataAbsensi) > 0)
                                    @foreach($dataAbsensi as $item)
                                    <tr>
                                        <td class="align-middle font-weight-bold text-dark">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="align-middle">
                                            @if($item->foto_masuk)
                                                <img src="{{ asset('uploads/absensi/'.$item->foto_masuk) }}" width="50" height="50" class="rounded-circle shadow-sm border object-fit-cover" style="cursor:pointer; object-fit: cover;" onclick="window.open(this.src)">
                                            @else
                                                <span class="text-muted small">No Photo</span>
                                            @endif
                                        </td>
                                        <td class="align-middle"><span class="text-success font-weight-bold">{{ $item->jam_masuk ?? '--:--' }}</span></td>
                                        <td class="align-middle"><span class="text-primary font-weight-bold">{{ $item->jam_pulang ?? '--:--' }}</span></td>
                                        <td class="align-middle text-center">
                                            @php
                                                $statusClass = [
                                                    'lengkap' => 'badge-success',
                                                    'alpha' => 'badge-danger',
                                                    'terlambat' => 'badge-warning',
                                                    'izin' => 'badge-info'
                                                ][$item->status_final] ?? 'badge-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }} px-3 py-2 text-uppercase" style="letter-spacing: 1px;">
                                                {{ $item->status_final }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="p-5 text-center text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3 d-block opacity-50"></i>
                                            Belum ada aktivitas absensi bulan ini.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Form --}}
<form method="POST" action="{{ route('absensi.store') }}" id="absenForm">
    @csrf
    <input type="hidden" name="photo" id="photoInput">
    <input type="hidden" name="latitude" id="latInput">
    <input type="hidden" name="longitude" id="lngInput">
    <input type="hidden" name="type" id="typeInput">
</form>

<style>
    .bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
    .face-guide {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 250px; height: 320px;
        border: 2px dashed rgba(255,255,255,0.5);
        border-radius: 50% 50% 40% 40%;
        pointer-events: none;
    }
    .object-fit-cover { object-fit: cover; }
</style>

{{-- Library AI --}}
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    let video = document.getElementById('video');
    let faceStatus = document.getElementById('faceStatus');
    let btnJepret = document.getElementById('btnJepret');
    let stream = null;
    let modelsLoaded = false;
    let detectionInterval = null;

    // Load AI Models
    async function initAI() {
        const MODEL_URL = 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights';
        try {
            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            modelsLoaded = true;
            faceStatus.innerHTML = '<i class="fas fa-check"></i> Sistem AI Aktif';
            faceStatus.className = "badge badge-info py-2 px-4 shadow";
        } catch (e) {
            faceStatus.innerHTML = '<i class="fas fa-times"></i> AI Gagal Dimuat';
            faceStatus.className = "badge badge-danger py-2 px-4 shadow";
        }
    }

    window.addEventListener('DOMContentLoaded', initAI);

    async function openCamera(type) {
        document.getElementById('typeInput').value = type;
        document.getElementById('actionButtons').style.display = 'none';
        document.getElementById('cameraSection').style.display = 'block';
        
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: "user", width: 640, height: 480 } 
            });
            video.srcObject = stream;
            
            video.onplay = () => {
                detectionInterval = setInterval(async () => {
                    if (!modelsLoaded) return;
                    
                    const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions());
                    
                    if (detections) {
                        faceStatus.innerHTML = '<i class="fas fa-smile"></i> Wajah Terdeteksi';
                        faceStatus.className = "badge badge-success py-2 px-4 shadow";
                        btnJepret.disabled = false;
                    } else {
                        faceStatus.innerHTML = '<i class="fas fa-user-slash"></i> Posisikan Wajah di Frame';
                        faceStatus.className = "badge badge-warning py-2 px-4 shadow";
                        btnJepret.disabled = true;
                    }
                }, 500);
            };
        } catch (err) {
            alert("Error: Kamera tidak bisa diakses.");
            closeCamera();
        }
    }

    function closeCamera() {
        if(stream) stream.getTracks().forEach(t => t.stop());
        if(detectionInterval) clearInterval(detectionInterval);
        document.getElementById('cameraSection').style.display = 'none';
        document.getElementById('actionButtons').style.display = 'block';
        btnJepret.disabled = true;
    }

    function submitAbsen() {
        btnJepret.disabled = true;
        btnJepret.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim Data...';

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        
        // Mirroring fix
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0);
        
        document.getElementById('photoInput').value = canvas.toDataURL('image/jpeg', 0.7);

        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('latInput').value = pos.coords.latitude;
            document.getElementById('lngInput').value = pos.coords.longitude;
            
            closeCamera();
            document.getElementById('absenForm').submit();
        }, err => {
            btnJepret.disabled = false;
            btnJepret.innerHTML = '<i class="fas fa-fingerprint mr-2"></i> Foto & Simpan';
            alert("Error: Lokasi (GPS) wajib diaktifkan!");
        }, { enableHighAccuracy: true });
    }
</script>
@endsection