<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
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

        return view('mitra.profil', compact('mitra'));
    }

    public function update(Request $request)
    {
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function pendapatan(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year', date('Y'));

        $riwayat = [
            ['tanggal' => '2026-01-15', 'jumlah' => 5000000, 'status' => 'berhasil', 'metode' => 'Transfer Bank'],
            ['tanggal' => '2026-01-28', 'jumlah' => 1200000, 'status' => 'berhasil', 'metode' => 'E-Wallet (OVO)'],
            ['tanggal' => '2026-02-01', 'jumlah' => 2500000, 'status' => 'berhasil', 'metode' => 'Transfer Bank'],
            ['tanggal' => '2026-02-14', 'jumlah' => 800000, 'status' => 'berhasil', 'metode' => 'E-Wallet (Dana)'],
            ['tanggal' => '2025-12-15', 'jumlah' => 7500000, 'status' => 'berhasil', 'metode' => 'Transfer Bank'],
            ['tanggal' => '2025-12-30', 'jumlah' => 1500000, 'status' => 'berhasil', 'metode' => 'Transfer Bank'],
            ['tanggal' => '2025-11-20', 'jumlah' => 3000000, 'status' => 'berhasil', 'metode' => 'Transfer Bank'],
            ['tanggal' => '2025-10-10', 'jumlah' => 2000000, 'status' => 'berhasil', 'metode' => 'Transfer Bank'],
        ];

        if ($month || $request->has('year')) {
            $riwayat = array_filter($riwayat, function($item) use ($month, $year) {
                $date = \Carbon\Carbon::parse($item['tanggal']);
                $matchYear = $date->format('Y') == $year;
                $matchMonth = $month ? $date->format('m') == $month : true;
                return $matchYear && $matchMonth;
            });
        }

        $data = (object)[
            'total_pendapatan' => 15000000,
            'saldo_tertahan' => 2500000,
            'saldo_dibayarkan' => 12500000,
            'riwayat' => $riwayat,
            'selected_month' => $month,
            'selected_year' => $year
        ];

        return view('mitra.pendapatan', compact('data'));
    }

    public function layanan()
    {
        $layanan = collect([
            (object)[
                'id' => 1,
                'nama_layanan' => 'YouTube Podcast Branding',
                'kategori' => 'Video & Animasi',
                'harga' => 1000000,
                'status' => 'aktif',
                'thumbnail' => 'https://images.unsplash.com/photo-1593697821252-0c9137d9fc45?w=500&q=80',
                'deskripsi' => 'Paket lengkap branding untuk channel podcast YouTube Anda, termasuk optimasi SEO dan desain artwork.',
                'paket' => [
                    ['nama' => '10k Views Boost', 'harga' => 150000, 'deskripsi' => 'Promosi video podcast hingga mencapai minimal 10.000 penayangan.'],
                    ['nama' => '50k Views Viral', 'harga' => 500000, 'deskripsi' => 'Promosi intensif untuk mendongkrak popularitas hingga 50.000 penayangan.'],
                    ['nama' => '100k Views Empire', 'harga' => 900000, 'deskripsi' => 'Paket premium untuk ekspansi jangkauan luas hingga 100.000 penayangan.'],
                ]
            ],
            (object)[
                'id' => 2,
                'nama_layanan' => 'Social Media Kit',
                'kategori' => 'Desain Grafis',
                'harga' => 750000,
                'status' => 'aktif',
                'thumbnail' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80',
                'deskripsi' => 'Desain konten kreatif untuk Instagram dan TikTok yang eye-catching.',
                'paket' => [
                    ['nama' => 'Basic Kit', 'harga' => 750000, 'deskripsi' => '5 Feed & 5 Story designs.'],
                    ['nama' => 'Standard Kit', 'harga' => 1200000, 'deskripsi' => '10 Feed & 10 Story designs.'],
                ]
            ],
            (object)[
                'id' => 3,
                'nama_layanan' => 'Logo & Business Card',
                'kategori' => 'Desain Grafis',
                'harga' => 1500000,
                'status' => 'nonaktif',
                'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=500&q=80',
                'deskripsi' => 'Identitas visual profesional untuk bisnis baru Anda.',
                'paket' => [
                    ['nama' => 'Starter Pack', 'harga' => 1500000, 'deskripsi' => '1 Logo Concept & Business Card design.'],
                ]
            ],
        ]);

        return view('mitra.layanan', compact('layanan'));
    }

    public function storeLayanan(Request $request)
    {
        // Simulate storage
        return back()->with('success', '[DUMMY MODE] Layanan baru berhasil disimulasikan sebagai terdaftar!');
    }
}
