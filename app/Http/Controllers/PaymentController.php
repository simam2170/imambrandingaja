<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function upload(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $order = Order::findOrFail($id);

        if ($order->isExpired() && !$order->bukti_pembayaran) {
            return response()->json(['message' => 'Maaf, waktu pembayaran telah habis.'], 403);
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = 'pay_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/payments'), $filename);
            
            // Update Order directly (as used in previous logic)
            $order->update([
                'bukti_pembayaran' => $filename,
                'status' => 'direview' // Ensure it's in review
            ]);

            // Sync with Payment table if needed for historical records
            Payment::updateOrCreate(
                ['pesanan_id' => $order->id],
                [
                    'metode_pembayaran' => $order->metode_pembayaran ?? 'bank_transfer',
                    'bukti_pembayaran' => $filename,
                    'total_bayar' => $order->total,
                    'status' => 'menunggu',
                    'tanggal_bayar' => now(),
                ]
            );

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Bukti pembayaran berhasil diupload!']);
            }

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload!');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }
}
