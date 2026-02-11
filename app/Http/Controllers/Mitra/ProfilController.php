<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    private function getMitra($id = null)
    {
        // Prioritize ID from URL if provided, otherwise first record
        if ($id) return Mitra::findOrFail($id);
        return Mitra::first();
    }

    public function index($id = null)
    {
        $mitra = $this->getMitra($id);
        
        if (!$mitra) {
            // Minimal fallback for empty DB during dev
            $mitra = (object)[
                'nama_mitra' => 'Creative Studio',
                'deskripsi' => 'Ahli dalam desain grafis dan branding perusahaan.',
                'email' => 'studio@example.com',
                'kota' => 'Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'nama_bank' => 'BCA',
                'nomor_rekening' => '1234567890',
                'nama_pemilik_rekening' => 'Creative Studio Corp',
                'status_verifikasi' => 'terverifikasi',
            ];
        }

        return view('mitra.profil', compact('mitra'));
    }

    public function update(Request $request)
    {
        $mitra = $this->getMitra();
        if ($mitra instanceof Mitra) {
            $data = $request->except('foto_profil');

            if ($request->hasFile('foto_profil')) {
                // Delete old photo if exists
                if ($mitra->foto_profil && file_exists(public_path('uploads/profile_photos/' . $mitra->foto_profil))) {
                    unlink(public_path('uploads/profile_photos/' . $mitra->foto_profil));
                }

                $file = $request->file('foto_profil');
                $filename = 'mitra_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profile_photos'), $filename);
                $data['foto_profil'] = $filename;
            }

            $mitra->update($data);
        }
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function pendapatan(Request $request, $id = null)
    {
        $mitra = $this->getMitra($id);
        if (!$mitra) return redirect('/')->with('error', 'Mitra tidak ditemukan');

        $month = $request->query('month');
        $year = $request->query('year', date('Y'));

        // Real data from DB
        $orders = \App\Models\Order::where('mitra_id', $mitra->id)
            ->where('status', 'selesai')
            ->when($month, function($q) use ($month) {
                return $q->whereMonth('created_at', $month);
            })
            ->whereYear('created_at', $year)
            ->latest()
            ->get();

        $totalPendapatan = \App\Models\Order::where('mitra_id', $mitra->id)->where('status', 'selesai')->sum('total');
        $saldoTertahan = \App\Models\Order::where('mitra_id', $mitra->id)->where('status', '!=', 'selesai')->sum('total');

        $data = (object)[
            'total_pendapatan' => $totalPendapatan,
            'saldo_tertahan' => $saldoTertahan,
            'saldo_dibayarkan' => $totalPendapatan, // Assuming paid out for now
            'riwayat' => $orders->map(function($o) {
                return [
                    'tanggal' => $o->created_at->format('Y-m-d'),
                    'jumlah' => $o->total,
                    'status' => 'berhasil',
                    'metode' => 'Transfer Bank'
                ];
            })->toArray(),
            'selected_month' => $month,
            'selected_year' => $year
        ];

        return view('mitra.pendapatan', compact('data'));
    }

    public function layanan($id = null)
    {
        $mitra = $this->getMitra($id);
        if (!$mitra) return redirect('/')->with('error', 'Mitra tidak ditemukan');

        $layanan = \App\Models\Layanan::where('mitra_id', $mitra->id)->get();

        return view('mitra.layanan', compact('layanan', 'mitra'));
    }

    public function storeLayanan(Request $request)
    {
        $mitra = $this->getMitra();
        if (!$mitra) return response()->json(['message' => 'Mitra tidak ditemukan'], 404);

        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric',
            'estimasi_hari' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|file|image|max:2048',
            'thumbnail_url' => 'nullable|string',
            'paket' => 'nullable|array',
        ]);

        // Map packages for User marketplace compatibility
        $packages = [];
        if ($request->has('paket') && is_array($request->paket)) {
            foreach ($request->paket as $index => $pkg) {
                $key = 'pkg_' . $index;
                $packages[$key] = [
                    'label' => $pkg['nama'],
                    'price' => (float)$pkg['harga'],
                    'viewLabel' => $pkg['nama'],
                    'deskripsi' => $pkg['deskripsi'] ?? '',
                ];
            }
        }

        $thumbnailPath = 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80';
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = 'service_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/service_thumbnails'), $filename);
            $thumbnailPath = asset('uploads/service_thumbnails/' . $filename);
        } elseif ($request->filled('thumbnail_url')) {
            $thumbnailPath = $request->thumbnail_url;
        }

        \App\Models\Layanan::create([
            'mitra_id' => $mitra->id,
            'nama_layanan' => $request->nama_layanan,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $thumbnailPath,
            'harga' => $request->harga,
            'harga_json' => $packages,
            'estimasi_hari' => $request->estimasi_hari,
            'status' => 'aktif',
        ]);

        return response()->json(['message' => 'Layanan berhasil ditambahkan!']);
    }
}
