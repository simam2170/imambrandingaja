@extends('layouts.mitra')

@section('title', 'Dashboard Mitra')

@section('content')
<div class="space-y-8">
    {{-- WELCOME HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Mitra</h1>
            <p class="text-gray-500 mt-1">Halo Creative Studio, berikut adalah ringkasan performa Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200 flex items-center gap-1.5">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Status: Online
            </span>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-3 bg-blue-50 text-blue-600 w-fit rounded-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Pesanan Masuk</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_masuk']) }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-3 bg-yellow-50 text-yellow-600 w-fit rounded-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Sedang Diproses</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['diproses']) }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-3 bg-green-50 text-green-600 w-fit rounded-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Pesanan Selesai</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['selesai']) }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-3 bg-primary/10 text-primary w-fit rounded-xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Estimasi Pendapatan</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($stats['estimasi_pendapatan'], 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- RECENT ACTIVITIES / NOTIFICATIONS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- PESANAN TERBARU --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="font-bold text-gray-800">Pesanan Masuk Terbaru</h3>
                <a href="{{ route('mitra.pesanan') }}" class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-50">
               
                <div class="p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                         </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-bold text-gray-800">YouTube Podcast Branding</h4>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100">DIREVIEW</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Order #ORD-1000 • 2 jam yang lalu</p>
                    </div>
                    <a href="{{ route('mitra.pesanan.show', 1) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-400 hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50">
                <h3 class="font-bold text-gray-800">Notifikasi</h3>
            </div>
            <div class="p-0">
                <div class="p-6 flex gap-3 bg-blue-50/50">
                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                         </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Selesaikan Profil Anda</p>
                        <p class="text-xs text-gray-500 mt-0.5">Tambahkan nomor rekening agar admin bisa mentransfer pendapatan Anda.</p>
                        <a href="{{ route('mitra.profil') }}" class="text-xs font-bold text-primary mt-2 inline-block">Lengkapi Sekarang →</a>
                    </div>
                </div>
                <div class="p-6 flex gap-3 border-t border-gray-50">
                    <div class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                         </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Pembayaran Berhasil</p>
                        <p class="text-xs text-gray-500 mt-0.5">Pendapatan Rp 2.500.000 telah ditransfer ke rekening Anda.</p>
                        <p class="text-[10px] text-gray-400 mt-1">Kemarin, 14:20</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
