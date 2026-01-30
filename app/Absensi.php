<?php

namespace App\Models;

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
        'status',
    ];

    /**
     * RELATIONS
     */

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nip', 'nip');
    }

    public function kantor()
    {
        return $this->belongsTo(Kantor::class, 'kantor_id', 'kantor_id');
    }
}
