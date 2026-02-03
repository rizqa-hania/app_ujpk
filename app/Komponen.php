<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    protected $table = 'komponen';
    protected $primaryKey = 'kode';
    protected $fillable = ['kode', 'name', 'tipe', 'tipe_penghitungan', 'nilai'];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'komponen_id');
    }
}
