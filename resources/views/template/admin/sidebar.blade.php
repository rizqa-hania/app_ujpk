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
{{ request()->routeIs('admin.index') || request()->routeIs('karyawan.tambah.index') ? 'menu-open' : '' }}">
    <a href="#"
       class="nav-link 
       {{ request()->routeIs('admin.index') || request()->routeIs('karyawan.tambah.index') ? 'active' : '' }}">
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

<<<<<<< HEAD
                    <a href="#"
                       class="nav-link 
                       {{ request()->is('penggajian*') || request()->is('komponen*') ? 'active' : '' }}">
                        <p>
                            Penggajian
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penggajian.index') }}"
                               class="nav-link {{ request()->routeIs('penggajian.index') ? 'active' : '' }}">
                                <p>Penggajian</p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('komponen.index') }}"
                               class="nav-link {{ request()->routeIs('komponen.index') ? 'active' : '' }}">
                                
                                <p>Komponen</p>
                            </a>
                        </li>
=======

>>>>>>> 1d77f844fed00ef16c6702469cdf2c1ba33f6e34
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
<a href="{{ route('master_jabatan.index') }}"
class="nav-link {{ request()->routeIs('master_jabatan.index') ? 'active' : '' }}">

<i class="nav-icon fas fa-briefcase"></i>
<p>Jabatan</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_pendidikan.index') }}"
class="nav-link {{ request()->routeIs('master_pendidikan.index') ? 'active' : '' }}">

<i class="nav-icon fas fa-graduation-cap"></i>
<p>Pendidikan</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_project.index') }}"
class="nav-link {{ request()->routeIs('master_project.index') ? 'active' : '' }}">

<i class="nav-icon fas fa-folder-open"></i>
<p>Project</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_unit_pln.index') }}"
class="nav-link {{ request()->routeIs('master_unit_pln.index') ? 'active' : '' }}">

<i class="nav-icon fas fa-building"></i>
<p>Master Unit</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master-sub-unit.index') }}"
class="nav-link {{ request()->routeIs('master-sub-unit.index') ? 'active' : '' }}">

<i class="nav-icon fas fa-layer-group"></i>
<p>Master Sub Unit</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('master_tad.index') }}"
class="nav-link {{ request()->routeIs('master_tad.index') ? 'active' : '' }}">

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
                                    <a href="{{ route('admin.absensi.monitoring') }}"
                                       class="nav-link {{ request()->routeIs('admin.absensi.monitoring') ? 'active' : '' }}">
                                        <i class="fas fa-laptop nav-icon"></i> {{-- text-primary dihapus agar jadi abu --}}
                                        <p>Monitoring Absensi</p>
                                    </a>
                                </li>

<li class="nav-item">
<a href="{{ route('jadwal.index') }}"
class="nav-link {{ request()->routeIs('jadwal.index') ? 'active' : '' }}">

<i class="far fa-calendar-alt nav-icon"></i>
<p>Jadwal Absensi</p>

</a>
</li>

<li class="nav-item">
<a href="{{ route('kantor.index') }}"
class="nav-link {{ request()->routeIs('kantor.index') ? 'active' : '' }}">

<i class="far fa-building nav-icon"></i>
<p>Tambah Kantor</p>

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
<p>Periode Penggajian</p>

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

{{-- Laporan --}}
<li class="nav-item has-treeview {{ request()->routeIs('admin.absensi.monitoring') || request()->is('absensi/rekap*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('admin.absensi.monitoring') || request()->is('absensi/rekap*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>
            Laporan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{ route('absensi.rekap') }}"
               class="nav-link {{ request()->routeIs('absensi.rekap') ? 'active' : '' }}">
                <i class="nav-icon fas fa-clipboard-check"></i>
                <p>Rekap Absensi</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('penggajian.index') }}"
               class="nav-link">
                <i class="nav-icon fas fa-wallet"></i>
                <p>Slip Gaji</p>
            </a>
        </li>
    </ul>
</li>


</ul>
</li>


@endif
@endauth

</ul>
</nav>

</div>
</aside>