<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTad extends Model
{
    protected $table = 'master_tad';

    protected $primaryKey = 'tad_id';

    protected $fillable = [
        'kode_tad',
        'nama_tad',
    ];
}
