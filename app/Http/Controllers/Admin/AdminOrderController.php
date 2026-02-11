<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'mitra', 'layanan'])
                    ->where('status', '!=', 'menunggu_pembayaran')
                    ->latest()
                    ->get();
        return view('admin.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'mitra', 'layanan', 'payment', 'items'])->findOrFail($id);
        return view('admin.pesanan.show', compact('order'));
    }

    public function verifyPayment($id, $status)
    {
        $order = Order::findOrFail($id);
        
        // Allowed statuses from admin: diproses, ditolak
        if (in_array($status, ['diproses', 'ditolak'])) {
            $order->update(['status' => $status]);
            
            // If there is an old payment record, sync it for backward compatibility
            if ($order->payment) {
                $payStatus = ($status == 'diproses') ? 'diterima' : 'ditolak';
                $order->payment->update(['status' => $payStatus]);
            }

            return redirect()->back()->with('success', 'Status pesanan diperbarui menjadi ' . $status);
        }

        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    public function uploadPayoutProof(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'selesai') {
            return redirect()->back()->with('error', 'Pesanan belum selesai pengerjaannya oleh Mitra.');
        }

        $request->validate([
            'bukti_transfer_mitra' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer_mitra')) {
            $file = $request->file('bukti_transfer_mitra');
            $filename = 'transfer_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/payouts'), $filename);
            
            $order->update([
                'bukti_transfer_mitra' => $filename
            ]);

            return redirect()->back()->with('success', 'Bukti transfer ke Mitra telah diupload.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti transfer.');
    }
}
