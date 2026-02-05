<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'order_number',
        'user_id',
        'layanan_branding_id',
        'admin_id',
        'mitra_id',
        'status',
        'catatan',
        'youtube_video_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(LayananBranding::class, 'layanan_branding_id');
    }
}
