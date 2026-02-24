<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    //private $officeLat = -6.200000; // GANTI dengan koordinat kantor
    //private $officeLng = 106.816666; // GANTI dengan koordinat kantor
    //private $radius = 100; // meter
    private $jamMasuk = "08:00:00";
    private $jamPulang = "16:30:00";

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
{
    $userId = Auth::id();

    $dataAbsensi = Absensi::where('user_id', $userId)
                    ->orderBy('tanggal','desc')
                    ->get();

    return view('absensi.index', compact('dataAbsensi'));
}

    private function distance($lat1,$lon1,$lat2,$lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2-$lat1);
        $dLon = deg2rad($lon2-$lon1);

        $a = sin($dLat/2)*sin($dLat/2) +
             cos(deg2rad($lat1))*cos(deg2rad($lat2))*
             sin($dLon/2)*sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    public function store(Request $request)
{
    if(!Auth::check()){
        return redirect()->route('login');
    }

    $userId = Auth::id();
    $today = Carbon::today()->toDateString();
    $now = Carbon::now();

    $lat = $request->latitude;
    $lng = $request->longitude;

    $absen = Absensi::where('user_id',$userId)
                ->where('tanggal',$today)
                ->first();

    // ======================
    // ABSEN MASUK
    // ======================
    if(!$absen){

        $batasMasuk = Carbon::createFromFormat('H:i:s', $this->jamMasuk);

        $status = $now->gt($batasMasuk) ? 'terlambat' : 'hadir';

        Absensi::create([
            'user_id'=>$userId,
            'tanggal'=>$today,
            'jam_masuk'=>$now->format('H:i:s'),
            'status_masuk'=>$status,
            'latitude'=>$lat,
            'longitude'=>$lng
        ]);

        return back()->with('success','Absen masuk berhasil');
    }

    // ======================
    // ABSEN PULANG
    // ======================
    if($absen && !$absen->jam_pulang){

        $batasPulang = Carbon::createFromFormat('H:i:s', $this->jamPulang);

        if($now->lt($batasPulang)){
            return back()->with('error','Belum waktunya pulang (16:30)');
        }

        $absen->update([
            'jam_pulang'=>$now->format('H:i:s'),
            'status_pulang'=>'pulang'
        ]);

        return redirect()->route('absensi.index')
            ->with('success','Absen pulang berhasil');
    }

    return back()->with('error','Anda sudah absen hari ini');
}
}