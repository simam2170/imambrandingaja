<?php

use App\Models\User;
use App\Models\LayananBranding;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// 1. Create User if not exists
$user = User::firstOrCreate(
    ['email' => 'test@brandingaja.com'],
    [
        'name' => 'Test User',
        'password' => Hash::make('password'),
    ]
);

// 2. Create Jaringan
$jaringanId = DB::table('jaringan')->insertGetId([
    'nama_jaringan' => 'Digital Branding Team',
    'created_at' => now(),
    'updated_at' => now(),
]);

// 3. Create Layanan
$layanan = LayananBranding::create([
    'jaringan_id' => $jaringanId,
    'nama_layanan' => 'YouTube SEO & Growth',
    'deskripsi' => 'Optimize your YouTube channel for maximum reach.',
    'harga' => 1500000,
    'estimasi_hari' => 7,
    'status' => 'aktif',
]);

// 4. Create Pesanan (Completed)
Pesanan::create([
    'order_number' => 'YT-TEST-' . rand(1000, 9999),
    'user_id' => $user->id,
    'layanan_branding_id' => $layanan->id,
    'status' => 'selesai',
    'youtube_video_id' => 'dQw4w9WgXcQ', // Never Gonna Give You Up (Valid ID for testing)
]);

echo "Test data seeded successfully!\n";
