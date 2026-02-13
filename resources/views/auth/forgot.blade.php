<h2>Forgot Password</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('forgot.post') }}" method="POST">
    @csrf

    <input type="email" name="email" placeholder="Masukkan Email">
    <br><br>

    <button type="submit">Kirim Link Reset</button>
</form>

<a href="{{ route('login') }}">Kembali ke Login</a>
