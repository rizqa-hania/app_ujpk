<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id'; 
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'is_profile_complete',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_profile_complete' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke Karyawan
    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class, 'user_id', 'user_id');
    }

    // Helper: cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }
}