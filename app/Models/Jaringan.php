<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Jaringan extends Authenticatable
{
    use Notifiable;

    protected $table = 'mitra';

    protected $fillable = [
        'user_id',
        'nama_mitra',
        'email',
        'password',
        'whatsapp',
        'kota',
        'provinsi',
        'deskripsi',
        'status',
        'status_verifikasi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
