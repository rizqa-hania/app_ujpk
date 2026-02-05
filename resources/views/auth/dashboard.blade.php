<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">
@if (session('success'))
<div class="alert alert-success" role="alert">
{{ session('success') }}
</div>
@endif
<h3>Selamat datang, {{ Auth::user()->name }}</h3>
<p>Anda berhasil login.</p>
</div>
<div class="card-footer">
<a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
</div>
</div>
</div>
</div>