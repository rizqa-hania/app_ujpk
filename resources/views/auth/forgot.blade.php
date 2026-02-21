<form action="{{ route('forgot.password') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Kirim Link Reset Password</button>
</form>
//