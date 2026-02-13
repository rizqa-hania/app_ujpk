<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komponen extends Model
{
    protected $table = 'komponen';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kode', 
        'komponen', 
        'tipe', 
        'tipe_penghitungan', 
        'nilai', 
        'status'];
    
    public function detailKomponen()
    {
        return $this->hasMany(DetailKomponen::class, 'kode', 'kode');
    }
}
