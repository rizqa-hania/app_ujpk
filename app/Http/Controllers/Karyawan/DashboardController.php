<?php
namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Karyawan;

class DashboardController extends Controller {
    public function index() {
        $user = Auth::user();
        
        // Load karyawan with relationships
        $karyawan = Karyawan::where('user_id', $user->user_id)
            ->with(['jabatan', 'unitpln', 'subunit', 'tad', 'project', 'pendidikan'])
            ->first();
        
        return view('dashboard.karyawan.dashboard', compact('karyawan', 'user'));
    }
}
