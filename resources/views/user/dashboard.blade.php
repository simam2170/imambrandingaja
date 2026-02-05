@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

    <div class="max-w-7xl mx-auto space-y-10">
        
        {{-- WELCOME SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-500 mt-2">Selamat datang kembali! Kelola pesanan dan temukan layanan terbaik.</p>
            </div>
            {{-- OPTIONAL: Add Date or Quick Action --}}
        </div>

        {{-- QUICK STATS / MENU --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- PROFIL CARD --}}
            <a href="/user/profile" 
               class="group p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-all hover:shadow-md hover:border-primary/50 flex flex-col items-center justify-center gap-4 text-center cursor-pointer relative overflow-hidden">
                <div class="p-4 bg-primary/10 text-primary rounded-full group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-5.5-2.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10 12a5.99 5.99 0 0 0-4.793 2.39A6.483 6.483 0 0 0 10 16.5a6.483 6.483 0 0 0 4.793-2.11A5.99 5.99 0 0 0 10 12Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-primary transition-colors">Profil Saya</h3>
                    <p class="text-sm text-gray-500 mt-1">Update informasi & preferensi</p>
                </div>
                <div class="absolute right-6 opacity-0 group-hover:opacity-100 transition-opacity text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </a>

            {{-- PESANAN SAYA CARD --}}
            <a href="/user/pesanan" 
               class="group p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-all hover:shadow-md hover:border-primary/50 flex flex-col items-center justify-center gap-4 text-center cursor-pointer relative overflow-hidden">
                <div class="p-4 bg-green-50 text-green-600 rounded-full group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8">
                        <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V8.75a.75.75 0 0 1 1.5 0V10a4 4 0 0 1-8 0V8.75a.75.75 0 0 1 1.5 0V10Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-primary transition-colors">Pesanan Saya</h3>
                    <p class="text-sm text-gray-500 mt-1">Lihat status & riwayat order</p>
                </div>
                 <div class="absolute right-6 opacity-0 group-hover:opacity-100 transition-opacity text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </a>

            {{-- KERANJANG CARD --}}
            <a href="/user/keranjang" 
               class="group p-6 bg-white rounded-xl shadow-sm border border-gray-100 transition-all hover:shadow-md hover:border-yellow-400 flex flex-col items-center justify-center gap-4 text-center cursor-pointer relative overflow-hidden">
                <div class="p-4 bg-yellow-50 text-yellow-600 rounded-full group-hover:bg-yellow-400 group-hover:text-gray-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8">
                        <path d="M1 1.75A.75.75 0 0 1 1.75 1h1.628a1.75 1.75 0 0 1 1.734 1.51L5.18 3a65.25 65.25 0 0 1 13.36 1.412.75.75 0 0 1 .58.875 48.645 48.645 0 0 1-1.618 6.2.75.75 0 0 1-.712.513H6a2.503 2.503 0 0 0-2.292 1.5H17.25a.75.75 0 0 1 0 1.5H2.76a.75.75 0 0 1-.748-.807 4.002 4.002 0 0 1 2.716-3.486L3.626 2.716a.25.25 0 0 0-.248-.216H1.75A.75.75 0 0 1 1 1.75ZM6 17.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 19a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-yellow-600 transition-colors">Keranjang Belanja</h3>
                    <p class="text-sm text-gray-500 mt-1">Lihat layanan tersimpan</p>
                </div>
                <div class="absolute right-6 opacity-0 group-hover:opacity-100 transition-opacity text-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </div>
            </a>

        </div>

        {{-- MARKETPLACE SECTION (Merged from Order Layanan) --}}
        <div class="pt-8 border-t border-gray-100 space-y-6">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                 <div>
                    <h2 class="text-2xl font-bold text-gray-800">Marketplace Layanan</h2>
                    <p class="text-gray-500">Temukan jaringan terbaik untuk kebutuhan branding Anda.</p>
                </div>

                {{-- SEARCH --}}
                <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 w-full md:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari layanan..." class="bg-transparent border-none focus:ring-0 text-sm w-full md:w-64">
                    <button class="text-sm font-semibold text-primary hover:text-green-700">Cari</button>
                </div>
            </div>

             {{-- GRID LAYANAN (MANUAL / HARDCODED CARDS) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- CARD 1: Jaringan 1 --}}
                <a href="/user/jaringan/jaringan1" class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <div class="h-40 bg-gray-100 flex items-center justify-center p-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('img/jaringan/jaringan1.png') }}" alt="Jaringan Alpha" class="object-contain w-full h-full transform group-hover:scale-105 transition-transform duration-300 mix-blend-multiply">
                    </div>
                    <div class="px-4 pt-3 flex items-center gap-2">
                         <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                             <img src="https://ui-avatars.com/api/?name=Jaringan+Alpha&background=random" class="w-full h-full object-cover">
                         </div>
                         <span class="text-xs font-semibold text-gray-700">Jaringan Alpha</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">
                           Layanan Branding Profesional oleh Jaringan Alpha
                        </h3>
                        <div class="flex items-center gap-1 mb-3">
                            <span class="text-accent text-sm font-bold">★</span>
                            <span class="font-bold text-gray-800 text-sm">5.0</span>
                            <span class="text-gray-400 text-sm">(120)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400 uppercase font-semibold">Mulai Dari</span>
                            <span class="text-gray-800 font-bold">Rp 500k</span>
                        </div>
                    </div>
                </a>

                {{-- CARD 2: Jaringan 2 --}}
                <a href="/user/jaringan/jaringan2" class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <div class="h-40 bg-gray-100 flex items-center justify-center p-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('img/jaringan/jaringan2.png') }}" alt="Jaringan Beta" class="object-contain w-full h-full transform group-hover:scale-105 transition-transform duration-300 mix-blend-multiply">
                    </div>
                    <div class="px-4 pt-3 flex items-center gap-2">
                         <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                             <img src="https://ui-avatars.com/api/?name=Jaringan+Beta&background=random" class="w-full h-full object-cover">
                         </div>
                         <span class="text-xs font-semibold text-gray-700">Jaringan Beta</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">
                           Solusi Kreatif Multimedia & Desain oleh Jaringan Beta
                        </h3>
                        <div class="flex items-center gap-1 mb-3">
                            <span class="text-accent text-sm font-bold">★</span>
                            <span class="font-bold text-gray-800 text-sm">4.8</span>
                            <span class="text-gray-400 text-sm">(85)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400 uppercase font-semibold">Mulai Dari</span>
                            <span class="text-gray-800 font-bold">Rp 300k</span>
                        </div>
                    </div>
                </a>

                {{-- CARD 3: Jaringan 3 --}}
                <a href="/user/jaringan/jaringan3" class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <div class="h-40 bg-gray-100 flex items-center justify-center p-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('img/jaringan/jaringan3.png') }}" alt="Jaringan Gamma" class="object-contain w-full h-full transform group-hover:scale-105 transition-transform duration-300 mix-blend-multiply">
                    </div>
                    <div class="px-4 pt-3 flex items-center gap-2">
                         <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                             <img src="https://ui-avatars.com/api/?name=Jaringan+Gamma&background=random" class="w-full h-full object-cover">
                         </div>
                         <span class="text-xs font-semibold text-gray-700">Jaringan Gamma</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">
                           Video Production & Corporate Branding oleh Jaringan Gamma
                        </h3>
                        <div class="flex items-center gap-1 mb-3">
                            <span class="text-accent text-sm font-bold">★</span>
                            <span class="font-bold text-gray-800 text-sm">4.9</span>
                            <span class="text-gray-400 text-sm">(200+)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400 uppercase font-semibold">Mulai Dari</span>
                            <span class="text-gray-800 font-bold">Rp 1jt</span>
                        </div>
                    </div>
                </a>

                {{-- CARD 4: Jaringan 4 --}}
                <a href="/user/jaringan/jaringan4" class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <div class="h-40 bg-gray-100 flex items-center justify-center p-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <img src="{{ asset('img/jaringan/jaringan3.png') }}" alt="Jaringan Delta" class="object-contain w-full h-full transform group-hover:scale-105 transition-transform duration-300 mix-blend-multiply">
                    </div>
                    <div class="px-4 pt-3 flex items-center gap-2">
                         <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                             <img src="https://ui-avatars.com/api/?name=Jaringan+Delta&background=random" class="w-full h-full object-cover">
                         </div>
                         <span class="text-xs font-semibold text-gray-700">Jaringan Delta</span>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-800 group-hover:text-primary transition-colors">
                           Jasa Penulisan Konten SEO & Copywriting oleh Jaringan Delta
                        </h3>
                        <div class="flex items-center gap-1 mb-3">
                            <span class="text-accent text-sm font-bold">★</span>
                            <span class="font-bold text-gray-800 text-sm">4.7</span>
                            <span class="text-gray-400 text-sm">(50)</span>
                        </div>
                        <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-400 uppercase font-semibold">Mulai Dari</span>
                            <span class="text-gray-800 font-bold">Rp 150k</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>

@endsection