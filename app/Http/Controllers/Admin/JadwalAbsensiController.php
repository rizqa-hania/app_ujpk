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
                'senin' => true, 'jam_masuk_senin' => '08:00', 'jam_pulang_senin' => '17:00',
                'selasa' => true, 'jam_masuk_selasa' => '08:00', 'jam_pulang_selasa' => '17:00',
                'rabu' => true, 'jam_masuk_rabu' => '08:00', 'jam_pulang_rabu' => '17:00',
                'kamis' => true, 'jam_masuk_kamis' => '08:00', 'jam_pulang_kamis' => '17:00',
                'jumat' => true, 'jam_masuk_jumat' => '08:00', 'jam_pulang_jumat' => '17:00',
                'sabtu' => false, 'jam_masuk_sabtu' => null, 'jam_pulang_sabtu' => null,
                'minggu' => false, 'jam_masuk_minggu' => null, 'jam_pulang_minggu' => null,
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
    $hariList = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];
    $data = [];

    foreach ($hariList as $hari) {
        // Simpan sebagai 1 atau 0 untuk boolean
        $data[$hari] = $request->has($hari) ? 1 : 0;
        $data['jam_masuk_'.$hari] = $request->input('jam_masuk_'.$hari);
        $data['jam_pulang_'.$hari] = $request->input('jam_pulang_'.$hari);
        
        if ($data[$hari] && (!$data['jam_masuk_'.$hari] || !$data['jam_pulang_'.$hari])) {
            return back()->with('error', "Jam masuk/pulang hari $hari wajib diisi!");
        }
    }

    // Ambil ID dari record pertama agar Laravel tahu mana yang diupdate
    $jadwalPalingAtas = \App\JadwalAbsensi::first();
    
    if ($jadwalPalingAtas) {
        // UPDATE record yang sudah ada
        $jadwalPalingAtas->update($data);
    } else {
        // BUAT BARU jika tabel kosong
        \App\JadwalAbsensi::create($data);
    }

    return back()->with('success', 'Jadwal berhasil diperbarui');
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