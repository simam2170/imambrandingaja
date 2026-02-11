<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan_branding';

    protected $fillable = [
        'mitra_id',
        'nama_layanan',
        'kategori',
        'deskripsi',
        'thumbnail',
        'harga',
        'harga_json',
        'estimasi_hari',
        'status',
    ];

    protected $casts = [
        'harga_json' => 'array',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
