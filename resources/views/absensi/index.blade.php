@extends('template.layout')

@section('content')
<div class="row"> 
    <div class="col-12">
        <div class="card"> 

            <div class="card-header">
                <h3 class="card-title">Absensi Wajah + Radius</h3> 
            </div>

            <div class="card-body">

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
                </div>

                <hr>

                <h5>Riwayat Absensi</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
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
                                <td colspan="5" class="text-center">Belum ada data absensi</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

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