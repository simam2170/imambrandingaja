<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jaringan;
use App\Models\Layanan;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin
        $admin = User::create([
            'name' => 'Admin Branding',
            'email' => 'admin@brandingaja.com',
            'whatsapp' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Mitra User (Role in DB is 'mitra')
        $mitraUser = User::create([
            'name' => 'Mitra Kreatif',
            'email' => 'mitra@brandingaja.com',
            'whatsapp' => '081234567891',
            'role' => 'mitra', 
            'password' => Hash::make('password'),
        ]);

        // Create Mitra Profile
        $mitra = Jaringan::create([
            'user_id' => $mitraUser->id,
            'nama_mitra' => 'Mitra Kreatif Studio',
            'email' => 'mitra@studio.com', 
            'password' => Hash::make('password'),
            'deskripsi' => 'Studio branding profesional terbaik di Jakarta, melayani pembuatan logo dan branding kit.',
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'status' => 'aktif',
            'status_verifikasi' => 'terverifikasi',
        ]);

        // 3. Regular User
        $user = User::create([
            'name' => 'Budi User',
            'email' => 'user@brandingaja.com',
            'whatsapp' => '081234567892',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        // 4. Layanan (Services)
        $layanan1 = Layanan::create([
            'mitra_id' => $mitra->id,
            'nama_layanan' => 'Desain Logo Premium',
            'deskripsi' => 'Paket desain logo lengkap dengan panduan branding, revisi sepuasnya, dan file master.',
            'harga' => 500000,
            'harga_json' => [
                'standard' => ['label' => 'Standard', 'price' => 500000, 'viewLabel' => 'Paket Standard'],
                'premium' => ['label' => 'Premium', 'price' => 750000, 'viewLabel' => 'Paket Premium']
            ],
            'estimasi_hari' => 3,
            'status' => 'aktif',
        ]);

        $layanan2 = Layanan::create([
            'mitra_id' => $mitra->id,
            'nama_layanan' => 'Social Media Management',
            'deskripsi' => 'Konten Instagram & TikTok selama 1 bulan, 15 feed, 10 story, copywriting & scheduling.',
            'harga' => 1500000,
            'estimasi_hari' => 30,
            'status' => 'aktif',
        ]);

        // 5. Orders & Payments
        
        // Order 1: Direview (New Order)
        $order1 = Order::create([
            'order_number' => 'ORD-001',
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'layanan_branding_id' => $layanan1->id,
            'status' => 'direview',
            'total' => 500000,
            'catatan' => 'Saya ingin logo yang minimalis dengan warna biru laut.',
        ]);

        OrderItem::create([
            'pesanan_id' => $order1->id,
            'layanan_id' => $layanan1->id,
            'jenis_layanan' => 'Premium',
            'qty' => 1,
            'harga' => 500000,
        ]);

        Payment::create([
            'pesanan_id' => $order1->id,
            'metode_pembayaran' => 'transfer',
            'total_bayar' => 500000,
            'bukti_pembayaran' => 'bukti_transfer_dummy.jpg',
            'status' => 'menunggu',
            'tanggal_bayar' => now(),
        ]);
        
        // Order 2: Diproses (Verified by Admin)
        $order2 = Pesanan::create([
            'order_number' => 'ORD-002',
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'layanan_branding_id' => $layanan2->id,
            'status' => 'diproses',
            'total' => 1500000,
            'catatan' => 'Mohon segera diproses untuk konten bulan depan.',
        ]);
        
         OrderItem::create([
            'pesanan_id' => $order2->id,
            'layanan_id' => $layanan2->id,
            'jenis_layanan' => 'Monthly',
            'qty' => 1,
            'harga' => 1500000,
        ]);

         Payment::create([
            'pesanan_id' => $order2->id,
            'metode_pembayaran' => 'ewallet',
            'total_bayar' => 1500000,
            'bukti_pembayaran' => 'bukti_ewallet_dummy.jpg',
            'status' => 'diterima',
            'tanggal_bayar' => now()->subDay(),
        ]);
        
        // Order 3: Selesai
        $order3 = Pesanan::create([
            'order_number' => 'ORD-003',
            'user_id' => $user->id,
            'mitra_id' => $mitra->id,
            'layanan_branding_id' => $layanan1->id,
            'status' => 'selesai',
            'total' => 500000,
        ]);
        
         OrderItem::create([
            'pesanan_id' => $order3->id,
            'layanan_id' => $layanan1->id,
            'jenis_layanan' => 'Premium',
            'qty' => 1,
            'harga' => 500000,
        ]);

         Payment::create([
            'pesanan_id' => $order3->id,
            'metode_pembayaran' => 'transfer',
            'total_bayar' => 500000,
            'bukti_pembayaran' => 'bukti_selesai_dummy.jpg',
            'status' => 'diterima',
            'tanggal_bayar' => now()->subDays(5),
        ]);
    }
}
