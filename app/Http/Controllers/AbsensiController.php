<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    private $jamMasuk  = "08:00:00";
    private $jamPulang = "16:30:00";

    public function index()
    {
        $userId = Auth::id();

        $dataAbsensi = Absensi::where('user_id', $userId)
                        ->orderBy('tanggal','desc')
                        ->get();

        return view('absensi.index', compact('dataAbsensi'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $today  = Carbon::today()->toDateString();
        $now    = Carbon::now();

        $absen = Absensi::where('user_id', $userId)
                        ->where('tanggal', $today)
                        ->first();

        /*
        =========================
        ABSEN MASUK
        =========================
        */
        if (!$absen && $request->type == 'masuk') {

            $batasMasuk = Carbon::parse($today . ' ' . $this->jamMasuk);

            $status = $now->gt($batasMasuk)
                ? 'terlambat dan tidak lengkap'
                : 'tidak lengkap';

            Absensi::create([
                'user_id'   => $userId,
                'tanggal'   => $today,
                'jam_masuk' => $now->format('H:i:s'),
                'status'    => $status,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude
            ]);

            return back()->with('success','Absen masuk berhasil');
        }

        /*
        =========================
        ABSEN PULANG
        =========================
        */
        if ($absen && !$absen->jam_pulang && $request->type == 'pulang') {

            $batasPulang = Carbon::parse($today . ' ' . $this->jamPulang);

            if ($now->lt($batasPulang)) {
                return back()->with('error','Belum waktunya pulang (16:30)');
            }

            $absen->jam_pulang = $now->format('H:i:s');

            if ($absen->status == 'terlambat dan tidak lengkap') {
                $absen->status = 'terlambat';
            } else {
                $absen->status = 'lengkap';
            }

            $absen->save();

            return back()->with('success','Absen pulang berhasil');
        }

<<<<<<< HEAD
        return back()->with('error','Sudah absen hari ini');
=======
        return back()->with('error','Anda sudah absen hari ini');
>>>>>>> 07fa4a68287fe23b0bce3eae5de9f33f4370a983
    }
}