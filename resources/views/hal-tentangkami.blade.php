@extends('layouts.brandingaja')

@section('title', 'Beranda | BrandingAja')

@section('content')

{{-- ================= HERO TENTANG KAMI ================= --}}
<section class="bg-[#08b3ad] min-h-screen px-6 py-32 text-white">
  <div class="grid items-center grid-cols-1 gap-16 mx-auto max-w-7xl lg:grid-cols-2">

    <div class="flex justify-center">
      <img src="{{ asset('img/hero.png') }}"
           class="w-full max-w-md drop-shadow-2xl"
           alt="Tentang BrandinginAja">
    </div>

    <div>
      <h1 class="mb-6 text-5xl font-bold">s
        Tentang <span class="italic text-yellow-400">Kami</span>
      </h1>

      <p class="mb-4 leading-relaxed opacity-90">
        Admin e-commerce bertanggung jawab dalam mengelola seluruh sistem
        operasional toko online, mulai dari pengaturan produk, pengelolaan stok,
        hingga pemrosesan transaksi penjualan agar berjalan dengan lancar,
        aman, dan efisien.
      </p>

      <p class="leading-relaxed opacity-80">
        Selain itu, admin memastikan informasi produk selalu akurat dan terbaru,
        menangani pesanan pelanggan, memantau pembayaran, serta berkoordinasi
        dengan tim terkait untuk menjaga kualitas layanan dan meningkatkan
        kepercayaan pelanggan secara berkelanjutan.
      </p>
    </div>

  </div>
</section>

{{-- ================= DETAIL TENTANG KAMI ================= --}}
<section class="px-6 py-24 bg-gray-50">
  <div class="grid grid-cols-1 gap-10 mx-auto max-w-7xl md:grid-cols-2 lg:grid-cols-3">

    <!-- VISI -->
    <div class="p-8 transition bg-white shadow rounded-2xl hover:shadow-lg">
      <h2 class="text-2xl font-bold mb-4 text-[#08b3ad]">
        Visi Kami
      </h2>
      <p class="leading-relaxed text-gray-700">
        Menjadi platform digital terpercaya yang menghubungkan user dan jaringan
        profesional untuk mendorong pertumbuhan bisnis, kreativitas, dan
        kolaborasi di era digital.
      </p>
    </div>

    <!-- MISI -->
    <div class="p-8 transition bg-white shadow rounded-2xl hover:shadow-lg">
      <h2 class="text-2xl font-bold mb-4 text-[#08b3ad]">
        Misi Kami
      </h2>
      <ul class="space-y-2 text-gray-700 list-disc list-inside">
        <li>Menyediakan sistem manajemen user dan jaringan yang mudah digunakan</li>
        <li>Meningkatkan kepercayaan dan transparansi ekosistem digital</li>
        <li>Mendukung pertumbuhan bisnis melalui teknologi modern</li>
        <li>Menghadirkan layanan yang aman, stabil, dan berkelanjutan</li>
      </ul>
    </div>

    <!-- WHY -->
    <div class="bg-[#08b3ad] text-white rounded-2xl p-8 shadow-lg">
      <h2 class="mb-4 text-2xl font-bold text-white ">
        Mengapa BrandingAja?
      </h2>
      <p class="leading-relaxed text-white opacity-90">
        Dengan dukungan teknologi terkini dan tim profesional,
        BrandingAja hadir sebagai solusi terpadu bagi user,
        jaringan, dan mitra untuk tumbuh bersama dalam ekosistem
        digital yang sehat dan terpercaya.
      </p>
    </div>

  </div>
</section>

@endsection

