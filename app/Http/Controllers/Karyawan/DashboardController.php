<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Karyawan;
use App\Absensi;
use App\Izin;
use App\Lembur;
class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();
        $today = Carbon::today();
        // Load karyawan with relationships
        $karyawan = Karyawan::where('user_id', $user->user_id)
            ->with(['jabatan', 'unitpln', 'subunit', 'tad', 'project', 'pendidikan'])
            ->first();

$isPensiun = false;
$umur = null;

if ($karyawan && $karyawan->tanggal_lahir) {

    // kalau format kamu dd-mm-yyyy, pakai ini
   $tanggalLahir = Carbon::parse($karyawan->tanggal_lahir);
    $umur = $tanggalLahir->age;

    // kalau sudah 55
    if ($umur >= 55) {
        $isPensiun = true;
    }
}
$isMyBirthday = false;
$namaKaryawan = '';

// CEK DIRI SENDIRI
if ($karyawan && $karyawan->tanggal_lahir) {
    $tglSaya = Carbon::parse($karyawan->tanggal_lahir);

    if ($tglSaya->format('m-d') == $today->format('m-d')) {
        $isMyBirthday = true;
        $namaKaryawan = $karyawan->nama_lengkap;
    }
}

// AMBIL SEMUA YANG ULTAH HARI INI
$ulangTahunHariIni = Karyawan::all()->filter(function ($k) use ($today) {
    if (!$k->tanggal_lahir) return false;

    $tgl = Carbon::parse($k->tanggal_lahir);
    return $tgl->format('m-d') == $today->format('m-d');
});

// FILTER SELAIN DIRI SENDIRI
$ulangTahunSelainSaya = collect();

if ($karyawan) {
    $ulangTahunSelainSaya = $ulangTahunHariIni->filter(function ($k) use ($karyawan) {
        return $k->id != $karyawan->id;
    });
}

        $totalAbsensi = Absensi::where('karyawan_id', auth()->id())->count();
        $totalIzin = Izin::where('karyawan_id', auth()->id())->count();
        $totalLembur = Lembur::where('karyawan_id', auth()->id())->count();
        $ucapan = DB::table('ucapan')
        ->where('karyawan_id', auth()->user()->id)
        ->get();
        return view('dashboard.karyawan.dashboard', compact('karyawan', 'user','totalAbsensi','totalIzin','totalLembur','ucapan','isPensiun','umur', 'isMyBirthday' ,'ulangTahunSelainSaya',
    
        'namaKaryawan','ulangTahunHariIni'));
         }
}
