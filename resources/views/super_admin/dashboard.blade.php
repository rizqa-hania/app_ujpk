<h1>Dashboard Super Admin</h1>

<p>Selamat datang, {{ auth()->user()->name }}</p>

<ul>
    <li>Kelola Admin</li>
    <li>Kelola Semua Data</li>
    <li>Lihat Statistik Sistem</li>
</ul>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
