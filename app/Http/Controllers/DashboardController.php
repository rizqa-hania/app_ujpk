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


        return view('dashboard', compact(
            'totalTad',
            'totalSubUnit',
            'totalUnitPln',
            'totalProject',
            'totalPendidikan',
            'totalJabatan',
            'totalLembur'));

    }

    
}