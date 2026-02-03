<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSubUnit extends Model
{
    protected $table = 'master_sub_unit';
    protected $primaryKey = 'sub_unit_id';

    protected $fillable = [
        'unitpln_id',
        'kode_sub',
        'nama_sub_unit',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function unitPln()
    {
        return $this->belongsTo(MasterUnitPln::class,'unitpln_id','unitpln_id');
    }
}
