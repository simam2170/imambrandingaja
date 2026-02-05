<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class YoutubeService
{
    public function getVideoStats(string $videoId): array
    {
        $response = Http::get(
            'https://www.googleapis.com/youtube/v3/videos',
            [
                'part' => 'snippet,statistics',
                'id'   => $videoId,
                'key'  => config('services.youtube.key'),
            ]
        );

        return $response->json();
    }
}
