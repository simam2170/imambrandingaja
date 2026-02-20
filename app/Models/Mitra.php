<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mitra extends Authenticatable
{
    use Notifiable;

    protected $table = 'mitra';

    protected $fillable = [
        'nama_mitra',
        'email',
        'password',
        'deskripsi',
        'foto_profil',
        'kota',
        'provinsi',
        'status',
        'status_verifikasi',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'mitra_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'mitra_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'mitra_id');
    }
}
