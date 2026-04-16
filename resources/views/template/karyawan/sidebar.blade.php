<aside class="main-sidebar sidebar-light-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('karyawan.dashboard') }}" class="brand-link text-center">
        <img src="{{ asset('ujpkkkkkk.png') }}"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">PT UJPK</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ $karyawan->nama_panggilan ?? auth()->user()->name }}</a>
                <small class="text-info">Karyawan</small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('karyawan.dashboard') }}"
                       class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard Karyawan</p>
                    </a>
                </li>

                <!-- Profil -->
                <li class="nav-item">
                    <a href="{{ route('karyawan.profile') }}"
                       class="nav-link {{ request()->routeIs('karyawan.profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                <!-- Absensi -->
                <li class="nav-item">
                    <a href="{{ route('absensi.index') }}"
                       class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Absensi</p>
                    </a>
                </li>

                <!-- Lembur -->
                <li class="nav-item">
                    <a href="{{ route('lembur.create') }}"
                       class="nav-link {{ request()->routeIs('lembur.create') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-business-time"></i>
                        <p>Lembur</p>
                    </a>
                </li>

                  <li class="nav-item">
                    <a href="{{ route('izin.create') }}"
                       class="nav-link {{ request()->routeIs('izin.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>Izin</p>
                    </a>
                </li>


                 <li class="nav-item">
                    <a href="{{ route('penggajian.index') }}"
                       class="nav-link {{ request()->routeIs('izin.index') ? 'active' : '' }}">
                       <i class="nav-icon fas fa-wallet"></i>
                        <p>Slip Gaji</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
