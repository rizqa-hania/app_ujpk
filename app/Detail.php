<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $table = 'detail';
    protected $primaryKey = 'detail_id';
    protected $fillable = ['penggajian_id', 'nip', 'kode', 'total_pendapatan', 'total_potongan', 'gaji_bersih'];

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class, 'penggajian_id');
    }

    public function karyawan()
    {
    return $this->belongsTo(Karyawan::class, 'nip', 'nip');
    }

}
