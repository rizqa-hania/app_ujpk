<h2>ABSENSI KARYAWAN</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<hr>

<h3>Absensi Scan Wajah</h3>
@include('absensi._face')

