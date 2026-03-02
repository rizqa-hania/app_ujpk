<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $primaryKey = 'izin_id';

    protected $fillable = [
        'user_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'file_bukti',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}