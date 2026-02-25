<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'master_jabatan';

    protected $primaryKey = 'jabatan_id';

    protected $fillable = [
        'kode_jabatan',
        'nama_jabatan',
        'status',
        'is_satpam',
        'is_driver',
    ];
    
    protected $casts = [
        'is_satpam' => 'boolean',
        'is_driver' => 'boolean',
    ];
}
