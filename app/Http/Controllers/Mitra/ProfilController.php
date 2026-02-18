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
        if ($id)
            return Mitra::findOrFail($id);
        return Mitra::first();
    }

    public function index($id = null)
    {
        $mitra = $this->getMitra($id);

        if (!$mitra) {
            // Minimal fallback for empty DB during dev
            $mitra = (object) [
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


    public function layanan($id = null)
    {
        $mitra = $this->getMitra($id);
        if (!$mitra)
            return redirect('/')->with('error', 'Mitra tidak ditemukan');

        $layanan = \App\Models\Layanan::where('mitra_id', $mitra->id)->get();

        return view('mitra.layanan', compact('layanan', 'mitra'));
    }

    public function storeLayanan(Request $request)
    {
        $mitra = $this->getMitra();
        if (!$mitra)
            return response()->json(['message' => 'Mitra tidak ditemukan'], 404);

        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'klasifikasi' => 'required|string|in:berita,sosmed,ads_digital,consulting',
            'estimasi_hari' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'thumbnail' => 'nullable|file|image|max:2048',
            'thumbnail_url' => 'nullable|string',
            'detail_klasifikasi' => 'nullable|array',
        ]);

        // Auto-generate packages from detail_klasifikasi entries
        $packages = [];
        $detailData = $request->detail_klasifikasi ?? [];
        $tipeEntries = $detailData['tipe'] ?? [];
        $platformPricing = $detailData['platform_pricing'] ?? [];
        $prices = [];

        // Handle platform specific pricing
        foreach ($platformPricing as $platform => $list) {
            foreach ($list as $index => $tipe) {
                $nama = $tipe['nama'] ?? '';
                $harga = (float) ($tipe['harga'] ?? 0);

                if (!empty($nama) && $harga > 0) {
                    $key = 'pkg_' . md5($platform . $nama . $index);
                    $packages[$key] = [
                        'label' => "$platform - $nama",
                        'price' => $harga,
                        'viewLabel' => "$platform - $nama",
                        'deskripsi' => '',
                    ];
                    $prices[] = $harga;
                }
            }
        }

        // Handle regular tipe entries
        foreach ($tipeEntries as $index => $tipe) {
            $nama = $tipe['nama'] ?? '';
            $harga = (float) ($tipe['harga'] ?? 0);

            if (!empty($nama) && $harga > 0) {
                $key = 'tipe_' . $index;
                $packages[$key] = [
                    'label' => $nama,
                    'price' => $harga,
                    'viewLabel' => $nama,
                    'deskripsi' => '',
                ];
                $prices[] = $harga;
            }
        }

        // Base harga = minimum of all tipe prices, or from request
        $baseHarga = count($prices) > 0 ? min($prices) : ($request->harga ?? 0);

        $thumbnailPath = 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80';
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = 'service_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/service_thumbnails'), $filename);
            $thumbnailPath = asset('uploads/service_thumbnails/' . $filename);
        } elseif ($request->filled('thumbnail_url')) {
            $thumbnailPath = $request->thumbnail_url;
        }

        // Map klasifikasi to kategori label
        $kategoriMap = [
            'berita' => 'Berita',
            'sosmed' => 'Sosial Media',
            'ads_digital' => 'Ads Digital',
            'consulting' => 'Consulting',
        ];

        \App\Models\Layanan::create([
            'mitra_id' => $mitra->id,
            'nama_layanan' => $request->nama_layanan,
            'klasifikasi' => $request->klasifikasi,
            'kategori' => $kategoriMap[$request->klasifikasi] ?? $request->klasifikasi,
            'deskripsi' => $request->deskripsi,
            'thumbnail' => $thumbnailPath,
            'harga' => $baseHarga,
            'harga_json' => $packages,
            'detail_klasifikasi' => $detailData,
            'estimasi_hari' => $request->estimasi_hari,
            'status' => 'aktif',
        ]);

        return response()->json(['message' => 'Layanan berhasil ditambahkan!']);
    }
}
