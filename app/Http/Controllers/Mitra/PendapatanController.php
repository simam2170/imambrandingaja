<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PendapatanController extends Controller
{
    /**
     * Helper to get current mitra.
     * During dev, falls back to first mitra if no auth.
     */
    private function getMitra($id = null)
    {
        if ($id)
            return Mitra::findOrFail($id);
        return Auth::guard('mitra')->user() ?? Mitra::first();
    }

    public function index(Request $request, $id = null)
    {
        $mitra = $this->getMitra($id);
        if (!$mitra)
            return redirect('/')->with('error', 'Mitra tidak ditemukan');

        $month = $request->query('month');
        $year = $request->query('year', date('Y'));

        // Query base for completed orders with filters applied
        $query = Order::where('mitra_id', $mitra->id)
            ->where('status', 'selesai')
            ->when($month, function ($q) use ($month) {
                return $q->whereMonth('created_at', $month);
            })
            ->whereYear('created_at', $year);

        // Fetch history table (only for items that have been paid)
        $historyOrders = (clone $query)
            ->whereNotNull('bukti_transfer_mitra')
            ->latest()
            ->get();

        // Calculate stats based on filtered query
        $totalPendapatan = (clone $query)->sum('total');
        $saldoTertahan = (clone $query)->whereNull('bukti_transfer_mitra')->sum('total');
        $saldoDibayarkan = (clone $query)->whereNotNull('bukti_transfer_mitra')->sum('total');

        // Get latest payout date if exists
        $latestPayout = (clone $query)->whereNotNull('bukti_transfer_mitra')->latest()->first();

        $data = (object) [
            'total_pendapatan' => $totalPendapatan,
            'saldo_tertahan' => $saldoTertahan,
            'saldo_dibayarkan' => $saldoDibayarkan,
            'terakhir_dibayar' => $latestPayout ? $latestPayout->updated_at->format('d M Y') : '-',
            'riwayat' => $historyOrders->map(function ($o) {
                return [
                    'tanggal' => $o->updated_at->format('Y-m-d'), // Use updated_at as payout time
                    'jumlah' => $o->total,
                    'status' => 'Berhasil',
                    'metode' => 'Transfer Bank',
                    'bukti' => $o->bukti_transfer_mitra
                ];
            })->toArray(),
            'selected_month' => $month,
            'selected_year' => $year
        ];

        return view('mitra.pendapatan', compact('data', 'mitra'));
    }
}
