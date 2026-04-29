<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      
      @auth
      @php
          // LOGIKA NOTIFIKASI KARYAWAN
          $userId = auth()->user()->id;
          
          // Hitung izin yang sudah direspon admin (disetujui/ditolak)
          $countIzin = \App\Izin::where('user_id', $userId)
                        ->whereIn('status', ['disetujui', 'ditolak'])
                        ->count();
          
          // Hitung lembur yang sudah direspon admin
          $countLembur = 0;
          $karyawanData = \App\Karyawan::where('user_id', $userId)->first();
          if($karyawanData){
              $countLembur = \App\Lembur::where('karyawan_id', $karyawanData->id)
                            ->whereIn('status', ['disetujui', 'ditolak'])
                            ->count();
          }
          
          $totalNotif = $countIzin + $countLembur;
      @endphp

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          @if($totalNotif > 0)
            <span class="badge badge-warning navbar-badge">{{ $totalNotif }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ $totalNotif }} Pemberitahuan Status</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('absensi.index') }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> {{ $countIzin }} Izin direspon
          </a>
          <div class="dropdown-divider"></div>
          <a href="{{ route('absensi.index') }}" class="dropdown-item">
            <i class="fas fa-clock mr-2"></i> {{ $countLembur }} Lembur direspon
          </a>
        </div>
      </li>

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

        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ route('logout') }}" class="dropdown-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
      </li>
      @endauth
    </ul>
</nav>