<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Karyawan;
use App\MasterSubUnit;
use App\MasterUnitPln;
use App\MasterTad;
use App\MasterProject;
use App\MasterPendidikan;
use App\Jabatan;
use App\Lembur;
<<<<<<< HEAD
use App\Absensi;


=======
use App\Izin;
use App\Absensi;
>>>>>>> 9174a675930ff5f58d61fd3c86844b8e5167b4ee

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
<<<<<<< HEAD
        
        // Statistik terbaru
        $absensiHariIni = Absensi::whereDate('created_at', today())->count();
=======
        $totalIzin = Izin::count();
        $totalAbsensi = Absensi::count();
>>>>>>> 9174a675930ff5f58d61fd3c86844b8e5167b4ee

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
<<<<<<< HEAD
        'absensiHariIni',
        ));
=======
            'totalIzin',
            'totalAbsensi'));
>>>>>>> 9174a675930ff5f58d61fd3c86844b8e5167b4ee
    }
}
