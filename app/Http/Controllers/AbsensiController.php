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
        $userId = Auth::id();
        $jadwal = JadwalAbsensi::first();

        // Lazy Alpha Loading (Mengisi otomatis alpha untuk hari-hari sebelumnya yang terlewat)
        if ($jadwal) {
            // Cek ke belakang hingga 30 hari
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate = Carbon::now()->subDay()->endOfDay(); // Sampai kemarin

            for ($d = $startDate->copy(); $d <= $endDate; $d->addDay()) {
                $h = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'][strtolower($d->format('l'))];

                if ($jadwal->$h) { // Jika hari ini adalah hari kerja
                    $tgl = $d->toDateString();
                    $ada = Absensi::where('user_id', $userId)->where('tanggal', $tgl)->exists();

                    if (!$ada) {
                        // Cek apakah ada izin disetujui di tanggal tsb
                        $adaIzin = \App\Izin::where('user_id', $userId)
                            ->whereDate('tanggal_mulai', '<=', $tgl)
                            ->whereDate('tanggal_selesai', '>=', $tgl)
                            ->where('status', 'disetujui')
                            ->exists();

                        if (!$adaIzin) {
                            // Insert record Alpha
                            Absensi::create([
                                'user_id' => $userId,
                                'tanggal' => $tgl,
                                'status_masuk' => 'alpha',
                                'status_pulang' => 'alpha',
                                'status_final' => 'alpha',
                            ]);
                        }
                    }
                }
            }
        }

        $dataAbsensi = Absensi::where('user_id', $userId)
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
        if (!$kantor) {
            return back()->with('error', 'Konfigurasi kantor belum diatur oleh Admin. Anda belum bisa melakukan absensi.');
        }

        $distance = $this->hitungJarak($request->latitude, $request->longitude, $kantor->latitude, $kantor->longitude);
        if ($distance > $kantor->radius_meter) {
            return back()->with('error', 'Anda di luar radius kantor (' . round($distance) . 'm). Jarak maksimal adalah ' . $kantor->radius_meter . 'm.');
        }

        // 3. CEK JADWAL KERJA
        $jadwal = JadwalAbsensi::first();
        if (!$jadwal) {
            return back()->with('error', 'Jadwal absensi belum dikonfigurasi. Anda tidak dapat absen saat ini.');
        }

        $hariIndo = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'];
        $hariIni = $hariIndo[strtolower($now->format('l'))];

        if (!$jadwal->$hariIni) {
            return back()->with('error', 'Hari ini bukan jadwal kerja Anda berdasarkan setting jadwal absensi.');
        }

        $jamMasukJadwal = $jadwal->{'jam_masuk_' . $hariIni};
        $jamPulangJadwal = $jadwal->{'jam_pulang_' . $hariIni};

        if (!$jamMasukJadwal || !$jamPulangJadwal) {
            return back()->with('error', 'Jam masuk dan pulang belum lengkap disetting pada hari ini.');
        }

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
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();
        $jadwal = JadwalAbsensi::first();

        $allKaryawans = collect();
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') {
            $allKaryawans = User::where('role', 'karyawan')->get();
            $userId = $request->user_id;

            if ($userId && $userId != 'semua') {
                $users = User::where('id', $userId)->get();
            } else {
                $users = $allKaryawans;
            }
        } else {
            $users = collect([Auth::user()]);
        }

        $rekap = $users->map(function ($user) use ($start, $end, $jadwal) {
            $dataAbsen = Absensi::where('user_id', $user->id) // asumsikan id user adalah ->id
                ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                ->get();

            $totalHadir = $dataAbsen->whereNotNull('jam_masuk')->count();
            $totalIzin = $dataAbsen->whereIn('status_final', ['izin', 'sakit', 'cuti'])->count();

            // Hitung lembur
            $karyawan_info = \App\Karyawan::where('user_id', $user->id)->first();
            $totalLembur = 0;
            if ($karyawan_info) {
                $totalLembur = \App\Lembur::where('karyawan_id', $karyawan_info->id)
                    ->whereBetween('tanggal_mulai', [$start->toDateString(), $end->toDateString()])
                    ->where('status', 'disetujui')
                    ->count();
            }

            $alpha = 0;
            for ($d = $start->copy(); $d <= $end; $d->addDay()) {
                $h = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'][strtolower($d->format('l'))];
                if ($jadwal->$h && $d->isPast()) { // hanya hitung alpha jika hari sudah berlalu atau hari ini
                    $ada = Absensi::where('user_id', $user->id)->where('tanggal', $d->toDateString())->exists();
                    if (!$ada) {
                        $adaIzin = \App\Izin::where('user_id', $user->id)
                            ->whereDate('tanggal_mulai', '<=', $d->toDateString())
                            ->whereDate('tanggal_selesai', '>=', $d->toDateString())
                            ->where('status', 'disetujui')
                            ->exists();
                        if (!$adaIzin)
                            $alpha++;
                    }
                }
            }

            return [
                'nama' => $user->name,
                'nip' => $user->nip,
                'hadir' => $totalHadir,
                'izin' => $totalIzin,
                'alpha' => $alpha,
                'lembur' => $totalLembur,
            ];
        });

        return view('dashboard.admin.absensi.rekap', compact('rekap', 'start', 'end', 'allKaryawans'));
    }

    public function cetakRekap(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();
        $jadwal = JadwalAbsensi::first();

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') {
            $userId = $request->user_id;
            if ($userId && $userId != 'semua') {
                $users = User::where('id', $userId)->get();
            } else {
                $users = User::where('role', 'karyawan')->get();
            }
        } else {
            $users = collect([Auth::user()]);
        }

        $rekap = $users->map(function ($user) use ($start, $end, $jadwal) {
            $dataAbsen = Absensi::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                ->get();

            $totalHadir = $dataAbsen->whereNotNull('jam_masuk')->count();
            $totalIzin = $dataAbsen->whereIn('status_final', ['izin', 'sakit', 'cuti'])->count();

            $karyawan_info = \App\Karyawan::where('user_id', $user->id)->first();
            $totalLembur = 0;
            if ($karyawan_info) {
                $totalLembur = \App\Lembur::where('karyawan_id', $karyawan_info->id)
                    ->whereBetween('tanggal_mulai', [$start->toDateString(), $end->toDateString()])
                    ->where('status', 'disetujui')
                    ->count();
            }

            $alpha = 0;
            for ($d = $start->copy(); $d <= $end; $d->addDay()) {
                $h = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'][strtolower($d->format('l'))];
                if ($jadwal->$h && $d->isPast()) {
                    $ada = Absensi::where('user_id', $user->id)->where('tanggal', $d->toDateString())->exists();
                    if (!$ada) {
                        $adaIzin = \App\Izin::where('user_id', $user->id)
                            ->whereDate('tanggal_mulai', '<=', $d->toDateString())
                            ->whereDate('tanggal_selesai', '>=', $d->toDateString())
                            ->where('status', 'disetujui')
                            ->exists();
                        if (!$adaIzin)
                            $alpha++;
                    }
                }
            }

            // Siapkan details per hari dalam rentang periode untuk tabel detail PDF
            $details = [];
            for ($d = $start->copy(); $d <= $end; $d->addDay()) {
                $tgl = $d->toDateString();
                $h = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'][strtolower($d->format('l'))];

                $absenDiHariItu = $dataAbsen->where('tanggal', $tgl)->first();
                $lemburDiHariItu = false;
                if ($karyawan_info) {
                    $lemburStatus = \App\Lembur::where('karyawan_id', $karyawan_info->id)
                        ->where('tanggal_mulai', '<=', $tgl)
                        ->where('tanggal_selesai', '>=', $tgl)
                        ->where('status', 'disetujui')
                        ->exists();
                    if ($lemburStatus)
                        $lemburDiHariItu = true;
                }

                $statusFinal = '-';
                if ($absenDiHariItu) {
                    $statusFinal = $absenDiHariItu->status_final;
                } else {
                    $adaIzin = \App\Izin::where('user_id', $user->id)
                        ->whereDate('tanggal_mulai', '<=', $tgl)
                        ->whereDate('tanggal_selesai', '>=', $tgl)
                        ->where('status', 'disetujui')
                        ->first();
                    if ($adaIzin) {
                        $statusFinal = 'izin/cuti';
                    } elseif ($jadwal->$h && $d->isPast()) {
                        $statusFinal = 'alpha';
                    } else {
                        if (!$jadwal->$h)
                            $statusFinal = 'libur';
                        else
                            $statusFinal = 'belum absen';
                    }
                }

                $details[] = (object) [
                    'tanggal' => $tgl,
                    'jam_masuk' => $absenDiHariItu ? $absenDiHariItu->jam_masuk : null,
                    'jam_pulang' => $absenDiHariItu ? $absenDiHariItu->jam_pulang : null,
                    'status_final' => $statusFinal,
                    'lembur' => $lemburDiHariItu
                ];
            }

            return [
                'nama' => $user->name,
                'nip' => $user->nip,
                'total_hadir' => $totalHadir,
                'total_izin' => $totalIzin,
                'total_alpha' => $alpha,
                'total_lembur' => $totalLembur,
                'details' => $details
            ];
        });

        $periode = $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y');
        $pdf = Pdf::loadView('pdf.rekap', compact('rekap', 'periode'))->setPaper('a4', 'portrait');
        return $pdf->download("Rekap_Absensi_" . $start->format('Ymd') . ".pdf");
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