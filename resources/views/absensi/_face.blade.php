<form method="POST" action="{{ route('absensi.store') }}">
@csrf

<input type="hidden" name="nip" value="{{ auth()->user()->nip ?? '' }}">
<input type="hidden" name="foto_base64" id="foto_base64">

<video id="video" width="320" height="240" autoplay></video>
<br>
<button type="button" onclick="capture()">Ambil Foto</button>
<button type="submit">Absen</button>
</form>

<canvas id="canvas" width="320" height="240" style="display:none"></canvas>

<script>
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => document.getElementById('video').srcObject = stream)
    .catch(err => alert('Kamera tidak bisa diakses'));

function capture() {
    const canvas = document.getElementById('canvas');
    const video = document.getElementById('video');
    canvas.getContext('2d').drawImage(video, 0, 0, 320, 240);
    document.getElementById('foto_base64').value = canvas.toDataURL('image/png');
}
</script>

