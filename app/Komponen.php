<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    protected $table = 'komponen';
    protected $primaryKey = 'kode_id';
    protected $fillable = ['kode', 'name', 'tipe', 'tipe_penghitungan', 'nilai', 'is_active'];

    public function detail()
    {
        return $this->hasMany(Detail::class, 'komponen_id');
    }
}
