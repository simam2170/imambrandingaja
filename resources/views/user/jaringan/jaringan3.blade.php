@extends('layouts.user')
@section('title', 'Jaringan Gamma')
@section('content')

    <div class="max-w-7xl mx-auto space-y-8">

        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500">
            <a href="/user/dashboard" class="hover:text-primary transition-colors">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">Jaringan Gamma</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- LEFT COLUMN: PROVIDER INFO --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-28 self-start">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full mb-4 overflow-hidden border-4 border-white shadow-md relative">
                         <img src="{{ asset('img/jaringan/jaringan3.png') }}" class="w-full h-full object-contain p-2">
                    </div>
                    
                    <h1 class="text-xl font-bold text-gray-900">Jaringan Gamma</h1>
                    <p class="text-gray-500 text-sm mt-1">Video Production</p>
                    
                    <div class="flex items-center justify-center gap-1 mt-3">
                         <div class="flex text-accent">
                            @for($i=0; $i<5; $i++) <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                         </div>
                         <span class="text-gray-600 font-semibold text-sm">4.9</span>
                         <span class="text-gray-400 text-sm">(200+ Reviews)</span>
                    </div>

                    <div class="mt-6 flex flex-col gap-3">
                        <button class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Hubungi Kami
                        </button>
                    </div>
                </div>

                <!-- About Card -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h3 class="mb-4 font-bold text-gray-900">Tentang Kami</h3>
                    <p class="text-sm leading-relaxed text-gray-600">
                        Kami adalah agensi branding yang berfokus pada pertumbuhan digital. Melayani pembuatan konten sosial media, liputan berita, dan strategi branding korporat. Tim kami terdiri dari profesional berpengalaman di bidang media.
                    </p>
                </div>
            </div>

            {{-- RIGHT COLUMN: SERVICES --}}
            <div class="lg:col-span-2 space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="bg-green-100 text-primary p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        Layanan Video Branding
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-gray-200 hover:shadow-md transition-all group flex flex-col">
                             <div class="flex items-start justify-between mb-2">
                                  <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Video Company Profile</h3>
                                 <span class="text-primary font-bold bg-primary/10 px-2 py-1 rounded text-xs">Rp 1.000k</span>
                             </div>
                             <p class="text-sm text-gray-500 mb-4 flex-1">
                                 Pembuatan video profil perusahaan profesional dengan kualitas sinematik.
                             </p>
                             <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                                 <span class="text-xs text-gray-400">⏱️ 7 Hari Kerja</span>
                                 <button class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition shadow-lg shadow-primary-light">
                                     Pesan Sekarang
                                 </button>
                             </div>
                        </div>
                        
                    </div>
                </div>
                 {{-- BERITA --}}
                <div>
                    <h2 class="flex items-center gap-2 mb-4 text-xl font-bold text-gray-900">
                        <span class="p-2 text-blue-600 bg-blue-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </span>
                        Publikasi & Berita
                    </h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @for ($i = 1; $i <= 2; $i++)
                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-blue-600">Liputan
                                        Khusus / Press Release</h3>
                                    <span class="px-2 py-1 text-xs font-bold text-blue-600 rounded bg-blue-50">Rp 1.500k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Publikasi artikel berita di portal nasional. Termasuk penulisan draft dan revisi 2x.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 2 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
