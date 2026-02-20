<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Review;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    private function getUser()
    {
        return \App\Models\User::first();
    }

    public function show($id)
    {
        $user = $this->getUser();
        $layanan = Layanan::with(['mitra', 'reviews.user'])->findOrFail($id);

        // Calculate average rating and review count
        $avgRating = $layanan->reviews()->avg('rating') ?? 0;
        $reviewCount = $layanan->reviews()->count();

        // Default packages if harga_json is null
        $packages = [
            '10k' => ['label' => '10K', 'price' => 100000, 'viewLabel' => '10.000 Views'],
            '50k' => ['label' => '50K', 'price' => 450000, 'viewLabel' => '50.000 Views'],
            '100k' => ['label' => '100K', 'price' => 800000, 'viewLabel' => '100.000 Views']
        ];

        return view('user.layanan.show', compact('layanan', 'packages', 'user', 'avgRating', 'reviewCount'));
    }
}
