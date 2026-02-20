<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Layanan;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
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
        $user = $this->getUser($id);
        if (!$user)
            return redirect('/')->with('error', 'No user found');

        $orders = Order::where('user_id', $user->id)
            ->with(['layanan', 'mitra', 'payment'])
            ->latest()
            ->get()
            ->groupBy('status');

        return view('user.pesanan', compact('orders', 'user'));
    }

    public function store(Request $request)
    {
        $user = $this->getUser();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan. Silakan login.'
            ], 401);
        }

        $items = $request->input('items');
        if (is_string($items)) {
            $items = json_decode($items, true);
        }

        if (empty($items)) {
            return response()->json([
                'message' => 'Keranjang kosong. Silakan tambahkan layanan terlebih dahulu.'
            ], 400);
        }

        // Get selected payment from request
        $paymentData = $request->input('payment');
        if (is_string($paymentData)) {
            $paymentData = json_decode($paymentData, true);
        }
        $metodePembayaran = $paymentData['id'] ?? 'bank_transfer';

        $orders = [];

        try {
            foreach ($items as $item) {
                $layananId = $item['id'] ?? $item['serviceId'] ?? null;
                if (!$layananId)
                    continue;

                $layanan = Layanan::find($layananId);
                if (!$layanan)
                    continue;

                $orderNumber = 'ORD-' . strtoupper(Str::random(10));
                $totalHarga = $item['price'] * $item['qty'];

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => $user->id,
                    'mitra_id' => $layanan->mitra_id,
                    'layanan_branding_id' => $layanan->id,
                    'paket' => $item['pkgLabel'] ?? $item['pkg'] ?? 'Standard',
                    'jumlah' => $item['qty'],
                    'total_harga' => $totalHarga,
                    'status' => 'menunggu_pembayaran',
                    'total' => $totalHarga,
                    'metode_pembayaran' => $metodePembayaran,
                    'expired_at' => now()->addHour(),
                    'catatan' => $request->input('user.note', '-'),
                ]);

                OrderItem::create([
                    'pesanan_id' => $order->id,
                    'layanan_id' => $layanan->id,
                    'jenis_layanan' => $item['pkgLabel'] ?? $item['pkg'] ?? 'Standard',
                    'qty' => $item['qty'],
                    'harga' => $item['price'],
                ]);

                $orders[] = $order;
            }
        } catch (\Throwable $e) {
            Log::error('Checkout Error: ' . $e->getMessage(), [
                'exception' => $e,
                'items' => $items,
                'user' => $user
            ]);
            return response()->json([
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }

        if (empty($orders)) {
            return response()->json([
                'message' => 'Tidak ada pesanan yang dapat dibuat.'
            ], 400);
        }

        // Redirect to the first order's invoice
        return response()->json([
            'message' => 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.',
            'orders' => $orders,
            'redirect_url' => route('user.invoice', $orders[0]->id)
        ]);
    }

    public function show($id)
    {
        $user = $this->getUser();
        $order = Order::where('user_id', $user->id)
            ->with(['layanan', 'mitra', 'payment', 'items.layanan'])
            ->findOrFail($id);

        return view('user.invoice', compact('order', 'user'));
    }

    public function cancel($id)
    {
        $user = $this->getUser();
        $order = Order::where('user_id', $user->id)->findOrFail($id);

        if (in_array($order->status, ['menunggu_pembayaran', 'direview'])) {
            $order->update(['status' => 'dibatalkan']); // Updates to 'dibatalkan'
            return redirect()->back()->with('success', 'Pesanan dibatalkan.');
        }

        return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
    }
}
