<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalAbsensi extends Model
{
    protected $table = 'jadwal_absensis';
    protected $primaryKey = 'jadwal_id';
    public $incrementing = true;

    protected $fillable = [
        'senin','jam_masuk_senin','jam_pulang_senin',
        'selasa','jam_masuk_selasa','jam_pulang_selasa',
        'rabu','jam_masuk_rabu','jam_pulang_rabu',
        'kamis','jam_masuk_kamis','jam_pulang_kamis',
        'jumat','jam_masuk_jumat','jam_pulang_jumat',
        'sabtu','jam_masuk_sabtu','jam_pulang_sabtu',
        'minggu','jam_masuk_minggu','jam_pulang_minggu',
    ];
}