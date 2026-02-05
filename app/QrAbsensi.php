<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrAbsensi extends Model
{
    protected $table = 'qr_absensi';

    protected $fillable = [
        'kantor_id',
        'token',
        'tanggal',
        'expired_at',
        'is_active'
    ];
}

