<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YoutubeService
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key', env('YOUTUBE_API_KEY'));
    }

    /**
     * Get video statistics from YouTube Data API v3.
     *
     * @param string $videoId
     * @return array|null
     */
    public function getVideoStats(string $videoId): ?array
    {
        if (!$this->apiKey) {
            Log::error('YouTube API Key is not set in .env.');
            return null;
        }

        try {
            $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'snippet,statistics',
                'id' => $videoId,
                'key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (empty($data['items'])) {
                    return null;
                }

                $item = $data['items'][0];
                return [
                    'title' => $item['snippet']['title'] ?? null,
                    'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? $item['snippet']['thumbnails']['default']['url'] ?? null,
                    'views' => $item['statistics']['viewCount'] ?? 0,
                    'likes' => $item['statistics']['likeCount'] ?? 0,
                    'comments' => $item['statistics']['commentCount'] ?? 0,
                ];
            }

            Log::error('YouTube API Error: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('YouTube Service Exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Extract Video ID from a YouTube URL.
     * Supports: youtube.com, youtu.be, shorts, etc.
     */
    public static function parseVideoId(string $urlOrId): ?string
    {
        // If it's already an ID (11 chars, alphanumeric/dash/underscore)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $urlOrId)) {
            return $urlOrId;
        }

        $patterns = [
            '/(?:v=|\/v\/|embed\/|watch\?v=|&v=|youtu\.be\/|\/shorts\/)([^"&?\/\s]{11})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $urlOrId, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
