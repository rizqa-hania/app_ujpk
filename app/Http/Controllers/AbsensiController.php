<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Absensi;
use App\Kantor;
use App\JadwalAbsensi;
use App\Izin;  
use App\Lembur; 
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $userId = $user->id;

        // --- LOGIC ROLE: ADMIN ---
        if ($user->role == 'admin' || $user->role == 'superadmin') {
            // PERBAIKAN: Gunakan paginate() bukan get() agar method firstItem() di view bisa jalan
            $dataAbsensi = Absensi::with('user')
                ->orderBy('tanggal', 'desc')
                ->paginate(10); // Lo bisa ganti 10 jadi 20 atau sesuai kebutuhan

            return view('absensi.admin.index', compact('dataAbsensi'));
        }

        // --- LOGIC ROLE: KARYAWAN ---
        
        // 1. Otomatisasi status 'tidak lengkap' untuk hari-hari sebelumnya
        Absensi::where('user_id', $userId)
            ->where('tanggal', '<', $today)
            ->where('status_final', 'belum lengkap')
            ->update(['status_final' => 'tidak lengkap']);

        // 2. Logic Generate Alpha (Riwayat 30 hari)
        $jadwal = JadwalAbsensi::first();
        if ($jadwal) {
            $startDate = Carbon::now()->subDays(30)->startOfDay();
            $endDate = Carbon::now()->subDay()->endOfDay(); // Sampai kemarin
            $userCreatedAt = $user->created_at ? $user->created_at->startOfDay() : $startDate;

            for ($d = $startDate->copy(); $d <= $endDate; $d->addDay()) {
                if ($d->lt($userCreatedAt)) continue;

                $hariEnglish = strtolower($d->format('l'));
                $hariIndo = [
                    'monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 
                    'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'
                ];
                $h = $hariIndo[$hariEnglish];

                if (isset($jadwal->$h) && $jadwal->$h) { 
                    $tgl = $d->toDateString();
                    $exists = Absensi::where('user_id', $userId)->where('tanggal', $tgl)->exists();
                    
                    if (!$exists) {
                        $adaIzin = Izin::where('user_id', $userId)
                            ->whereDate('tanggal_mulai', '<=', $tgl)
                            ->whereDate('tanggal_selesai', '>=', $tgl)
                            ->where('status', 'disetujui')
                            ->exists();

                        if (!$adaIzin) {
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

        // 3. Ambil data riwayat untuk ditampilkan di view karyawan
        $dataAbsensi = Absensi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->take(30)
            ->get();

        return view('absensi.karyawan.create', compact('dataAbsensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:masuk,pulang',
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required', 
        ]);

        $userId = Auth::id();
        $now = Carbon::now();
        $today = $now->toDateString();

        $kantor = Kantor::first();
        if (!$kantor) return back()->with('error', 'Data lokasi kantor belum diatur!');

        // Cek Jarak Radius
        $distance = $this->hitungJarak($request->latitude, $request->longitude, $kantor->latitude, $kantor->longitude);
        if ($distance > $kantor->radius_meter) {
            return back()->with('error', 'Gagal! Anda berada di luar radius kantor (' . round($distance) . 'm).');
        }

        // Upload & Process Foto
        $img = $request->photo;
        $img = str_replace('data:image/jpeg;base64,', '', $img); // Sesuaikan base64 header
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $imageData = base64_decode($img);
        $fileName = 'absensi_' . $request->type . '_' . $userId . '_' . time() . '.png';
        $folderPath = public_path('uploads/absensi/');
        
        if (!File::isDirectory($folderPath)) File::makeDirectory($folderPath, 0777, true, true);
        File::put($folderPath . $fileName, $imageData);

        $absen = Absensi::where('user_id', $userId)->where('tanggal', $today)->first();
        $jadwal = JadwalAbsensi::first();
        $hariIndo = ['monday'=>'senin','tuesday'=>'selasa','wednesday'=>'rabu','thursday'=>'kamis','friday'=>'jumat','saturday'=>'sabtu','sunday'=>'minggu'];
        $hariIni = $hariIndo[strtolower($now->format('l'))];

        if ($request->type === 'masuk') {
            if ($absen && $absen->jam_masuk && $absen->status_masuk !== 'alpha') {
                return back()->with('error', 'Anda sudah absen masuk hari ini!');
            }
            
            $jamMasukJadwal = $jadwal->{'jam_masuk_' . $hariIni};
            $terlambat = $now->gt(Carbon::parse($today . ' ' . $jamMasukJadwal));

           Absensi::updateOrCreate(
    [
        'user_id' => Auth::id(), // Pastikan ini pakai Auth::id()
        'tanggal' => $today
    ],
    [
        'jam_masuk' => $now->format('H:i:s'),
        'status_masuk' => $terlambat ? 'terlambat' : 'tepat waktu',
        'status_final' => 'belum lengkap',
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'foto_masuk' => $fileName,
    ]
);
            return back()->with('success', 'Berhasil Absen Masuk. Status: ' . ($terlambat ? 'Terlambat' : 'Tepat Waktu'));

        } else {
            // Logika Pulang
            if (!$absen || $absen->status_masuk === 'alpha' || !$absen->jam_masuk) {
                return back()->with('error', 'Anda belum absen masuk!');
            }
            if ($absen->jam_pulang) {
                return back()->with('error', 'Anda sudah absen pulang!');
            }
            
            $jamPulangJadwal = $jadwal->{'jam_pulang_' . $hariIni};
            if ($now->lt(Carbon::parse($today . ' ' . $jamPulangJadwal))) {
                return back()->with('error', 'Belum waktunya pulang! Jam pulang hari ini: ' . $jamPulangJadwal);
            }

            $statusFinal = ($absen->status_masuk == 'tepat waktu') ? 'lengkap' : 'tidak lengkap';

            $absen->update([
                'jam_pulang' => $now->format('H:i:s'),
                'status_pulang' => 'tepat waktu',
                'status_final' => $statusFinal,
                'foto_pulang' => $fileName,
            ]);
            
            return back()->with('success', 'Berhasil Absen Pulang. Kerja Bagus!');
        }
    }

    public function monitoring()
    {
        $today = Carbon::now()->toDateString();
        $kantor = Kantor::first();
        $jadwal = JadwalAbsensi::first();
        
        $hariIndo = ['monday'=>'senin','tuesday'=>'selasa','wednesday'=>'rabu','thursday'=>'kamis','friday'=>'jumat','saturday'=>'sabtu','sunday'=>'minggu'];
        $hariIni = $hariIndo[strtolower(Carbon::now()->format('l'))];
        
        $isHariKerja = $jadwal ? $jadwal->$hariIni : false;

        $karyawan = User::where('role', 'karyawan')->get()->map(function ($user) use ($today) {
            $user->absen_today = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();
            $user->izin_today = Izin::where('user_id', $user->id)
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->where('status', 'disetujui')
                ->first();
            return $user;
        });

        return view('dashboard.admin.absensi.monitoring', compact('karyawan', 'today', 'kantor', 'isHariKerja'));
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2) 
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        return $earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }

    public function cetakRekap(Request $request)
    {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();
        $jadwal = JadwalAbsensi::first();

        if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            $userId = $request->user_id;
            $users = ($userId && $userId != 'semua') ? User::where('id', $userId)->get() : User::where('role', 'karyawan')->get();
        } else {
            $users = collect([Auth::user()]);
        }

        $rekapData = $users->map(function ($user) use ($start, $end, $jadwal) {
            $dataAbsen = Absensi::where('user_id', $user->id)
                ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                ->get();

            $totalHadir = $dataAbsen->where('status_masuk', '!=', 'alpha')->whereNotNull('jam_masuk')->count();
            
            $details = [];
            for ($d = $start->copy(); $d <= $end; $d->addDay()) {
                $tgl = $d->toDateString();
                $dayName = strtolower($d->format('l'));
                $h = ['monday' => 'senin', 'tuesday' => 'selasa', 'wednesday' => 'rabu', 'thursday' => 'kamis', 'friday' => 'jumat', 'saturday' => 'sabtu', 'sunday' => 'minggu'][$dayName];

                $absen = $dataAbsen->where('tanggal', $tgl)->first();
                $status = '-';

                if ($absen) {
                    $status = $absen->status_final;
                } elseif (isset($jadwal->$h) && !$jadwal->$h) {
                    $status = 'libur';
                } elseif ($d->isPast()) {
                    $status = 'alpha';
                }

                $details[] = (object) [
                    'tanggal' => $tgl,
                    'jam_masuk' => $absen->jam_masuk ?? '-',
                    'jam_pulang' => $absen->jam_pulang ?? '-',
                    'status' => $status
                ];
            }

            return [
                'nama' => $user->name,
                'nip' => $user->nip,
                'hadir' => $totalHadir,
                'details' => $details
            ];
        });

        $periode = $start->format('d M Y') . ' - ' . $end->format('d M Y');
        $pdf = Pdf::loadView('pdf.rekap', [
            'rekap' => $rekapData,
            'periode' => $periode
        ])->setPaper('a4', 'portrait');

        return $pdf->download("Rekap_Absensi_" . time() . ".pdf");
    }

    // Tambahkan function ini di dalam class AbsensiController
public function rekapKaryawan()
{
    $user = Auth::user();
    $userId = $user->id;

    // Ambil data riwayat 
    // Gunakan paginate supaya method firstItem() di view tidak error
    $dataAbsensi = Absensi::where('user_id', $userId)
        ->orderBy('tanggal', 'desc')
        ->paginate(10); 

    // Pastikan view ini ada di resources/views/absensi/karyawan/index.blade.php
    return view('absensi.karyawan.index', compact('dataAbsensi'));
}
}