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
    ];

    /**
     * RELATION
     */

    public function unitPln()
    {
        return $this->belongsTo(MasterUnitPln::class, 'unitpln_id', 'unitpln_id');
    }
}
