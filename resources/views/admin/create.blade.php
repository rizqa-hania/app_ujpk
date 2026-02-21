
<div class="container">
    <h2>Tambah Admin</h2>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password">
            @error('password') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation">
        </div>
        <button type="submit">Tambah Admin</button>
    </form>
</div>
