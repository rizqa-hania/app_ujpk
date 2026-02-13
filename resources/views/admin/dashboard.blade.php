<h1>Dashboard Admin</h1>

<p>Selamat datang, {{ auth()->user()->name }}</p>

<ul>
    <li>Kelola Karyawan</li>
    <li>Kelola Absensi</li>
</ul>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
