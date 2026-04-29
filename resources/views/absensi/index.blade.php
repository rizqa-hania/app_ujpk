@extends('template.karyawan.layout')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-camera mr-2"></i> Absensi Scan Wajah</h5>
            </div>
            <div class="card-body text-center">
                @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
                @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

                <div class="mb-4">
                    <button class="btn btn-success btn-lg shadow-sm" onclick="openCamera('masuk')">
                        <i class="fas fa-sign-in-alt"></i> Absen Masuk
                    </button>
                    <button class="btn btn-primary btn-lg shadow-sm" onclick="openCamera('pulang')">
                        <i class="fas fa-sign-out-alt"></i> Absen Pulang
                    </button>
                </div>

                <div id="cameraSection" style="display:none; max-width: 500px; margin: 0 auto; position: relative;">
                    <div class="camera-box border p-2 mb-3 bg-dark" style="position: relative; border-radius: 15px;">
                        <video id="video" autoplay playsinline style="width: 100%; border-radius: 10px; transform: scaleX(-1);"></video>
                        <div style="position: absolute; top: 20px; left: 0; right: 0; display: flex; justify-content: center;">
                            <span id="faceStatus" class="badge badge-warning p-2 shadow" style="font-size: 14px; min-width: 200px;">
                                <i class="fas fa-spinner fa-spin"></i> Menyiapkan AI...
                            </span>
                        </div>
                    </div>
                    
                    <button class="btn btn-warning btn-block btn-lg mb-2 shadow" id="btnJepret" onclick="submitAbsen()" disabled>
                        <i class="fas fa-fingerprint"></i> Foto & Simpan Absen
                    </button>
                    <button class="btn btn-light btn-block" onclick="closeCamera()">Batal</button>
                </div>

                <hr>

                <h5 class="text-left"><i class="fas fa-history"></i> Riwayat 30 Hari Terakhir</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered bg-white">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Bukti</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>Status Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Tambahkan pengecekan isset untuk memastikan variabel ada --}}
                            @if(isset($dataAbsensi) && count($dataAbsensi) > 0)
                                @foreach($dataAbsensi as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($item->foto_masuk)
                                            <img src="{{ asset('uploads/absensi/'.$item->foto_masuk) }}" width="45" class="rounded shadow-sm border" style="cursor:pointer" onclick="window.open(this.src)">
                                        @else - @endif
                                    </td>
                                    <td><span class="badge badge-light border">{{ $item->jam_masuk ?? '--:--' }}</span></td>
                                    <td><span class="badge badge-light border">{{ $item->jam_pulang ?? '--:--' }}</span></td>
                                    <td>
                                        @if($item->status_final == 'lengkap')
                                            <span class="badge badge-success px-3">Lengkap</span>
                                        @elseif($item->status_final == 'alpha')
                                            <span class="badge badge-danger px-3">Alpha</span>
                                        @else
                                            <span class="badge badge-warning px-3">{{ ucfirst($item->status_final) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-muted p-4">
                                        <i class="fas fa-info-circle mr-1"></i> Belum ada data absensi untuk ditampilkan.
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

<form method="POST" action="{{ route('absensi.store') }}" id="absenForm">
    @csrf
    <input type="hidden" name="photo" id="photoInput">
    <input type="hidden" name="latitude" id="latInput">
    <input type="hidden" name="longitude" id="lngInput">
    <input type="hidden" name="type" id="typeInput">
</form>

<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    let video = document.getElementById('video');
    let faceStatus = document.getElementById('faceStatus');
    let btnJepret = document.getElementById('btnJepret');
    let stream = null;
    let modelsLoaded = false;

 
async function loadModels() {
    const MODEL_URL = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights';
    try {
        // Perhatikan penulisan faceapi di bawah ini:
        await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
        modelsLoaded = true;
        faceStatus.innerHTML = '<i class="fas fa-video"></i> Kamera Siap';
    } catch (e) {
        console.error("Gagal load model:", e);
        faceStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Gagal Memuat AI';
        btnJepret.disabled = false; // Biar tetep bisa absen manual
    }
}
    
    window.onload = loadModels;

    async function openCamera(type) {
        document.getElementById('typeInput').value = type;
        document.getElementById('cameraSection').style.display = 'block';
        
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } });
            video.srcObject = stream;
            
            video.onplay = () => {
                const detect = setInterval(async () => {
                    if (!modelsLoaded) return;
                    const detections = await face-api.detectSingleFace(video, new face-api.TinyFaceDetectorOptions());
                    
                    if (detections) {
                        faceStatus.innerHTML = '<i class="fas fa-check-circle"></i> Wajah Terdeteksi';
                        faceStatus.className = "badge badge-success p-2 shadow";
                        btnJepret.disabled = false;
                    } else {
                        faceStatus.innerHTML = '<i class="fas fa-user-slash"></i> Muka tidak terdeteksi';
                        faceStatus.className = "badge badge-danger p-2 shadow";
                        btnJepret.disabled = true;
                    }
                }, 600);
            };
        } catch (err) {
            alert("Kamera tidak ditemukan. Pastikan izin kamera diberikan.");
        }
    }

    function closeCamera() {
        if(stream) stream.getTracks().forEach(t => t.stop());
        document.getElementById('cameraSection').style.display = 'none';
    }

    function submitAbsen() {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0);
        
        document.getElementById('photoInput').value = canvas.toDataURL('image/png');
        faceStatus.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

        navigator.geolocation.getCurrentPosition(pos => {
            document.getElementById('latInput').value = pos.coords.latitude;
            document.getElementById('lngInput').value = pos.coords.longitude;
            document.getElementById('absenForm').submit();
        }, err => {
            alert("Lokasi GPS diperlukan untuk absen.");
            faceStatus.innerHTML = 'Gagal Lokasi';
        });
    }
</script>
@endsection