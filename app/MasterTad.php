<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterTad extends Model
{
    protected $table = 'master_tad';

    protected $primaryKey = 'tad_id';

    protected $fillable = [
        'kode_tad',
        'nama_tad',
         'status',
        'is_satpam',
        'is_driver',
    ];

    protected $casts = [
        'is_satpam' => 'boolean',
        'is_driver' => 'boolean',
    ];
}
