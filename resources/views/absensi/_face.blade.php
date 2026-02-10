<form method="POST" action="{{ route('absensi.store') }}">
@csrf

<input type="hidden" name="nip" value="{{ auth()->user()->nip ?? '' }}">
<input type="hidden" name="kantor_id" value="{{ $kantorList[0]->kantor_id ?? 1 }}">
<input type="hidden" name="metode_absensi" value="face">
<input type="hidden" name="foto_base64" id="foto_base64">

<video id="video" width="320" height="240" autoplay></video>
<br>

<button type="submit" id="btnAbsen">
    Absen
</button>

<canvas id="canvas" width="320" height="240" style="display:none"></canvas>

</form>

<script>
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => document.getElementById('video').srcObject = stream)
    .catch(err => alert('Kamera tidak bisa diakses'));

document.querySelector('form').addEventListener('submit', function () {
    const btn = document.getElementById('btnAbsen');
    btn.disabled = true;
    btn.innerText = 'Memproses...';
});
</script>
