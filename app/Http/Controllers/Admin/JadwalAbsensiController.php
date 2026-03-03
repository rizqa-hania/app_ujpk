<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JadwalAbsensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalAbsensiController extends Controller
{
    /*
    =====================================
    TAMPILKAN JADWAL
    =====================================
    */
    public function index()
    {
        $jadwal = JadwalAbsensi::first();

        if (!$jadwal) {
            $jadwal = JadwalAbsensi::create([
                'senin' => true,
                'selasa' => true,
                'rabu' => true,
                'kamis' => true,
                'jumat' => true,
                'sabtu' => false,
                'minggu' => false,
            ]);
        }

        return view('jadwal.index', compact('jadwal'));
    }

    /*
    =====================================
    UPDATE JADWAL
    =====================================
    */
    public function update(Request $request)
    {
        $jadwal = JadwalAbsensi::first();

        if (!$jadwal) {
            $jadwal = JadwalAbsensi::create([]);
        }

        $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];

        $data = [];

        foreach ($hariList as $hari) {

            // checkbox aktif / tidak
            $data[$hari] = $request->has($hari);

            // jam masuk
            $data['jam_masuk_'.$hari] = $request->input('jam_masuk_'.$hari);

            // jam pulang
            $data['jam_pulang_'.$hari] = $request->input('jam_pulang_'.$hari);
        }

        $jadwal->update($data);

        return back()->with('success','Jadwal berhasil diperbarui');
    }

    /*
    =====================================
    CEK APAKAH HARI INI AKTIF
    (Dipakai oleh controller absensi)
    =====================================
    */
    public static function cekHariAktif()
    {
        $jadwal = JadwalAbsensi::first();

        if (!$jadwal) {
            return false;
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

        $hariInggris = strtolower(Carbon::now()->format('l'));

        if (!isset($mapHari[$hariInggris])) {
            return false;
        }

        $hariDb = $mapHari[$hariInggris];

        return (bool) $jadwal->$hariDb;
    }

        
}