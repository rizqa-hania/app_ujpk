<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterProject extends Model
{
    protected $table = 'master_project';

    protected $primaryKey = 'project_id';
     protected $fillable = [
        'kode_project',
        'nama_project',
    ];

    /**
     * RELATIONS
     */

    public function unitPln()
    {
        return $this->belongsTo(MasterUnitPln::class, 'unitpln_id', 'unitpln_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(MasterJabatan::class, 'jabatan_id', 'jabatan_id');
    }

    public function subUnit()
    {
        return $this->belongsTo(MasterSubUnit::class, 'sub_id', 'sub_id');
    }
}
