<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\LayananBranding;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class YoutubeTestSeeder extends Seeder
{
    public function run()
    {
        // 1. Create User
        $user = User::firstOrCreate(
            ['email' => 'user@brandingaja.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create Jaringan
        $jaringanId = DB::table('jaringan')->insertGetId([
            'nama_jaringan' => 'Digital Branding Team',
            'email' => 'jaringan' . rand(1, 999) . '@test.com',
            'password' => Hash::make('password'),
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Create Layanan
        $layananCommon = LayananBranding::create([
            'jaringan_id' => $jaringanId,
            'nama_layanan' => 'Digital Branding Kit',
            'deskripsi' => 'Standard branding package for businesses.',
            'harga' => 500000,
            'estimasi_hari' => 3,
            'status' => 'aktif',
        ]);

        $layananYoutube = LayananBranding::create([
            'jaringan_id' => $jaringanId,
            'nama_layanan' => 'YouTube SEO Optimization',
            'deskripsi' => 'Full SEO optimization for your YouTube videos.',
            'harga' => 1200000,
            'estimasi_hari' => 5,
            'status' => 'aktif',
        ]);

        // 4. Create Pesanan for each status
        
        // DIREVIEW
        Pesanan::create([
            'order_number' => 'REV-' . rand(1000, 9999),
            'user_id' => $user->id,
            'layanan_branding_id' => $layananCommon->id,
            'status' => 'direview',
        ]);

        // DIPROSES
        Pesanan::create([
            'order_number' => 'PRO-' . rand(1000, 9999),
            'user_id' => $user->id,
            'layanan_branding_id' => $layananCommon->id,
            'status' => 'diproses',
        ]);

        // SELESAI (with YouTube ID or Link)
        $videoLink = '5nXHI_m7S4o'; // You can put any real link here
        $videoId = \App\Services\YoutubeService::parseVideoId($videoLink);

        Pesanan::create([
            'order_number' => 'DONE-' . rand(1000, 9999),
            'user_id' => $user->id,
            'layanan_branding_id' => $layananYoutube->id,
            'status' => 'selesai',
            'youtube_video_id' => $videoId,
        ]);

        // DITOLAK
        Pesanan::create([
            'order_number' => 'CANC-' . rand(1000, 9999),
            'user_id' => $user->id,
            'layanan_branding_id' => $layananCommon->id,
            'status' => 'ditolak',
            'catatan' => 'Brief tidak lengkap.',
        ]);
        
        echo "Comprehensive status test data seeded successfully!\n";
    }
}
