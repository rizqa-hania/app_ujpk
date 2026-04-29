@extends('template.admin.layout')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header">
                <h3 class="card-title font-weight-bold mb-0">
                    Tambah Karyawan
                </h3>
            </div>

            <!-- Form -->
            <form action="{{ route('karyawan.tambah.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <!-- Nama -->
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Nama
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Masukkan nama karyawan">

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            NIP
                        </label>
                        <input type="text"
                               name="nip"
                               class="form-control @error('nip') is-invalid @enderror"
                               value="{{ old('nip') }}"
                               placeholder="Masukkan NIP">

                        @error('nip')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                     <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Email
                        </label>
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="Masukkan Email">

                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">
                            Password
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Masukkan password">

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('karyawan.tambah.index') }}" 
                       class="btn btn-secondary btn-sm mr-2">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>
    
</div>

@endsection