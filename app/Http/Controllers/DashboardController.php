<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
use App\MasterTad;
use App\MasterPendidikan;
use App\Jabatan;
use App\MasterProject;
use App\MasterSubUnit;
use App\MasterUnitPln;
use App\Lembur;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSubUnit = MasterSubUnit::count();
        $totalUnitPln = MasterUnitPln::count();
        $totalTad = MasterTad::count();
        $totalProject = MasterProject::count();
        $totalPendidikan = MasterPendidikan::count();
        $totalJabatan = Jabatan::count();
        $totalLembur = Lembur::count();
<<<<<<< HEAD
        $totalKaryawan = Karyawan::count();
=======
        $totalIzin = Izin::count();
        $totalAbsensi = Absensi::count();

>>>>>>> 9174a675930ff5f58d61fd3c86844b8e5167b4ee

        return view('dashboard', compact(
            'totalTad',
            'totalSubUnit',
            'totalUnitPln',
            'totalProject',
            'totalPendidikan',
            'totalJabatan',
            'totalLembur',
<<<<<<< HEAD
            'totalKaryawan'));
=======
            'totalizin',
            'totalabsensi'));
>>>>>>> 9174a675930ff5f58d61fd3c86844b8e5167b4ee

    }

    
}