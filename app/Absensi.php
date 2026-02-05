<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'absensi_id';

    protected $fillable = [
        'nip',
        'kantor_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'lat_masuk',
        'long_masuk',
        'jarak_masuk',
        'lat_pulang',
        'long_pulang',
        'jarak_pulang',
        'status',
        'metode_absensi',
        'verifikasi',
        'is_valid_radius',
        'device_id',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nip', 'nip');
    }

    public function kantor()
    {
        return $this->belongsTo(Kantor::class, 'kantor_id', 'kantor_id');
    }
}
