<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    protected $table = 'kantor';

    protected $primaryKey = 'kantor_id';

    protected $fillable = [
        'nama_kantor',
        'alamat',
        'latitude',
        'longitude',
        'radius_meter',
    ];

    /**
     * RELATION
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'kantor_id', 'kantor_id');
    }

    public function kantor()
{
    return $this->belongsTo(Kantor::class, 'kantor_id', 'kantor_id');
}

}
