<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class JaringanController extends Controller
{
    private function getUser()
    {
        return \App\Models\User::first();
    }

    public function show($id)
    {
        $user = $this->getUser();
        $mitra = \App\Models\Jaringan::with(['layanan.reviews'])->findOrFail($id);

        // Calculate average rating and count for this mitra
        $avgRating = Review::where('mitra_id', $id)->avg('rating') ?? 0;
        $reviewCount = Review::where('mitra_id', $id)->count();

        return view('user.mitra.show', compact('mitra', 'user', 'avgRating', 'reviewCount'));
    }
}
