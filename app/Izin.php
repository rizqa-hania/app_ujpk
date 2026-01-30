<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'izin';

    protected $primaryKey = 'izin_id';

    protected $fillable = [
        'nip',
        'jenis_izin',
        'tanggal_mulai',
        'tanggal_selesai',
        'bukti_dokumen',
        'keterangan',
    ];

    /**
     * RELATION
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }
}
