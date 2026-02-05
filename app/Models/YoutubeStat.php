<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YoutubeStat extends Model
{
    protected $table = 'youtube_stats';

    protected $fillable = [
        'video_id',
        'title',
        'thumbnail',
        'views',
        'likes',
        'comments',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'video_id', 'youtube_video_id');
    }
}
