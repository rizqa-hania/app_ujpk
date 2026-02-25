<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Karyawan;

class CheckKaryawanStep
{
    public function handle(Request $request, Closure $next, $step)
    {
        $karyawan = Karyawan::where('user_id', auth()->id())->first();

        // Kalau belum ada data sama sekali → paksa ke step1
        if (!$karyawan) {
            return redirect()->route('karyawan.step1');
        }

        // Kalau sudah complete, tidak boleh kembali ke step
        if ($karyawan->is_complete) {
            return redirect()->route('karyawan.dashboard');
        }

        // Mapping urutan step
        $steps = [
            'step1' => 1,
            'step2' => 2,
            'step3' => 3,
            'step4' => 4,
            'step5' => 5,
            'step6' => 6,
            'step7' => 7,
            'step8' => 8,
            'step9' => 9,
            'step10' => 10,
        ];

        $currentStep = $steps[$step] ?? 1;

        // Kalau user mau loncat terlalu jauh
        if ($currentStep > 1 && !$karyawan->nip) {
            return redirect()->route('karyawan.step1');
        }

        return $next($request);
    }
}