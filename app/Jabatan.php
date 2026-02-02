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
    ];
}
