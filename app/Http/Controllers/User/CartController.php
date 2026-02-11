<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getUser()
    {
        return \App\Models\User::first();
    }

    public function index()
    {
        $user = $this->getUser();
        $cartItems = [];
        
        if ($user) {
            $cartItems = CartItem::where('user_id', $user->id)
                ->with(['layanan', 'mitra'])
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'serviceId' => $item->layanan_id,
                        'name' => $item->layanan->nama_layanan ?? 'Layanan',
                        'price' => (float)$item->price,
                        'qty' => $item->qty,
                        'seller' => $item->mitra->nama_mitra ?? 'Mitra',
                        'mitraId' => $item->mitra_id,
                        'pkgLabel' => $item->pkg_label,
                        'checked' => true,
                        'thumbnail' => $item->layanan->thumbnail ?? 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80',
                        'views' => '-',
                    ];
                });
        }
        
        return view('user.keranjang', compact('cartItems', 'user'));
    }

    public function store(Request $request)
    {
        $user = $this->getUser();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 401);

        $request->validate([
            'layanan_id' => 'required|exists:layanan_branding,id',
            'qty' => 'required|integer|min:1',
            'pkg' => 'nullable|string',
            'price' => 'required|numeric'
        ]);

        $layanan = Layanan::find($request->layanan_id);

        $cartItem = CartItem::updateOrCreate(
            [
                'user_id' => $user->id,
                'layanan_id' => $request->layanan_id,
                'pkg_label' => $request->pkg
            ],
            [
                'mitra_id' => $layanan->mitra_id,
                'qty' => $request->qty,
                'price' => $request->price
            ]
        );

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang', 'cartItem' => $cartItem]);
    }

    public function update(Request $request, $id)
    {
        $user = $this->getUser();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 401);

        $cartItem = CartItem::where('user_id', $user->id)->findOrFail($id);
        $cartItem->update(['qty' => $request->qty]);

        return response()->json(['message' => 'Quantity updated']);
    }

    public function destroy($id)
    {
        $user = $this->getUser();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 401);

        $cartItem = CartItem::where('user_id', $user->id)->findOrFail($id);
        $cartItem->delete();

        return response()->json(['message' => 'Item dihapus']);
    }
}
