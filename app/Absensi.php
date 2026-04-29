<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    // Pastikan nama tabelnya benar
    protected $table = 'absensis'; 

    protected $fillable = [
        'user_id', 'tanggal', 'jam_masuk', 'jam_pulang', 
        'status_masuk', 'status_pulang', 'status_final', 
        'latitude', 'longitude', 'foto_masuk', 'foto_pulang'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nip', 'nip');
    }

    public function kantor()
    {
        return $this->belongsTo(Kantor::class, 'kantor_id', 'kantor_id');
    }
}
