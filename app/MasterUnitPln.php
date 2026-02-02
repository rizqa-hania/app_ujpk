<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnitPln extends Model
{
    protected $table = 'master_unit_pln';

    protected $primaryKey = 'unitpln_id';

    protected $fillable = [
        'kode_unit',
        'nama_unit', 
    ];

    /**
     * RELATIONS
     */

    public function subUnits()
    {
        return $this->hasMany(MasterSubUnit::class, 'unitpln_id', 'unitpln_id');
    }

    public function projects()
    {
        return $this->hasMany(MasterProject::class, 'unitpln_id', 'unitpln_id');
    }
}
