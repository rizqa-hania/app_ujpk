<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Absensi;
use App\JadwalAbsensi;
use Carbon\Carbon;

class GenerateAlphaAbsensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:generate-alpha';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis membuat record ALPHA untuk karyawan yang tidak absen masuk selama seharian penuh';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Cek hari kemarin
        $yesterday = Carbon::yesterday();
        $dateStr = $yesterday->toDateString();
        
        $jadwal = JadwalAbsensi::first();
        if (!$jadwal) {
            $this->info("Tidak ada jadwal yang diatur. Skip.");
            return 0;
        }

        // Cek apakah kemarin jadwalnya aktif/kerja
        $mapHari = ['monday'=>'senin','tuesday'=>'selasa','wednesday'=>'rabu','thursday'=>'kamis','friday'=>'jumat','saturday'=>'sabtu','sunday'=>'minggu'];
        $hariKemarinDb = $mapHari[strtolower($yesterday->format('l'))];

        if (!(bool) $jadwal->$hariKemarinDb) {
            $this->info("Kemarin adalah hari libur (".$hariKemarinDb."). Skip.");
            return 0;
        }

        $users = User::where('role', 'karyawan')->get();
        $countAlpha = 0;

        foreach ($users as $user) {
            $absenAda = Absensi::where('user_id', $user->user_id ?? $user->id)
                               ->whereDate('tanggal', $dateStr)
                               ->exists();
            if (!$absenAda) {
                Absensi::create([
                    'user_id' => $user->user_id ?? $user->id,
                    'tanggal' => $dateStr,
                    'status_final' => 'alpha',
                ]);
                $countAlpha++;
            }
        }

        $this->info("Berhasil men-generate $countAlpha record ALPHA untuk tanggal $dateStr");
        return 0;
    }
}
