<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPesanan extends Model
{
    protected $table = 'bukti_pesanan';

    protected $fillable = [
        'pesanan_id',
        'file_bukti',
        'deskripsi',
        'uploaded_at',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}
