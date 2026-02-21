<form action="{{ route('reset.password') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password baru" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi password" required>
    <button type="submit">Reset Password</button>
</form>