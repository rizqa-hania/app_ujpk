<aside class="main-sidebar sidebar-light-primary elevation-4">

<div class="sidebar">

<!-- User Panel -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{ asset('images/logo.png') }}"
             class="img-circle elevation-2"
             style="width:40px; height:40px; object-fit:contain;"
             alt="Logo User">
    </div>
<!-- -->
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

<!-- Search -->
<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar"
               type="search"
               placeholder="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
<<<<<<< HEAD

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
                            <a href="{{ route('komponen.index') }}"
                               class="nav-link {{ request()->routeIs('komponen.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Komponen</p>
                            </a>
                        </li>
</ul>

                            
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

                            <li class="nav-item">
                    <a href="{{ route('tambah.index') }}"
                       class="nav-link {{ request()->routeIs('tambah.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Tambah Karyawan</p>
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
                                        
                                        <p>
                                            Penggajian
                                        </p>
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

=======
>>>>>>> 8ca321676d0a8e70ae257be7da7625fa6a7f3705
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column"
    data-widget="treeview"
    role="menu"
    data-accordion="false">

@auth

{{-- =========================
KARYAWAN
========================= --}}
@if(auth()->user()->role == 'karyawan')

<li class="nav-item">
    <a href="{{ route('absensi.index') }}"
       class="nav-link {{ request()->routeIs('absensi.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clock"></i>
        <p>Absensi</p>
    </a>
</li>

<li class="nav-item has-treeview {{ request()->is('penggajian*') ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link {{ request()->is('penggajian*') ? 'active' : '' }}">
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

    </ul>
</li>


{{-- =========================
ADMIN
========================= --}}
@else

<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard Admin</p>
    </a>
</li>

{{-- tambah data user --}}

<li class="nav-item has-treeview 
{{ request()->is('*') || request()->is('pendidikan*') ? 'menu-open' : '' }}">

<a href="#"
class="nav-link 
{{ request()->is('jabatan*') || request()->is('pendidikan*') ? 'active' : '' }}">

<i class="nav-icon fas fa-user-plus"></i>


<p>
Tambah User
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

<li class="nav-item">
    <a href="{{ route('admin.index') }}"
       class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Tambah Admin</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('karyawan.tambah.index') }}"
       class="nav-link {{ request()->routeIs('karyawan.tambah.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Tambah Karyawan</p>
    </a>
</li>


</ul>
</li>






{{-- tambah data master --}}

<li class="nav-item has-treeview 
{{ request()->is('jabatan*') || request()->is('pendidikan*') ? 'menu-open' : '' }}">

<a href="#"
class="nav-link 
{{ request()->is('jabatan*') || request()->is('pendidikan*') ? 'active' : '' }}">

<i class="nav-icon fas fa-archive"></i>


<p>
Tambah Data Master
<i class="right fas fa-angle-left"></i>
</p>

</a>

<ul class="nav nav-treeview">

<li class="nav-item">
<a href="{{ route('master_jabatan.create') }}"
class="nav-link {{ request()->routeIs('master_jabatan.create') ? 'active' : '' }}">

<i class="nav-icon fas fa-briefcase"></i>
<p>Jabatan</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_pendidikan.create') }}"
class="nav-link {{ request()->routeIs('master_pendidikan.create') ? 'active' : '' }}">

<i class="nav-icon fas fa-graduation-cap"></i>
<p>Pendidikan</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_project.create') }}"
class="nav-link {{ request()->routeIs('master_project.create') ? 'active' : '' }}">

<i class="nav-icon fas fa-folder-open"></i>
<p>Project</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_unit_pln.create') }}"
class="nav-link {{ request()->routeIs('master_unit_pln.create') ? 'active' : '' }}">

<i class="nav-icon fas fa-building"></i>
<p>Master Unit</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master-sub-unit.create') }}"
class="nav-link {{ request()->routeIs('master-sub-unit.create') ? 'active' : '' }}">

<i class="nav-icon fas fa-layer-group"></i>
<p>Master Sub Unit</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_tad.create') }}"
class="nav-link {{ request()->routeIs('master_tad.create') ? 'active' : '' }}">

<i class="nav-icon fas fa-user-friends"></i>
<p>TAD</p>

</a>
</li>

</ul>
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

<i class="nav-icon fas fa-clock"></i></i>
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

<i class="nav-icon fas fa-money-bill-wave"></i></i>
<p>Penggajian</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('komponen.index') }}"
class="nav-link {{ request()->routeIs('komponen.index') ? 'active' : '' }}">

<i class="nav-icon fas fa-coins"></i></i>
<p>Komponen Gaji</p>

</a>
</li>

</ul>
</li>

@endif
@endauth

</ul>
</nav>

</div>
</aside>