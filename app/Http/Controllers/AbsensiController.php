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

        $todayAbsensi = null;
        if (auth()->check()) {
            $todayAbsensi = Absensi::where('nip', auth()->user()->nip)
                ->where('tanggal', now()->toDateString())
                ->first();
        }

        return view('absensi.index', compact(
            'data',
            'kantorList',
            'todayAbsensi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'kantor_id' => 'required|exists:kantor,kantor_id',
            'metode_absensi' => 'required|in:qr,face',
        ]);

        $tanggal = Carbon::today();

        $absensi = Absensi::where('nip', $request->nip)
            ->where('tanggal', $tanggal)
            ->first();

        $kantor = Kantor::find($request->kantor_id);

        /**
         * ======================
         * ABSEN MASUK
         * ======================
         */
        if (!$absensi) {
            Absensi::create([
                'nip' => $request->nip,
                'kantor_id' => $request->kantor_id,
                'tanggal' => $tanggal,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir',
                'metode_absensi' => $request->metode_absensi,
                'verifikasi' => 'valid',
                'is_valid_radius' => true,
            ]);

            return redirect()
                ->route('absensi.index')
                ->with('success', '✅ Absen MASUK berhasil');
        }

        /**
         * ======================
         * ABSEN PULANG
         * ======================
         */
        if ($absensi && $absensi->jam_pulang === null) {
            $absensi->update([
                'jam_pulang' => Carbon::now()->format('H:i:s'),
            ]);

            return redirect()
                ->route('absensi.index')
                ->with('success', '✅ Absen PULANG berhasil');
        }

        return redirect()
            ->route('absensi.index')
            ->withErrors('❌ Anda sudah absen masuk & pulang hari ini');
    }
}
