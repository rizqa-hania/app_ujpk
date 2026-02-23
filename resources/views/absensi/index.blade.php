@extends('template.layouts')

@section('content')
<div class="container">

<h3>Absensi Wajah + Radius</h3>

@if(session('error'))
<div style="color:red">{{ session('error') }}</div>
@endif

@if(session('success'))
<div style="color:green">{{ session('success') }}</div>
@endif

<video id="video" width="400" autoplay></video>
<canvas id="canvas" style="display:none;"></canvas>

<form method="POST" action="{{ route('absensi.store') }}">
@csrf
<input type="hidden" name="photo" id="photo">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<button type="button" onclick="capture('photo')">Ambil Foto Masuk</button>
<button type="submit">Absen Masuk</button>
</form>

<form method="POST" action="{{ route('absensi.store') }}">
@csrf
<input type="hidden" name="photo" id="photo2">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<button type="button" onclick="capture('photo2')">Ambil Foto Pulang</button>
<button type="submit">Absen Pulang</button>
</form>

<hr>

<h4>Riwayat</h4>
<table border="1">
<tr>
<th>Tanggal</th>
<th>Masuk</th>
<th>Pulang</th>
<th>Status</th>
<th>Jarak (m)</th>
</tr>

@foreach($dataAbsensi as $item)
<tr>
<td>{{ $item->tanggal }}</td>
<td>{{ $item->jam_masuk }}</td>
<td>{{ $item->jam_pulang }}</td>
<td>{{ $item->status }}</td>
<td>{{ $item->jarak }}</td>
</tr>
@endforeach
</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/face-api.js"></script>

<script>
const video = document.getElementById('video');

navigator.mediaDevices.getUserMedia({ video: {} })
.then(stream => video.srcObject = stream);

if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(function(position) {
document.getElementById('latitude').value = position.coords.latitude;
document.getElementById('longitude').value = position.coords.longitude;
});
}

async function capture(field) {
const canvas = document.getElementById('canvas');
canvas.width = video.videoWidth;
canvas.height = video.videoHeight;
canvas.getContext('2d').drawImage(video, 0, 0);
document.getElementById(field).value = canvas.toDataURL('image/png');
alert("Foto berhasil diambil");
}
</script>

@endsection