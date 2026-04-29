<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Absensi;
use App\Kantor;
use App\JadwalAbsensi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function __construct()
    {
        // Otomatisasi 24 jam "belum lengkap" (belum absen pulang) di convert ke "tidak lengkap"
        $today = Carbon::now()->toDateString();
        Absensi::where('tanggal', '<', $today)
            ->where('status_final', 'belum lengkap')
            ->update(['status_final' => 'tidak lengkap']);
    }

    // Halaman Absensi untuk Karyawan
    public function index()
    {
        $dataAbsensi = Absensi::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->take(30) // Ambil 30 data terakhir saja agar tidak berat
            ->get();

        return view('absensi.index', compact('dataAbsensi'));
    }

    // Simpan Absen (Masuk/Pulang)
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $userId = Auth::id();
        $now = Carbon::now();
        $today = $now->toDateString();

        // 1. CEK DOUBLE ABSEN & STATUS IZIN
        $absen = Absensi::where('user_id', $userId)->where('tanggal', $today)->first();

        if ($absen && in_array(strtolower($absen->status_final), ['izin', 'sakit', 'cuti'])) {
            return back()->with('error', 'Anda tidak bisa absen karena sedang berstatus ' . $absen->status_final . ' hari ini.');
        }

        if ($request->type === 'masuk' && $absen && $absen->jam_masuk) {
            return back()->with('error', 'Anda sudah absen masuk hari ini!');
        }
        
        if ($request->type === 'pulang' && (!$absen || !$absen->jam_masuk || $absen->jam_pulang)) {
            return back()->with('error', 'Proses gagal. Pastikan sudah absen masuk dan belum absen pulang.');
        }

        // 2. CEK RADIUS KANTOR
        $kantor = Kantor::first();
        $distance = $this->hitungJarak($request->latitude, $request->longitude, $kantor->latitude, $kantor->longitude);
        if ($distance > $kantor->radius_meter) {
            return back()->with('error', 'Anda di luar radius kantor (' . round($distance) . 'm)');
        }

        // 3. CEK JADWAL KERJA
        $jadwal = JadwalAbsensi::first();
        $hariIndo = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'];
        $hariIni = $hariIndo[strtolower($now->format('l'))];

        if (!$jadwal->$hariIni) {
            return back()->with('error', 'Hari ini bukan jadwal kerja.');
        }

        $jamMasukJadwal = $jadwal->{'jam_masuk_' . $hariIni};
        $jamPulangJadwal = $jadwal->{'jam_pulang_' . $hariIni};

        // 4. EKSEKUSI SIMPAN
        if ($request->type === 'masuk') {
            $terlambat = $now->gt(Carbon::parse($today . ' ' . $jamMasukJadwal));

            Absensi::create([
                'user_id' => $userId,
                'tanggal' => $today,
                'jam_masuk' => $now->format('H:i:s'),
                'status_masuk' => $terlambat ? 'terlambat' : 'tepat waktu',
                'status_final' => 'belum lengkap', // Ketika masuk status masih belum lengkap krn belum pulang
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return back()->with('success', 'Berhasil Absen Masuk');
        } else {
            $pulangCepat = $now->lt(Carbon::parse($today . ' ' . $jamPulangJadwal));

            $absen->update([
                'jam_pulang' => $now->format('H:i:s'),
                'status_pulang' => $pulangCepat ? 'pulang cepat' : 'tepat waktu',
                'status_final' => ($absen->status_masuk == 'terlambat' || $pulangCepat) ? 'tidak lengkap' : 'lengkap'
            ]);
            return back()->with('success', 'Berhasil Absen Pulang');
        }
    }

    public function monitoring()
    {
        $today = Carbon::now()->toDateString();
        $isHariKerja = \App\Http\Controllers\Admin\JadwalAbsensiController::cekHariAktif();
        $kantor = Kantor::first();

        $karyawan = User::where('role', 'karyawan')->get()->map(function ($user) use ($today) {
            // Kita ambil absen spesifik hari ini untuk user tersebut. PK Name = user_id
            $user->absen_hari_ini = Absensi::where('user_id', $user->user_id)
                ->whereDate('tanggal', $today)
                ->first();

            $user->izin_hari_ini = \App\Izin::where('user_id', $user->user_id)
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->where('status', 'disetujui')
                ->first();
                
            $karyawan_info = \App\Karyawan::where('user_id', $user->user_id)->first();
            if ($karyawan_info) {
                $user->lembur_hari_ini = \App\Lembur::where('karyawan_id', $karyawan_info->id)
                    ->where('tanggal_mulai', '<=', $today)
                    ->where('tanggal_selesai', '>=', $today)
                    ->where('status', 'disetujui')
                    ->first();
            } else {
                $user->lembur_hari_ini = null;
            }

            return $user;
        });

        return view('dashboard.admin.absensi.monitoring', compact('karyawan', 'today', 'isHariKerja', 'kantor'));
    }

    public function rekap(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();
        $jadwal = JadwalAbsensi::first();
        $users = User::where('role', 'karyawan')->get();

        $rekap = $users->map(function ($user) use ($start, $end, $jadwal) {
            $dataAbsen = Absensi::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                ->get();

            // Hitung Hari Kerja (Alpha otomatis jika tidak ada data di hari aktif)
            $totalHadir = $dataAbsen->whereNotNull('jam_masuk')->count();
            $totalIzin = $dataAbsen->whereIn('status_final', ['izin', 'sakit', 'cuti'])->count();

            // Hitung selisih hari kerja manual berdasarkan jadwal
            $alpha = 0;
            for ($d = $start->copy(); $d <= $end; $d->addDay()) {
                $h = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'][strtolower($d->format('l'))];
                if ($jadwal->$h) {
                    $ada = Absensi::where('user_id', $user->id)->where('tanggal', $d->toDateString())->exists();
                    if (!$ada)
                        $alpha++;
                }
            }

            return [
                'nama' => $user->name,
                'nip' => $user->nip,
                'hadir' => $totalHadir,
                'izin' => $totalIzin,
                'alpha' => $alpha,
            ];
        });

        $pdf = Pdf::loadView('pdf.rekap', compact('rekap', 'start', 'end'));
        return $pdf->download("Rekap_Absensi.pdf");
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        return $earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}