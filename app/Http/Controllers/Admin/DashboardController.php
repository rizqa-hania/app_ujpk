<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\MasterSubUnit;
use App\MasterUnitPln;
use App\MasterTad;
use App\MasterProject;
use App\MasterPendidikan;
use App\Jabatan;
use App\Lembur;

class DashboardController extends Controller {

    public function index() {
        // Data karyawan
        $karyawans = User::where('role','karyawan')->get();

        // Statistik master
        $totalSubUnit = MasterSubUnit::count();
        $totalUnitPln = MasterUnitPln::count();
        $totalTad = MasterTad::count();
        $totalProject = MasterProject::count();
        $totalPendidikan = MasterPendidikan::count();
        $totalJabatan = Jabatan::count();
        $totalLembur = Lembur::count();

        return view('dashboard.admin.dashboard', compact(
            'karyawans',
            'totalTad',
            'totalSubUnit',
            'totalUnitPln',
            'totalProject',
            'totalPendidikan',
            'totalJabatan',
            'totalLembur'
        ));
    }
}