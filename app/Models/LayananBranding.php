<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananBranding extends Model
{
    protected $table = 'layanan_branding';

    protected $fillable = [
        'mitra_id',
        'nama_layanan',
        'deskripsi',
        'harga',
        'estimasi_hari',
        'status',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
