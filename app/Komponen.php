<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    protected $table = 'komponen';
    protected $primaryKey = 'komponen_id';
    protected $fillable = ['name', 'tipe', 'tipe_penghitungan', 'nilai'];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'komponen_id');
    }
}
