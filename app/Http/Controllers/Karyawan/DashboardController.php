<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Karyawan;

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
    $tanggalLahir = Carbon::createFromFormat('d-m-Y', $karyawan->tanggal_lahir);

    $umur = $tanggalLahir->age;

    // kalau sudah 55
    if ($umur >= 55) {
        $isPensiun = true;
    }
}
        $ulangTahunHariIni = Karyawan::whereMonth('tanggal_lahir', $today->month)
        ->whereDay('tanggal_lahir', $today->day)
        ->get();
        $totalAbsensi = Absensi::where('karyawan_id', auth()->id())->count();
        $totalIzin = Izin::where('karyawan_id', auth()->id())->count();
        $totalLembur = Lembur::where('karyawan_id', auth()->id())->count();
        $ucapan = DB::table('ucapan')
        ->where('karyawan_id', auth()->user()->id)
        ->get();
      
        
        return view('dashboard.karyawan.dashboard', compact('karyawan', 'user','ulangTahunHariIni','totalAbsensi','totalIzin','totalLembur','ucapan','isPensiun','umur'));
         }
}
