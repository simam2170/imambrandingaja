<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    private function getDummyOrders()
    {
        return collect([
            (object)[
                'id' => 1,
                'order_number' => 'ORD-001',
                'status' => 'diproses',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
                'catatan' => 'Minta warna biru dominan',
                'user' => (object)['name' => 'Budi Santoso', 'email' => 'budi@example.com'],
                'layanan' => (object)['nama_layanan' => 'YouTube Podcast Branding'],
                'timeline' => [
                    ['time' => '02 Feb 2024 09:12', 'status' => 'Order Diterima', 'desc' => 'Pesanan telah masuk ke sistem.'],
                    ['time' => '02 Feb 2024 11:45', 'status' => 'Status: Diproses', 'desc' => 'Mitra sedang mengerjakan desain.'],
                ]
            ],
            (object)[
                'id' => 2,
                'order_number' => 'ORD-002',
                'status' => 'direview',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
                'catatan' => 'Logo minimalis ramping',
                'user' => (object)['name' => 'Siti Aminah', 'email' => 'siti@example.com'],
                'layanan' => (object)['nama_layanan' => 'Logo Design Business'],
                'timeline' => [
                    ['time' => '01 Feb 2024 14:00', 'status' => 'Order Masuk', 'desc' => 'Menunggu verifikasi admin.'],
                ]
            ],
            (object)[
                'id' => 3,
                'order_number' => 'ORD-003',
                'status' => 'selesai',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(4),
                'catatan' => 'Desain untuk banner toko offline',
                'user' => (object)['name' => 'Andi Wijaya', 'email' => 'andi@example.com'],
                'layanan' => (object)['nama_layanan' => 'Banner Toko Online'],
                'timeline' => [
                    ['time' => '28 Jan 2024 10:00', 'status' => 'Pekerjaan Selesai', 'desc' => 'File telah diunggah oleh mitra.'],
                ]
            ],
            (object)[
                'id' => 4,
                'order_number' => 'ORD-004',
                'status' => 'ditolak',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
                'catatan' => 'Pesanan dibatalkan karena kesalahan input kategori',
                'user' => (object)['name' => 'Rina Rose', 'email' => 'rina@example.com'],
                'layanan' => (object)['nama_layanan' => 'Logo Design Business'],
                'timeline' => [
                    ['time' => '27 Jan 2024 09:00', 'status' => 'Dibatalkan', 'desc' => 'Pesanan tidak dapat diproses.'],
                ]
            ]
        ]);
    }

    public function index()
    {
        $orders = $this->getDummyOrders();
        return view('mitra.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->getDummyOrders()->firstWhere('id', (int)$id);

        if (!$order) {
            abort(404);
        }

        return view('mitra.pesanan.show', compact('order'));
    }

    public function upload(Request $request, $id)
    {
        return redirect()->route('mitra.pesanan.show', $id)
            ->with('success', '[DUMMY MODE] Hasil pekerjaan berhasil disimulasikan sebagai terkirim!');
    }
}
