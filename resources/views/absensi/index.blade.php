
<h2>ABSENSI KARYAWAN</h2>

{{-- ERROR --}}
@if ($errors->any())
    <div style="color:red">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

{{-- SUCCESS --}}
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

{{-- STATUS HARI INI --}}
@if(isset($todayAbsensi))
    <p style="color:blue">
        Status hari ini:
        @if($todayAbsensi->jam_masuk && !$todayAbsensi->jam_pulang)
            ✅ Sudah absen MASUK ({{ $todayAbsensi->jam_masuk }})
        @elseif($todayAbsensi->jam_pulang)
            ✅ Sudah absen MASUK & PULANG
        @endif
    </p>
@else
    <p style="color:orange">⏳ Belum absen hari ini</p>
@endif

<hr>

<h3>Absensi Scan Wajah</h3>
@include('absensi._face')

<hr>

<h3>Data Absensi</h3>
@include('absensi._table')
