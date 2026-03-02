<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JadwalAbsensi;

class JadwalAbsensiController extends Controller
{
    public function index()
    {
        $jadwal = JadwalAbsensi::first();

        if (!$jadwal) {
            $jadwal = JadwalAbsensi::create([]);
        }

        return view('jadwal.index', compact('jadwal'));
    }

    public function update(Request $request)
{
    $jadwal = JadwalAbsensi::first();

    if (!$jadwal) {
        $jadwal = JadwalAbsensi::create([]);
    }

    $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];

    $data = [];

    foreach ($hariList as $hari) {

        // status aktif
        $data[$hari] = $request->has($hari);

        // jam masuk
        $data['jam_masuk_'.$hari] = $request->input('jam_masuk_'.$hari);

        // jam pulang
        $data['jam_pulang_'.$hari] = $request->input('jam_pulang_'.$hari);
    }

    $jadwal->update($data);

    return back()->with('success','Jadwal berhasil diperbarui');
}

    public function store(Request $request)
{
    $userId = Auth::id();
    $today  = Carbon::today()->toDateString();
    $now    = Carbon::now();

    /*
    =========================
    CEK JADWAL AKTIF
    =========================
    */

    $jadwal = JadwalAbsensi::first();

    if (!$jadwal) {
        return back()->with('error','Jadwal absensi belum disetting admin');
    }

    $mapHari = [
        'Monday' => 'senin',
        'Tuesday' => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday' => 'kamis',
        'Friday' => 'jumat',
        'Saturday' => 'sabtu',
        'Sunday' => 'minggu'
    ];

    $hariInggris = Carbon::now()->format('l');
    $hariDb = $mapHari[$hariInggris];

    if (!$jadwal->$hariDb) {
        return back()->with('error','Hari ini absensi tidak aktif');
    }

    /*
    =========================
    LANJUT LOGIC LAMA LU
    =========================
    */
    }
}