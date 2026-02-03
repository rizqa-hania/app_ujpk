<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterKerjaSama extends Model
{
    protected $table = 'master_kerja_sama';
    protected $primaryKey = 'kerjasama_id';

    protected $fillable = [
        'unitpln_id',
        'nama_kerja_sama',
        'mitra',
        'jenis_kerjasama',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function unitPln()
    {
        return $this->belongsTo(
            MasterUnitPln::class,
            'unitpln_id',
            'unitpln_id'
        );
    }
}
