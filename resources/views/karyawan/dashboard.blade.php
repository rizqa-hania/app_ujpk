<h1>Dashboard Karyawan</h1>

<p>Selamat datang, {{ auth()->user()->name }}</p>

<ul>
    <li>Isi Absensi</li>
    <li>Lihat Riwayat Absensi</li>
    <li>Edit Profil</li>
</ul>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
