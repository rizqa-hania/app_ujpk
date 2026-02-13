<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penggajian;
use App\Karyawan;
use App\Komponen;

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

    public function detailKomponen()
    {
    return $this->hasMany(DetailKomponen::class);
    }
    
}
