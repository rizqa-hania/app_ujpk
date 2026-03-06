<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Absensi;
use App\JadwalAbsensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $dataAbsensi = Absensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absensi.index', compact('dataAbsensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang'
        ]);

        $userId = Auth::id();
        $now    = Carbon::now();
        $today  = $now->toDateString();

        /*
        =========================================
        CEK APAKAH HARI INI STATUS IZIN
        =========================================
        */

        $cekIzin = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->whereIn('status_final', ['izin','cuti','sakit'])
            ->first();

        if ($cekIzin) {
            return back()->with('error', 'Hari ini Anda sedang '.$cekIzin->status_final);
        }

        $jadwal = JadwalAbsensi::first();

        if (!$jadwal) {
            return back()->with('error', 'Jadwal belum disetting');
        }

        $mapHari = [
            'monday'    => 'senin',
            'tuesday'   => 'selasa',
            'wednesday' => 'rabu',
            'thursday'  => 'kamis',
            'friday'    => 'jumat',
            'saturday'  => 'sabtu',
            'sunday'    => 'minggu',
        ];

        $hariInggris = strtolower($now->format('l'));

        if (!isset($mapHari[$hariInggris])) {
            return back()->with('error', 'Format hari tidak dikenali');
        }

        $hari = $mapHari[$hariInggris];

        if (!$jadwal->$hari) {
            return back()->with('error', 'Hari ini bukan hari kerja');
        }

        $jamMasuk  = $jadwal->{'jam_masuk_' . $hari};
        $jamPulang = $jadwal->{'jam_pulang_' . $hari};

        if (!$jamMasuk || !$jamPulang) {
            return back()->with('error', 'Jam kerja belum disetting');
        }

        $batasMasuk  = Carbon::parse($today . ' ' . $jamMasuk);
        $batasPulang = Carbon::parse($today . ' ' . $jamPulang);

        $absen = Absensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        /*
        =========================================
        ABSEN MASUK
        =========================================
        */
        if (!$absen && $request->type == 'masuk') {

            $statusMasuk = $now->gt($batasMasuk)
                ? 'terlambat'
                : 'tepat waktu';

            Absensi::create([
                'user_id'      => $userId,
                'tanggal'      => $today,
                'jam_masuk'    => $now->format('H:i:s'),
                'status_masuk' => $statusMasuk,
                'status_final' => 'belum lengkap'
            ]);

            return back()->with('success', 'Absen masuk berhasil');
        }

        /*
        =========================================
        ABSEN PULANG
        =========================================
        */
        if ($absen && !$absen->jam_pulang && $request->type == 'pulang') {

            $statusPulang = $now->lt($batasPulang)
                ? 'pulang cepat'
                : 'tepat waktu';

            $absen->jam_pulang    = $now->format('H:i:s');
            $absen->status_pulang = $statusPulang;

            $final = [];

            if ($absen->status_masuk == 'terlambat') {
                $final[] = 'terlambat';
            }

            if ($statusPulang == 'pulang cepat') {
                $final[] = 'pulang cepat';
            }

            if (empty($final)) {
                $final[] = 'lengkap';
            }

            $absen->status_final = implode(' dan ', $final);
            $absen->save();

            return back()->with('success', 'Absen pulang berhasil');
        }

        return back()->with('error', 'Anda Sudah Absen Hari ini');
    }
}