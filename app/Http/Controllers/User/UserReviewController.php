<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function store(Request $request, $orderId)
    {
        // Get the user (using same pattern as UserOrderController)
        $user = \App\Models\User::first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Load the order, ensure it belongs to this user
        $order = Order::where('user_id', $user->id)
            ->with(['layanan'])
            ->findOrFail($orderId);

        // Validate: order must be selesai
        if ($order->status !== 'selesai') {
            return redirect()->back()->with('error', 'Hanya pesanan yang sudah selesai yang dapat direview.');
        }

        // Validate: not already reviewed
        if ($order->reviewed_at !== null) {
            return redirect()->back()->with('error', 'Pesanan ini sudah pernah direview.');
        }

        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Create review
        Review::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'mitra_id' => $order->mitra_id,
            'layanan_id' => $order->layanan_branding_id,
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? null,
        ]);

        // Mark order as reviewed
        $order->update(['reviewed_at' => now()]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan. ⭐');
    }
}
