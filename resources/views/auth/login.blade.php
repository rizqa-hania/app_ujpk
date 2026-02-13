<h2>Login</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('login.post') }}" method="POST">
    @csrf

    <input type="text" name="email" placeholder="Email atau Username">
    <br><br>

    <input type="password" name="password" placeholder="Password">
    <br><br>

    <button type="submit">Masuk</button>
</form>

<br>
<a href="{{ route('forgot') }}">Forgot Password?</a>
<br>
<a href="{{ route('register') }}">Daftar Yuk?</a>
