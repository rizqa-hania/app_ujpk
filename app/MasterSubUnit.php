<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSubUnit extends Model
{
    protected $table = 'master_sub_unit';
    
    protected $primaryKey = 'sub_id';

    protected $fillable = [
        'unitpln_id',
        'kode_sub',
        'nama_sub',
        'nama_mitra',
        'jenis_kerjasama',
        'is_active',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // RELASI
    public function unitPln()
    {
        return $this->belongsTo(MasterUnitPln::class,'unitpln_id','unitpln_id');
    }
}
