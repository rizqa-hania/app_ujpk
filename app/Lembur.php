<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lembur';

    protected $primaryKey = 'lembur_id';

    protected $fillable = [
        'nip',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'status',
        'keterangan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nip', 'nip');
    }
}
