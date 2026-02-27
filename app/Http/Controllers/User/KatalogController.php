<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\User;

class KatalogController extends Controller
{
    private function getUser($id = null)
    {
        if ($id)
            return User::find($id);
        return User::first();
    }

    public function index(Request $request)
    {
        $user = $this->getUser();

        // 1. Fetch available filter categories dynamically from 'detail_klasifikasi' JSON
        $allLayanan = Layanan::all();
        $uniqueCategories = [];
        $categoryKeys = ['jenis_konten', 'jenis_layanan', 'jenis_campaign', 'format'];

        foreach ($allLayanan as $layanan) {
            $info = $layanan->detail_klasifikasi['info'] ?? [];
            foreach ($categoryKeys as $key) {
                if (isset($info[$key]) && is_array($info[$key])) {
                    foreach ($info[$key] as $val) {
                        $uniqueCategories[$val] = true;
                    }
                }
            }
        }

        $filterCategories = array_keys($uniqueCategories);
        sort($filterCategories);

        // 2. Filter logic based on request
        $selectedCategory = $request->get('kategori');

        $query = Layanan::with(['mitra', 'reviews'])
            ->withCount([
                'reviews',
                'orders as sold_count' => function ($q) {
                    $q->where('status', 'selesai');
                }
            ])
            ->withAvg('reviews', 'rating')
            ->where('status', 'aktif');

        if ($selectedCategory && $selectedCategory !== 'Semua') {
            $query->where(function ($q) use ($selectedCategory, $categoryKeys) {
                foreach ($categoryKeys as $key) {
                    $q->orWhereJsonContains("detail_klasifikasi->info->{$key}", $selectedCategory);
                }
                // Fallback text search
                $q->orWhere('kategori', 'LIKE', '%' . $selectedCategory . '%')
                    ->orWhere('klasifikasi', 'LIKE', '%' . $selectedCategory . '%')
                    ->orWhere('nama_layanan', 'LIKE', '%' . $selectedCategory . '%');
            });
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('user.katalog.index', compact('services', 'filterCategories', 'selectedCategory', 'user'));
    }
}
