<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPendidikan extends Model
{
    protected $table = 'master_pendidikan';

    protected $primaryKey = 'pendidikan_id';

    protected $fillable = [
        'kode_pendidikan',
        'nama_pendidikan',
    ];
}
