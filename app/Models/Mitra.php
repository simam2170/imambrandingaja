<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mitra extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mitra';

    protected $fillable = [
        'nama_mitra',
        'email',
        'password',
        'deskripsi',
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
}
