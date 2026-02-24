@extends('template.layout')

@section('content')
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
<<<<<<< HEAD
=======
<<<<<<< HEAD


                {{-- Kamera --}}
                <div class="kamera-wrapper mb-3">
                    <video id="video" autoplay playsinline class="kamera-preview"></video>

=======
<<<<<<< HEAD
                {{-- Kamera --}}
                <div class="kamera-wrapper mb-3">
                    <video id="video" autoplay playsinline class="kamera-preview"></video>
=======
>>>>>>> f1d6095a65642153b12fb634fd000999151b7362


                {{-- SECTION KAMERA + AKSI --}}
                <div class="row mb-4">

<<<<<<< HEAD
                    {{-- KAMERA --}}
=======
>>>>>>> 713e2a29bce7b1aaa133413e586b0b40eeda6f5f
>>>>>>> 7926d4ff4b5c3f41d71483937d1ff18e68bfaaf8
<form method="POST" action="{{ route('absensi.store') }}">
@csrf
<input type="hidden" name="photo" id="photo">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">
<<<<<<< HEAD

=======
>>>>>>> 7926d4ff4b5c3f41d71483937d1ff18e68bfaaf8
                <div class="row">
>>>>>>> f1d6095a65642153b12fb634fd000999151b7362
                    <div class="col-md-6 text-center">
                        <div class="camera-box">
                            <video id="video" autoplay playsinline></video>
                        </div>
                    </div>
<<<<<<< HEAD

=======
>>>>>>> 7926d4ff4b5c3f41d71483937d1ff18e68bfaaf8

                    {{-- PANEL AKSI --}}
                    <div class="col-md-6">
                        <div class="card border shadow-sm">
                            <div class="card-body">

                                <button type="button"
                                        onclick="capturePhoto()"
                                        class="btn btn-warning btn-block mb-3">
                                    Ambil Foto
                                </button>

                                {{-- FORM MASUK --}}
                                <form method="POST" action="{{ route('absensi.store') }}" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="photo" id="photo_masuk">
                                    <input type="hidden" name="latitude" id="latitude_masuk">
                                    <input type="hidden" name="longitude" id="longitude_masuk">
                                    <input type="hidden" name="type" value="masuk">

                                    <button type="submit" class="btn btn-success btn-block">
                                        Absen Masuk
                                    </button>
                                </form>

                                {{-- FORM PULANG --}}
                                <form method="POST" action="{{ route('absensi.store') }}">
                                    @csrf
                                    <input type="hidden" name="photo" id="photo_pulang">
                                    <input type="hidden" name="latitude" id="latitude_pulang">
                                    <input type="hidden" name="longitude" id="longitude_pulang">
                                    <input type="hidden" name="type" value="pulang">

                                    <button type="submit" class="btn btn-primary btn-block">
                                        Absen Pulang
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
<<<<<<< HEAD

=======
<<<<<<< HEAD
=======
<<<<<<< HEAD

=======
>>>>>>> 713e2a29bce7b1aaa133413e586b0b40eeda6f5f
>>>>>>> 7926d4ff4b5c3f41d71483937d1ff18e68bfaaf8
>>>>>>> f1d6095a65642153b12fb634fd000999151b7362
                </div>


                <hr>

                {{-- RIWAYAT --}}
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
                                    @if($item->jam_masuk && $item->jam_pulang)
                                        <span class="badge badge-success">Hadir</span>
                                    @elseif($item->status_masuk == 'terlambat')
                                        <span class="badge badge-warning">Terlambat</span>
                                    @else
                                        <span class="badge badge-secondary">Belum Pulang</span>
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



{{-- STYLE --}}
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



{{-- SCRIPT --}}
<script>
const video = document.getElementById('video');
let stream = null;

// Aktifkan Kamera
navigator.mediaDevices.getUserMedia({ video: true })
.then(function(s) {
    stream = s;
    video.srcObject = s;
})
.catch(function(err) {
    console.log("Camera Error:", err);
});

// Ambil Lokasi
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {

        document.getElementById('latitude_masuk').value  = position.coords.latitude;
        document.getElementById('longitude_masuk').value = position.coords.longitude;

        document.getElementById('latitude_pulang').value  = position.coords.latitude;
        document.getElementById('longitude_pulang').value = position.coords.longitude;

    });
}

// Capture Foto
function capturePhoto() {

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

    document.getElementById('photo_masuk').value  = imageData;
    document.getElementById('photo_pulang').value = imageData;

    alert("Foto berhasil diambil");
}

// Stop Kamera Setelah Sukses
@if(session('success'))
if (stream) {
    stream.getTracks().forEach(track => track.stop());
}
@endif
</script>

@endsection