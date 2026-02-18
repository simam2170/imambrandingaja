@extends('layouts.mitra')

@section('title', 'Dashboard Mitra')

@section('content')
    <div class="space-y-8">
        {{-- WELCOME HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard {{ $mitra->nama_mitra ?? 'Username' }}</h1>
                <p class="text-gray-500 mt-1">Halo {{ $mitra->nama_mitra ?? 'Username' }}, berikut adalah ringkasan performa
                    Anda.</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Status: Online
                </span>
            </div>
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-3 bg-primary-50 text-primary-600 w-fit rounded-xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Total Pesanan Masuk</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_masuk']) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-3 bg-accent-50 text-accent-600 w-fit rounded-xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Sedang Diproses</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['diproses']) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-3 bg-green-50 text-green-600 w-fit rounded-xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Pesanan Selesai</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['selesai']) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="p-3 bg-red-50 text-red-600 w-fit rounded-xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12L5.47 6.53a.75.75 0 0 1 0-1.06"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Pesanan Ditolak</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['ditolak']) }}</h3>
            </div>
        </div>

        {{-- RECENT ACTIVITIES / NOTIFICATIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- PESANAN TERBARU --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Pesanan Masuk Terbaru</h3>
                    <a href="{{ route('mitra.pesanan', $mitra->id ?? 0) }}"
                        class="text-sm font-semibold text-primary hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                        <div class="p-6 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-gray-800">{{ $order->layanan->nama_layanan ?? 'Pesanan' }}</h4>
                                    <span class="px-2 py-0.5">
                                        @php
                                            $statusClasses = [
                                                'direview' => 'bg-primary-50 text-primary-600 border-primary-100',
                                                'diproses' => 'bg-accent-50 text-accent-600 border-accent-100',
                                                'selesai' => 'bg-green-50 text-green-600 border-green-100',
                                                'ditolak' => 'bg-red-50 text-red-600 border-red-100',
                                            ];
                                            $class = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-500 border-gray-100';
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 rounded-full text-[11px] font-bold border uppercase {{ $class }}">
                                            {{ $order->status }}
                                        </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Order #{{ $order->order_number }} •
                                    {{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('mitra.pesanan.show', $order->id) }}"
                                class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-400 hover:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 text-sm">Belum ada pesanan terbaru.</div>
                    @endforelse
                </div>
            </div>

            {{-- NOTIFIKASI --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-800">Notifikasi</h3>
                </div>
                <div class="p-0">
                    <div class="p-6 flex gap-3 bg-primary-50/50">
                        <div
                            class="w-8 h-8 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Selesaikan Profil Anda</p>
                            <p class="text-xs text-gray-500 mt-0.5">Tambahkan nomor rekening agar admin bisa mentransfer
                                pendapatan Anda.</p>
                            <a href="{{ route('mitra.profil') }}"
                                class="text-xs font-bold text-primary mt-2 inline-block">Lengkapi Sekarang →</a>
                        </div>
                    </div>
                    <div class="p-6 flex gap-3 border-t border-gray-50">
                        <div
                            class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Pembayaran Berhasil</p>
                            <p class="text-xs text-gray-500 mt-0.5">Pendapatan Rp 2.500.000 telah ditransfer ke rekening
                                Anda.</p>
                            <p class="text-[10px] text-gray-400 mt-1">Kemarin, 14:20</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
