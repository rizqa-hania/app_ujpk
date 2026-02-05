<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Karyawan;
use App\QrAbsensi;
use App\Kantor;
use Carbon\Carbon;
use Illuminate\Http\Request;



class AbsensiController extends Controller
{
    public function index()
{
    $data = Absensi::with(['karyawan', 'kantor'])
        ->orderBy('tanggal', 'desc')
        ->get();

    $kantorList = Kantor::all();

    return view('absensi.index', compact('data', 'kantorList'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'kantor_id' => 'required',
            'metode_absensi' => 'required|in:qr,face',
        ]);

        $tanggal = Carbon::today();

        $absensi = Absensi::firstOrCreate(
            [
                'nip' => $request->nip,
                'tanggal' => $tanggal
            ],
            [
                'kantor_id' => $request->kantor_id,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir',
                'metode_absensi' => $request->metode_absensi,
                'lat_masuk' => $request->lat,
                'long_masuk' => $request->long,
                'jarak_masuk' => $request->jarak,
                'is_valid_radius' => $request->jarak <= 100, // contoh radius 100m
                'verifikasi' => $request->jarak <= 100 ? 'valid' : 'ditolak'
                
            ]
        );

        return redirect()->back()->with('success', 'Absensi berhasil');
    }

    public function pulang(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);
        $kantor = $absensi->kantor;

            if (!$this->cekJamKerja($kantor, 'pulang')) {
                return back()->withErrors('Belum waktunya pulang');
}

        $absensi->update([
            'jam_pulang' => Carbon::now()->format('H:i:s'),
            'lat_pulang' => $request->lat,
            'long_pulang' => $request->long,
            'jarak_pulang' => $request->jarak,
            'device_id' => $request->device_id,

            
        ]);

        

        return back()->with('success', 'Absensi pulang dicatat');
    }


public function scanQr(Request $request)
{
    $data = json_decode($request->qr_payload, true);

    if (!$data) {
        return response()->json(['message' => 'QR tidak valid'], 400);
    }

    $qr = QrAbsensi::where('token', $data['token'])->where('kantor_id', $data['kantor_id'])->where('tanggal', now()->toDateString())->where('is_active', true)->first();

    if (!$qr) {
        return response()->json(['message' => 'QR tidak ditemukan'], 404);
    }

    if (now()->format('H:i:s') > $qr->expired_at) {
        $qr->update(['is_active' => false]);
        return response()->json(['message' => 'QR sudah expired'], 403);
    }

    $cek = Absensi::where('tanggal', now()->toDateString())
    ->where('device_id', $request->device_id)
    ->exists();

    if ($cek) {
    return response()->json([
        'message' => 'Perangkat ini sudah digunakan hari ini'
    ], 403);
}


    // lanjut simpan absensi
    Absensi::create([
        'nip' => $request->nip,
        'kantor_id' => $qr->kantor_id,
        'tanggal' => now()->toDateString(),
        'jam_masuk' => now()->format('H:i:s'),
        'status' => 'hadir',
        'metode_absensi' => 'qr',
        'verifikasi' => 'valid'
        
    ]);

    return response()->json(['message' => 'Absensi QR berhasil']);
}

private function hitungJarak($lat1, $lon1, $lat2, $lon2)
{
    $kantor = $qr->kantor; // lat & long kantor
    $jarak = $this->hitungJarak(
    $request->lat,
    $request->long,
    $kantor->latitude,
    $kantor->longitude
    
);

if ($jarak > 100) {
    return response()->json(['message' => 'Di luar radius kantor'], 403);
}

    $earthRadius = 6371000; // meter

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return $earthRadius * $c;
}
    private function cekJamKerja($kantor, $tipe)
{
    $now = Carbon::now()->format('H:i:s');

    if ($tipe === 'masuk') {
        return $now >= $kantor->jam_masuk_mulai
            && $now <= $kantor->jam_masuk_selesai;
    }

    if ($tipe === 'pulang') {
        return $now >= $kantor->jam_pulang_mulai
            && $now <= $kantor->jam_pulang_selesai;
    }

    return false;
}




}
