<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = 'penggajian_id';
    protected $fillable = ['periode_bulan', 'periode_tahun', 'status'];
}
