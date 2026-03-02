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
                        ->orderBy('tanggal','desc')
                        ->get();

        return view('absensi.index', compact('dataAbsensi'));
    }

   public function store(Request $request)
{
    $userId = Auth::id();
    $today  = Carbon::today()->toDateString();
    $now    = Carbon::now();

    /*
    =========================
    CEK JADWAL
    =========================
    */

    $jadwal = JadwalAbsensi::first();

    if (!$jadwal) {
        return back()->with('error','Jadwal absensi belum disetting admin');
    }

    Carbon::setLocale('id');
    $hari = strtolower(Carbon::now()->translatedFormat('l'));

    // Cek hari aktif
    if (!$jadwal->$hari) {
        return back()->with(
            'error',
            'Maaf, anda absen di luar hari kerja. Tidak bisa absen saat ini.'
        );
    }

    // Ambil jam sesuai hari
    $fieldJamMasuk  = 'jam_masuk_' . $hari;
    $fieldJamPulang = 'jam_pulang_' . $hari;

    $jamMasuk  = $jadwal->$fieldJamMasuk;
    $jamPulang = $jadwal->$fieldJamPulang;

    if (!$jamMasuk || !$jamPulang) {
        return back()->with('error','Jam kerja hari ini belum diatur admin');
    }

    /*
    =========================
    CEK ABSEN HARI INI
    =========================
    */

    $absen = Absensi::where('user_id', $userId)
                    ->where('tanggal', $today)
                    ->first();

    /*
    =========================
    ABSEN MASUK (TIDAK DIBLOKIR SEBELUM JAM)
    =========================
    */
    if (!$absen && $request->type == 'masuk') {

        $batasMasuk = Carbon::parse($today . ' ' . $jamMasuk);

        // HANYA TENTUKAN STATUS, BUKAN BLOKIR
        $status = $now->gt($batasMasuk)
            ? 'terlambat'
            : 'tepat waktu';

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
    ABSEN PULANG (TETAP DIBLOKIR SEBELUM JAM PULANG)
    =========================
    */
    if ($absen && !$absen->jam_pulang && $request->type == 'pulang') {

        $batasPulang = Carbon::parse($today . ' ' . $jamPulang);

        if ($now->lt($batasPulang)) {
            return back()->with('error','Belum waktunya absen pulang');
        }

        $absen->jam_pulang = $now->format('H:i:s');

        // Finalisasi status
        if ($absen->status == 'terlambat') {
            $absen->status = 'terlambat';
        } else {
            $absen->status = 'lengkap';
        }

        $absen->save();

        return back()->with('success','Absen pulang berhasil');
    }

    return back()->with('error','Aksi tidak valid');
}
}