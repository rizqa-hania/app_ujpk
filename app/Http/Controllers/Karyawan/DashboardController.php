<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Karyawan;

class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();
        $today = Carbon::today();
        $ulangTahunHariIni = Karyawan::whereMonth('tanggal_lahir', $today->month)
        ->whereDay('tanggal_lahir', $today->day)
        ->get();
        $totalAbsensi = Absensi::where('karyawan_id', auth()->id())->count();
        $totalIzin = Izin::where('karyawan_id', auth()->id())->count();
        $totalLembur = Lembur::where('karyawan_id', auth()->id())->count();

        
        // Load karyawan with relationships
        $karyawan = Karyawan::where('user_id', $user->user_id)
            ->with(['jabatan', 'unitpln', 'subunit', 'tad', 'project', 'pendidikan'])
            ->first();
        
        return view('dashboard.karyawan.dashboard', compact('karyawan', 'user','ulangTahunHariIni','totalAbsensi','totalIzin','totalLembur'));
         }
}
