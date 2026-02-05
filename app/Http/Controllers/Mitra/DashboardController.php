<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    public function index()
    {
        // Simple mock stats for now
        $stats = [
            'total_masuk' => 12,
            'diproses' => 5,
            'selesai' => 45,
            'estimasi_pendapatan' => 12500000,
        ];

        return view('mitra.dashboard', compact('stats'));
    }
}
