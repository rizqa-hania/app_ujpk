<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Karyawan;
use App\MasterSubUnit;
use App\MasterUnitPln;
use App\MasterTad;
use App\MasterProject;
use App\MasterPendidikan;
use App\Jabatan;
use App\Lembur;
use App\Absensi;
use App\Izin;

class DashboardController extends Controller {

    public function index() {
        // Data karyawan dengan relasi lengkap
        $karyawans = User::where('role','karyawan')
            ->with(['karyawan' => function($q) {
                $q->with(['jabatan', 'unitpln', 'subunit', 'tad', 'project', 'pendidikan']);
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik
        $totalKaryawan = User::where('role','karyawan')->count();
        $totalSubUnit = MasterSubUnit::count();
        $totalUnitPln = MasterUnitPln::count();
        $totalTad = MasterTad::count();
        $totalProject = MasterProject::count();
        $totalPendidikan = MasterPendidikan::count();
        $totalJabatan = Jabatan::count();
        $totalLembur = Lembur::count();
        $today = Carbon::today();
        $ulangTahunHariIni = Karyawan::whereMonth('tanggal_lahir', $today->month)
            ->whereDay('tanggal_lahir', $today->day)
            ->get();
        $karyawanList = Karyawan::all();
        $pensiun = [];
        foreach ($karyawanList as $k) {
            $umur = Carbon::parse($k->tanggal_lahir)->age;
            if ($umur >= 55) {
                $pensiun[] = $k; }}
                
        // Statistik terbaru
        $absensiHariIni = Absensi::whereDate('created_at', today())->count();

        $totalIzin = Izin::count();
        $totalAbsensi = Absensi::count();

        return view('dashboard.admin.dashboard', compact(
            'karyawans',
            'totalKaryawan',
            'totalTad',
            'totalSubUnit',
            'totalUnitPln',
            'totalProject',
            'totalPendidikan',
            'totalJabatan',
            'totalLembur',
        'absensiHariIni',
            'totalIzin',
            'totalAbsensi',
            'ulangTahunHariIni',
            'pensiun'));
    }
    
    
}
