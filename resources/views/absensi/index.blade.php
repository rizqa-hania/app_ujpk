@extends('template.layout')

@section('content')
<div class="row">
    
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Absensi</h3>
            </div>

            <div class="card-body text-center">

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
<<<<<<< HEAD
                {{-- Kamera --}}
                <div class="kamera-wrapper mb-3">
                    <video id="video" autoplay playsinline class="kamera-preview"></video>
=======


                {{-- Kamera --}}
                <div class="kamera-wrapper mb-3">
                    <video id="video" autoplay playsinline class="kamera-preview"></video>

>>>>>>> 713e2a29bce7b1aaa133413e586b0b40eeda6f5f
<form method="POST" action="{{ route('absensi.store') }}">
@csrf
<input type="hidden" name="photo" id="photo">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <video id="video" class="img-fluid rounded" autoplay></video>
                    </div>

                    <div class="col-md-6">
                        <form method="POST" action="{{ route('absensi.store') }}">
                            @csrf
                            <input type="hidden" name="photo" id="photo">
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">


<form method="POST" action="{{ route('absensi.store') }}">
@csrf
<input type="hidden" name="photo" id="photo2">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

                            <button type="button" onclick="capture()" class="btn btn-info mb-2">
                                Ambil Foto
                            </button>


                            <button type="submit" class="btn btn-success btn-block">
                                Absen Sekarang
                            </button>
                        </form>
                    </div>
<<<<<<< HEAD

=======
>>>>>>> 713e2a29bce7b1aaa133413e586b0b40eeda6f5f
                </div>

                {{-- FORM MASUK --}}
                <form method="POST" action="{{ route('absensi.store') }}" class="mb-2">
                    @csrf
                    <input type="hidden" name="photo" id="photo">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="type" value="masuk">

                    <button type="button" onclick="capture()" class="btn btn-warning btn-sm">
                        Ambil Foto
                    </button>

                    <button type="submit" class="btn btn-success btn-sm">
                        Absen Masuk
                    </button>
                </form>

                {{-- FORM PULANG --}}
                <form method="POST" action="{{ route('absensi.store') }}">
                    @csrf
                    <input type="hidden" name="photo" id="photo2">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="type" value="pulang">

                    <button type="submit" class="btn btn-primary btn-sm">
                        Absen Pulang
                    </button>
                </form>

                <hr>

                {{-- RIWAYAT --}}
                <h5 class="text-left">Riwayat Absensi</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($dataAbsensi) && $dataAbsensi->count() > 0)
                            @foreach($dataAbsensi as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->jam_masuk }}</td>
                                    <td>{{ $item->jam_pulang }}</td>
                                    <td>
                                        @if($item->jam_masuk && $item->jam_pulang)
                                            <span class="badge badge-success">Hadir</span>
                                        @elseif($item->status_masuk == 'terlambat')
                                            <span class="badge badge-warning">Terlambat</span>
                                        @else
                                            <span class="badge badge-info">Belum Pulang</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data absensi
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

{{-- STYLE KAMERA --}}
<style>
.kamera-wrapper {
    display: flex;
    justify-content: center;
}

.kamera-preview {
    width: 400px; /* ukuran sedang-kecil */
    max-width: 100%;
    border-radius: 10px;
    border: 1px solid #ddd;
}
</style>

{{-- SCRIPT --}}
<script>
const video = document.getElementById('video');
let stream = null;

navigator.mediaDevices.getUserMedia({ video: true })
.then(function(s) {
    stream = s;
    video.srcObject = stream;
})
.catch(function(err) {
    console.log(err);
});

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
    });
}

function capture() {
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    document.getElementById('photo').value = canvas.toDataURL('image/png');
    alert("Foto berhasil diambil");
}

// Matikan kamera jika sukses
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        video.srcObject = null;
    }
}

@if(session('success'))
    stopCamera();
@endif
</script>

@endsection