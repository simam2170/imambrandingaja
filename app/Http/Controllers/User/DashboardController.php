<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Mitra;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getUser($id = null)
    {
        // Prioritize ID from URL if provided, otherwise first record
        if ($id)
            return User::findOrFail($id);
        return User::first();
    }

    public function index($id = null)
    {
        // Popular/Featured services
        $popularServices = Layanan::with(['mitra', 'reviews'])->inRandomOrder()->take(5)->get();
        $marketplaceServices = Layanan::with(['mitra', 'reviews'])->latest()->get();
        $featuredMitra = Mitra::inRandomOrder()->first();
        $mitraList = Mitra::with(['layanan'])->take(6)->get();

        // Recent orders for widget
        $recentOrders = [];
        $user = $this->getUser($id);

        if ($user) {
            $recentOrders = Order::where('user_id', $user->id)->latest()->take(3)->get();
        }

        return view('user.dashboard', compact('popularServices', 'marketplaceServices', 'featuredMitra', 'mitraList', 'recentOrders', 'user'));
    }
}
