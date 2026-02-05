<?php

namespace App\Http\Controllers;

use App\QrAbsensi;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class QrAbsensiController extends Controller
{
    public function generate($kantor_id)
    {
        $expired = Carbon::now()->addMinutes(10);

        $rawToken = Str::random(40);
        $token = hash_hmac('sha256', $rawToken, config('app.key'));

        QrAbsensi::create([
            'kantor_id' => $kantor_id,
            'token' => $token,
            'tanggal' => now()->toDateString(),
            'expired_at' => $expired->format('H:i:s'),
        ]);

        $payload = json_encode([
            'kantor_id' => $kantor_id,
            'tanggal' => now()->toDateString(),
            'expired' => $expired->format('H:i:s'),
            'token' => $token
        ]);

        return QrCode::size(300)->generate($payload);
    }
}

