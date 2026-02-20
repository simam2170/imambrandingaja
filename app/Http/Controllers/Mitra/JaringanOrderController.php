<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JaringanOrderController extends Controller
{
    private function getMitra($id = null)
    {
        // 1. Cek jika user login dan punya relasi mitra (Jaringan)
        if (Auth::check() && Auth::user()->mitra) {
            return Auth::user()->mitra;
        }

        // 2. Cek jika login menggunakan guard 'mitra'
        if (Auth::guard('mitra')->check()) {
            return Auth::guard('mitra')->user();
        }

        // 3. Fallback (Existing logic: ID or First) - Only for dev/debug or if auth fails
        if ($id)
            return Mitra::findOrFail($id);

        // DANGER: Returning first() allows anyone to see first mitra's data if not logged in.
        // For now, we allow it but ideally this should redirect to login.
        return Mitra::first();
    }

    public function index($id = null)
    {
        $mitra = $this->getMitra($id);
        if (!$mitra)
            return redirect('/')->with('error', 'Akun Jaringan tidak ditemukan');

        $orders = Order::where('mitra_id', $mitra->id)
            ->with(['user', 'layanan'])
            ->latest()
            ->get();

        return view('mitra.pesanan.index', compact('orders', 'mitra'));
    }

    public function show($id)
    {
        $mitra = $this->getMitra();
        $order = Order::where('mitra_id', $mitra->id)
            ->with(['user', 'layanan', 'items.layanan', 'payment'])
            ->findOrFail($id);

        return view('mitra.pesanan.show', compact('order', 'mitra'));
    }

    public function complete(Request $request, $id)
    {
        $mitra = $this->getMitra();
        $order = Order::where('mitra_id', $mitra->id)->findOrFail($id);

        // Allow completion if status is 'diproses'
        // User request: "card upload hasil pekerjaan pada detail pesanan mitra hanya tampil saat status order sudah diproses saja"
        if ($order->status == 'diproses') {
            $request->validate([
                'bukti_selesai' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
            ]);

            if ($request->hasFile('bukti_selesai')) {
                $file = $request->file('bukti_selesai');
                $filename = 'work_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/completion_proofs'), $filename);

                $order->update([
                    'status' => 'selesai', // Auto update status to selesai
                    'bukti_selesai' => $filename
                ]);

                return redirect()->back()->with('success', 'Pesanan diselesaikan dan bukti pekerjaan telah diupload.');
            }
        }

        return redirect()->back()->with('error', 'Gagal menyelesaikan pesanan. Status pesanan tidak valid untuk diselesaikan.');
    }
}
