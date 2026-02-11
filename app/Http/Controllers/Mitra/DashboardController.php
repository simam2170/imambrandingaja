<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getMitra($id = null)
    {
        // Prioritize ID from URL if provided, otherwise first record
        if ($id) return Mitra::findOrFail($id);
        return Mitra::first();
    }

    public function index($id = null)
    {
        $mitra = $this->getMitra($id);
        
        if (!$mitra) {
            $stats = [
                'total_masuk' => 0,
                'diproses' => 0,
                'selesai' => 0,
                'ditolak' => 0,
                'estimasi_pendapatan' => 0,
            ];
            $recentOrders = [];
            return view('mitra.dashboard', compact('stats', 'recentOrders', 'mitra'));
        }

        $stats = [
            'total_masuk' => Order::where('mitra_id', $mitra->id)->count(),
            'diproses' => Order::where('mitra_id', $mitra->id)->where('status', 'diproses')->count(),
            'selesai' => Order::where('mitra_id', $mitra->id)->where('status', 'selesai')->count(),
            'ditolak' => Order::where('mitra_id', $mitra->id)->where('status', 'ditolak')->count(),
            // Calculate revenue from completed orders
            'estimasi_pendapatan' => Order::where('mitra_id', $mitra->id)
                                        ->where('status', 'selesai')
                                        ->sum('total'),
        ];
        
        $recentOrders = Order::where('mitra_id', $mitra->id)
                            ->with(['layanan'])
                            ->latest()
                            ->take(5)
                            ->get();

        return view('mitra.dashboard', compact('stats', 'recentOrders', 'mitra'));
    }

    public function show($id)
    {
        $mitra = $this->getMitra();
        if (!$mitra) return redirect('/')->with('error', 'Mitra tidak ditemukan');

        $order = Order::where('mitra_id', $mitra->id)
                    ->with(['user', 'layanan', 'items', 'payment'])
                    ->findOrFail($id);

        return view('mitra.pesanan.show', compact('order', 'mitra'));
    }
}
