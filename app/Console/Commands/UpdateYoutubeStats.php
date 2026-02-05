<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Models\YoutubeStat;
use App\Services\YoutubeService;
use Illuminate\Console\Command;

class UpdateYoutubeStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:update-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update YouTube statistics for completed orders';

    /**
     * Execute the console command.
     */
    public function handle(YoutubeService $youtubeService)
    {
        $this->info('Starting YouTube statistics update...');

        // Only get completed orders that have a video_id
        $orders = Pesanan::where('status', 'selesai')
            ->whereNotNull('youtube_video_id')
            ->get();

        if ($orders->isEmpty()) {
            $this->warn('No completed orders with YouTube Video ID found.');
            return;
        }

        foreach ($orders as $order) {
            $this->info("Updating stats for Video ID: {$order->youtube_video_id}");

            $stats = $youtubeService->getVideoStats($order->youtube_video_id);

            if ($stats) {
                YoutubeStat::updateOrCreate(
                    ['video_id' => $order->youtube_video_id],
                    [
                        'title' => $stats['title'],
                        'thumbnail' => $stats['thumbnail'],
                        'views' => $stats['views'],
                        'likes' => $stats['likes'],
                        'comments' => $stats['comments'],
                    ]
                );
                $this->info('Successfully updated stats.');
            } else {
                $this->error("Failed to fetch stats for Video ID: {$order->youtube_video_id}");
            }
        }

        $this->info('YouTube statistics update completed.');
    }
}
