@extends('layouts.brandingaja')

@section('title', 'Beranda | BrandingAja')

@section('content')

<!-- ================= HERO ================= -->
<section class="bg-primary rounded-b-[60px] px-6 py-20 overflow-hidden">
    <div class="grid items-center grid-cols-1 gap-10 mx-auto max-w-7xl lg:grid-cols-2">

        <!-- TEXT (KIRI) -->
        <div class="text-center lg:text-left">
            <h1 class="mb-6 text-3xl font-bold text-white lg:text-5xl">
                Branding <span class="italic text-accent-400">Aja</span>
            </h1>

            <p class="max-w-xl mx-auto leading-relaxed text-white lg:mx-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Admin e-commerce bertanggung jawab dalam pengelolaan sistem,
                mulai dari transaksi hingga keamanan data.
            </p>
        </div>

        <!-- HERO IMAGE (KANAN) -->
        <div class="flex justify-center lg:justify-end">
            <img
                src="{{ asset('img/hero.png') }}"
                alt="Hero Image"
                class="w-full max-w-xs md:max-w-sm lg:max-w-md"
            >
        </div>

    </div>
</section>


<!-- ================= CARD 3 ================= -->
<section class="px-6 py-20 bg-gray-50">
    <div class="grid grid-cols-1 gap-8 mx-auto max-w-7xl md:grid-cols-3">

        <!-- Card 1: Jaringan -->
        <div class="bg-primary text-white rounded-3xl shadow-xl p-8 flex flex-col items-center justify-center text-center h-64">
            <div class="mb-4 text-5xl">💬</div>
            <h2 class="text-4xl font-bold">999+</h2>
            <p class="mt-2 text-xl font-medium">Jaringan</p>
        </div>

        <!-- Card 2: User -->
        <div class="bg-primary text-white rounded-3xl shadow-xl p-8 flex flex-col items-center justify-center text-center h-64">
            <div class="mb-4 text-5xl">👥</div>
            <h2 class="text-4xl font-bold">9.999+</h2>
            <p class="mt-2 text-xl font-medium">User</p>
        </div>

        <!-- Card 3: Orderan -->
        <div class="bg-primary text-white rounded-3xl shadow-xl p-8 flex flex-col items-center justify-center text-center h-64">
            <div class="mb-4 text-5xl">🛒</div>
            <h2 class="text-4xl font-bold">20.000+</h2>
            <p class="mt-2 text-xl font-medium">Orderan Diterima</p>
        </div>

    </div>
</section>


<!-- ================= VIDEO ================= -->
<section class="px-6 py-20">
    <div class="grid max-w-5xl grid-cols-1 gap-8 mx-auto md:grid-cols-2">

        <!-- Video 1 -->
        <div class="w-full overflow-hidden shadow-2xl aspect-w-1 aspect-h-1 rounded-3xl">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/x7OTyfWxJkk?si=hzy6fYkS2BR5dn5D" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <!-- Video 2 -->
        <div class="w-full overflow-hidden shadow-2xl aspect-w-1 aspect-h-1 rounded-3xl">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/x7OTyfWxJkk?si=hzy6fYkS2BR5dn5D" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

    </div>
</section>



<!-- ================= USER & JARINGAN ================= -->
<section class="px-6 py-20 bg-gray-50">
  <div class="grid grid-cols-1 gap-12 mx-auto max-w-7xl md:grid-cols-2">

    <!-- USER -->
    <div class="p-10 bg-white border border-gray-200 shadow-lg rounded-3xl">
      
      <!-- Icon -->
      <div class="flex justify-center mb-6">
        <div class="flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full">
          <!-- User Icon -->
          <svg class="w-14 h-14 text-slate-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M4.5 20.25a7.5 7.5 0 0115 0" />
          </svg>
        </div>
      </div>

      <h3 class="mb-8 text-3xl font-semibold text-center">User</h3>

      <ul class="space-y-5 text-lg text-gray-700">
        <li class="flex gap-3 pb-4 border-b">
          <span>👤</span>
          <span>Pendaftaran user baru pada sistem.</span>
        </li>
        <li class="flex gap-3 pb-4 border-b">
          <span>⚙️</span>
          <span>Manajemen akun dan data pribadi.</span>
        </li>
        <li class="flex gap-3 pb-4 border-b">
          <span>📊</span>
          <span>Monitoring aktivitas akun.</span>
        </li>
        <li class="flex gap-3 pb-4 border-b">
          <span>✏️</span>
          <span>Update profil dan preferensi.</span>
        </li>
        <li class="flex gap-3">
          <span>💬</span>
          <span>Akses bantuan dan support.</span>
        </li>
      </ul>
    </div>

    <!-- JARINGAN -->
    <div class="p-10 bg-white border border-gray-200 shadow-lg rounded-3xl">
      
      <!-- Icon -->
      <div class="flex justify-center mb-6">
        <div class="flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full">
          <!-- Network Icon -->
          <svg class="w-14 h-14 text-slate-700" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 6v6l4 2" />
            <circle cx="12" cy="12" r="9" />
          </svg>
        </div>
      </div>

      <h3 class="mb-8 text-3xl font-semibold text-center">Jaringan</h3>

      <ul class="space-y-5 text-lg text-gray-700">
        <li class="flex gap-3 pb-4 border-b">
          <span>🌐</span>
          <span>Pendaftaran jaringan baru.</span>
        </li>
        <li class="flex gap-3 pb-4 border-b">
          <span>🔗</span>
          <span>Manajemen koneksi antar user.</span>
        </li>
        <li class="flex gap-3 pb-4 border-b">
          <span>📈</span>
          <span>Monitoring aktivitas jaringan.</span>
        </li>
        <li class="flex gap-3 pb-4 border-b">
          <span>🤝</span>
          <span>Koordinasi dan kolaborasi tim.</span>
        </li>
        <li class="flex gap-3">
          <span>📑</span>
          <span>Laporan dan statistik jaringan.</span>
        </li>
      </ul>
    </div>

</section>

<!-- ================= JARINGAN KAMI ================= -->
<section class="px-6 py-28 bg-gray-50">
  <!-- TITLE -->
  <div class="flex justify-center mb-16">
    <span class="bg-primary text-white px-12 py-3 rounded-full text-sm tracking-widest shadow-md">
      JARINGAN KAMI
    </span>
  </div>

  <!-- CONTENT -->
  <div class="grid max-w-6xl grid-cols-1 gap-8 mx-auto md:grid-cols-3">
    
    <!-- CARD 1 -->
    <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
      <img
        src="{{ asset('img/jaringan/j1.png') }}"
        class="w-full h-[260px] object-cover"
        alt="Jaringan 1"
      >
    </div>

    <!-- CARD 2 -->
    <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
      <img
        src="{{ asset('img/jaringan/j2.png') }}"
        class="w-full h-[260px] object-cover"
        alt="Jaringan 2"
      >
    </div>

    <!-- CARD 3 -->
    <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
      <img
        src="{{ asset('img/jaringan/j3.png') }}"
        class="w-full h-[260px] object-cover"
        alt="Jaringan 3"
      >
    </div>

  </div>
</section>

@endsection


