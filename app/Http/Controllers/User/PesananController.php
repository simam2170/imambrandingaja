<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        // Dummy data for frontend focus
        $orders = collect([
            (object)[
                'id' => 1,
                'order_number' => 'ORD-001',
                'status' => 'diproses',
                'layanan' => (object)['nama_layanan' => 'YouTube Podcast Branding', 'harga' => 1000000]
            ],
            (object)[
                'id' => 2,
                'order_number' => 'ORD-002',
                'status' => 'direview',
                'layanan' => (object)['nama_layanan' => 'Logo Design Business', 'harga' => 500000]
            ],
            (object)[
                'id' => 3,
                'order_number' => 'ORD-003',
                'status' => 'selesai',
                'layanan' => (object)['nama_layanan' => 'Banner Toko Online', 'harga' => 250000]
            ],
            (object)[
                'id' => 4,
                'order_number' => 'ORD-004',
                'status' => 'ditolak',
                'layanan' => (object)['nama_layanan' => 'Social Media Kit', 'harga' => 750000]
            ]
        ])->groupBy('status');

        return view('user.pesanan', compact('orders'));
    }
}
