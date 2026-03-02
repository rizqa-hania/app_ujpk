ASTI RIANTI, 1 min
navbar

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- User Dropdown Menu -->
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user mr-1"></i> 
          @if(isset($karyawan))
            @if(is_object($karyawan) && $karyawan instanceof \App\Karyawan)
              {{ $karyawan->nama_lengkap ?? auth()->user()->name }}
            @elseif(is_array($karyawan) && count($karyawan) > 0)
              {{ $karyawan[0]->nama_lengkap ?? auth()->user()->name }}
            @else
              {{ auth()->user()->name }}
            @endif
          @else
            {{ auth()->user()->name }}
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">User Menu</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('karyawan.profile') }}" class="dropdown-item">
            <i class="fas fa-user-edit mr-2"></i> Profil Saya
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('karyawan.dashboard') }}" class="dropdown-item">
            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
          </a>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left; cursor: pointer;">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
          </form>
        </div>
      </li>
      @endauth

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
