@extends('template.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <h5 class="mb-0 font-weight-bold">Tambah Admin</h5>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               required>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label class="form-label">Role</label><br>

                        <input type="radio" 
                               class="btn-check" 
                               name="role" 
                               id="admin" 
                               value="admin" 
                               checked>

                        <label class="btn btn-outline-danger btn-sm" for="admin">
                            Admin
                        </label>
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.index') }}" 
                       class="btn btn-secondary btn-sm">
                        Kembali
                    </a>

                    <button type="submit" 
                            class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection