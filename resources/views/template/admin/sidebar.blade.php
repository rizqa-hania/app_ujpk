<aside class="main-sidebar sidebar-light-primary elevation-4">
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/logo.png') }}"
                     class="img-circle elevation-2"
                     style="width:40px; height:40px; object-fit:contain;"
                     alt="Logo User">
            </div>
            <div class="info">
                <a href="#" class="d-block">PT Usaha Jaya Prima Karya</a>
            </div>
        </div>

        <style>
        .sidebar .user-panel .info a{
            white-space: normal;
            overflow-wrap: break-word;
        }
        .main-sidebar{
            width:250px;
        }
        </style>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @auth
                {{-- LOGIKA HITUNG NOTIFIKASI --}}
                @php
                    $userId = auth()->user()->id;
                    $userRole = auth()->user()->role;

                    $countIzinSidebar = \App\Izin::where(function($q) use ($userId, $userRole) {
                        if($userRole == 'karyawan') {
                            $q->where('user_id', $userId)->whereIn('status', ['disetujui', 'ditolak']);
                        } else {
                            $q->where('status', 'menunggu');
                        }
                    })->count();

                    $countLemburSidebar = 0;
                    if($userRole == 'karyawan') {
                        $karyawanData = \App\Karyawan::where('user_id', $userId)->first();
                        if($karyawanData) {
                            $countLemburSidebar = \App\Lembur::where('karyawan_id', $karyawanData->id)->whereIn('status', ['disetujui', 'ditolak'])->count();
                        }
                    } else {
                        $countLemburSidebar = \App\Lembur::where('status', 'menunggu')->count();
                    }
                    
                    $totalNotifSidebar = $countIzinSidebar + $countLemburSidebar;
                @endphp

                @if($userRole == 'karyawan')
                    {{-- Bagian Karyawan --}}
                    <li class="nav-item">
                        <a href="{{ route('absensi.index') }}"
                           class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>
                                Absensi
                                @if($totalNotifSidebar > 0)
                                    <span class="right badge badge-warning">{{ $totalNotifSidebar }}</span>
                                @endif
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('absensi.rekap') }}"
                           class="nav-link {{ request()->routeIs('absensi.rekap') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>Rekap Absensi</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('penggajian*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('penggajian*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Penggajian <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('penggajian.index') }}"
                                   class="nav-link {{ request()->routeIs('penggajian.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penggajian</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                @else
                    {{-- Bagian Admin --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Halaman Admin</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('admin*') || request()->is('karyawan/tambah*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('admin*') || request()->is('karyawan/tambah*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Tambah Pengguna <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>Tambah Admin</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('karyawan.tambah.index') }}" class="nav-link {{ request()->routeIs('karyawan.tambah.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Tambah Karyawan</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('jabatan*') || request()->is('pendidikan*') || request()->is('project*') || request()->is('unit*') || request()->is('tad*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('jabatan*') || request()->is('pendidikan*') || request()->is('project*') || request()->is('unit*') || request()->is('tad*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>Data Master <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="{{ route('master_jabatan.index') }}" class="nav-link {{ request()->is('jabatan*') ? 'active' : '' }}"><i class="nav-icon fas fa-briefcase"></i><p>Jabatan</p></a></li>
                            <li class="nav-item"><a href="{{ route('master_pendidikan.index') }}" class="nav-link {{ request()->is('pendidikan*') ? 'active' : '' }}"><i class="nav-icon fas fa-graduation-cap"></i><p>Pendidikan</p></a></li>
                            <li class="nav-item"><a href="{{ route('master_project.index') }}" class="nav-link {{ request()->is('project*') ? 'active' : '' }}"><i class="nav-icon fas fa-folder-open"></i><p>Proyek</p></a></li>
                            <li class="nav-item"><a href="{{ route('master_unit_pln.index') }}" class="nav-link {{ request()->is('unit*') ? 'active' : '' }}"><i class="nav-icon fas fa-building"></i><p>Master Unit</p></a></li>
                            <li class="nav-item"><a href="{{ route('master-sub-unit.index') }}" class="nav-link {{ request()->is('sub-unit*') ? 'active' : '' }}"><i class="nav-icon fas fa-layer-group"></i><p>Master Sub Unit</p></a></li>
                            <li class="nav-item"><a href="{{ route('master_tad.index') }}" class="nav-link {{ request()->is('tad*') ? 'active' : '' }}"><i class="nav-icon fas fa-user-friends"></i><p>TAD</p></a></li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('absensi*') || request()->is('jadwal*') || request()->is('kantor*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('absensi*') || request()->is('jadwal*') || request()->is('kantor*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-camera"></i>
                            <p>
                                Absensi 
                                @if($totalNotifSidebar > 0)
                                    <span class="right badge badge-danger">{{ $totalNotifSidebar }}</span>
                                @else
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('absensi.monitoring') }}" class="nav-link {{ request()->routeIs('absensi.monitoring') ? 'active' : '' }}">
                                    <i class="fas fa-laptop nav-icon"></i>
                                    <p>Monitoring Absensi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->routeIs('jadwal.index') ? 'active' : '' }}">
                                    <i class="far fa-calendar-alt nav-icon"></i>
                                    <p>Jadwal Absensi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kantor.index') }}" class="nav-link {{ request()->routeIs('kantor.index') ? 'active' : '' }}">
                                    <i class="far fa-building nav-icon"></i>
                                    <p>Tambah Kantor</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->is('penggajian*') || request()->is('komponen*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('penggajian*') || request()->is('komponen*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>Penggajian <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('penggajian.index') }}" class="nav-link {{ request()->routeIs('penggajian.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-money-bill-wave"></i>
                                    <p>Periode Penggajian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('komponen.index') }}" class="nav-link {{ request()->routeIs('komponen.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-coins"></i>
                                    <p>Komponen Gaji</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('absensi.index') }}" class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>Rekap Absensi</p>
                        </a>
                    </li>
                @endif
                @endauth

            </ul>
        </nav>

    </div>
</aside>