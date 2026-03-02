<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('images/logo.png') }}" 
             class="img-circle elevation-2"
             style="width:40px; height:40px; object-fit:contain;" 
             alt="Logo User">
    </div>
    <style>
        .sidebar .user-panel .info a {
    white-space: normal; /* biar wrap ke baris berikut */
    overflow-wrap: break-word;
    }

    .main-sidebar {
    width: 250px; /* default AdminLTE 250px */
}
    </style>
    <div class="info">
        <a href="#" class="d-block">PT Usaha Jaya Prima Karya</a>
    </div>
</div>


        <!-- Sidebar Search -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar"
                       type="search"
                       placeholder="Search"
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                {{-- KARYAWAN MENU --}}
                @auth
                    @if(auth()->user()->role == 'karyawan')
                        <li class="nav-item">
                            <a href="{{ route('karyawan.dashboard') }}"
                               class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard </p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('karyawan.profile') }}"
                               class="nav-link {{ request()->routeIs('karyawan.profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Profil Saya
                                    
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('absensi.index') }}"
                               class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Absensi</p>

                {{-- ADMIN --}}
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}"
                       class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Tambah Admin</p>
                    </a>
                </li>

                {{-- ABSENSI --}}
                <li class="nav-item has-treeview {{ request()->is('absensi*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->is('absensi*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-camera"></i>
                        <p>
                            Absensi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('absensi.index') }}"
                               class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Absensi Karyawan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- PENGGAJIAN --}}
                <li class="nav-item has-treeview 
                    {{ request()->is('penggajian*') || request()->is('komponen*') ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link 
                       {{ request()->is('penggajian*') || request()->is('komponen*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Penggajian
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penggajian.index') }}"
                               class="nav-link {{ request()->routeIs('penggajian.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penggajian</p>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('lembur.index') }}"
                               class="nav-link {{ request()->routeIs('lembur.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-overtime"></i>
                                <p>Lembur</p>
                            </a>
                        </li>
                    @else
                        {{-- ADMIN MENU --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}"
                               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.index') }}"
                               class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Tambah Admin</p>
                            </a>
                        </li>

                       {{-- ABSENSI --}}
                            <li class="nav-item has-treeview 
                                {{ request()->is('absensi*') || request()->is('jadwal*') ? 'menu-open' : '' }}">

                                <a href="#"
                                class="nav-link 
                                {{ request()->is('absensi*') || request()->is('jadwal*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-camera"></i>
                                    <p>
                                        Absensi
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="{{ route('absensi.index') }}"
                                        class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Absensi Karyawan</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('jadwal.index') }}"
                                        class="nav-link {{ request()->routeIs('jadwal.index') ? 'active' : '' }}">
                                            <i class="far fa-calendar-alt nav-icon"></i>
                                            <p>Jadwal Absensi</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        {{-- PENGGAJIAN --}}
                        <li class="nav-item has-treeview 
                            {{ request()->is('penggajian*') || request()->is('komponen*') ? 'menu-open' : '' }}">

                            <a href="#"
                               class="nav-link 
                               {{ request()->is('penggajian*') || request()->is('komponen*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-bill-wave"></i>
                                <p>
                                    Penggajian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('penggajian.index') }}"
                                       class="nav-link {{ request()->routeIs('penggajian.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penggajian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('komponen.index') }}"
                                       class="nav-link {{ request()->routeIs('komponen.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Komponen Gaji</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>