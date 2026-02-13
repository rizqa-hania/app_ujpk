<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailKomponen extends Model
{
    protected $table = 'detail_komponen';
    protected $primaryKey = 'id';
    protected $fillable = ['detail_id', 'kode', 'nilai'];

    public function detail()
    {
        return $this->belongsTo(Detail::class, 'detail_id', 'detail_id');
    }

    public function komponen()
    {
        return $this->belongsTo(Komponen::class, 'kode', 'kode');
    }
}
