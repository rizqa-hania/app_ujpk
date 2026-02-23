<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Karyawan</title>
</head>
<body>
    <h2>Halo {{ $user->name }}</h2>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <h3>Profil Kamu</h3>
    <p>Nama: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->role }}</p>
</body>
</html>