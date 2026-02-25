<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
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
                <a href="#" class="d-block">{{ auth()->user()->name ?? 'Admin' }}</a>
                <small class="text-success">Admin</small>
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
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Karyawan -->
                <li class="nav-item has-treeview {{ request()->is('karyawan*') || request()->is('admin/karyawan*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->is('karyawan*') || request()->is('admin/karyawan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Karyawan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.karyawan.index') }}"
                               class="nav-link {{ request()->routeIs('admin.karyawan.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('karyawan.form') }}"
                               class="nav-link {{ request()->routeIs('karyawan.form') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Karyawan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Absensi -->
                <li class="nav-item has-treeview {{ request()->is('absensi*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->is('absensi*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
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

                <!-- Lembur -->
                <li class="nav-item">
                    <a href="{{ route('lembur.index') }}"
                       class="nav-link {{ request()->routeIs('lembur.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-overtime"></i>
                        <p>Lembur</p>
                    </a>
                </li>

                <!-- Penggajian -->
                <li class="nav-item has-treeview {{ request()->is('penggajian*') || request()->is('komponen*') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->is('penggajian*') || request()->is('komponen*') ? 'active' : '' }}">
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

                <!-- Master Data -->
                <li class="nav-header">MASTER DATA</li>

                <li class="nav-item">
                    <a href="{{ route('master_jabatan.index') }}"
                       class="nav-link {{ request()->routeIs('master_jabatan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Jabatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('master_unit_pln.index') }}"
                       class="nav-link {{ request()->routeIs('master_unit_pln.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Unit PLN</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('master-sub-unit.index') }}"
                       class="nav-link {{ request()->routeIs('master-sub-unit.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>Sub Unit</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('master_project.index') }}"
                       class="nav-link {{ request()->routeIs('master_project.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>Project</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('master_pendidikan.index') }}"
                       class="nav-link {{ request()->routeIs('master_pendidikan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>Pendidikan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('master_tad.index') }}"
                       class="nav-link {{ request()->routeIs('master_tad.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>TAD</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('master-kerja-sama.index') }}"
                       class="nav-link {{ request()->routeIs('master-kerja-sama.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>Kerja Sama</p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-header">PENGATURAN</li>

                <li class="nav-item">
                    <a href="{{ route('admin.index') }}"
                       class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Kelola Admin</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kantor.index') }}"
                       class="nav-link {{ request()->routeIs('kantor.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Kantor</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
