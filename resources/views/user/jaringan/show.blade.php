@extends('layouts.user')
@section('title', $jaringan->nama_jaringan)
@section('content')

    <div class="mx-auto space-y-8 max-w-7xl">

        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500">
            <a href="{{ route('user.dashboard') }}" class="transition-colors hover:text-primary">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">{{ $jaringan->nama_jaringan }}</span>
        </nav>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            
            {{-- LEFT COLUMN: PROVIDER INFO --}}
            <div class="space-y-6 lg:col-span-1 lg:sticky lg:top-28 self-start">
                <!-- Profile Card -->
                <div class="p-6 text-center bg-white border border-gray-100 shadow-sm rounded-xl">
                    <div class="relative w-32 h-32 mx-auto mb-4 overflow-hidden bg-gray-100 border-4 border-white rounded-full shadow-md">
                         <img src="https://ui-avatars.com/api/?name={{ urlencode($jaringan->nama_jaringan) }}&background=random" class="w-full h-full object-cover">
                    </div>
                    
                    <h1 class="text-xl font-bold text-gray-900">{{ $jaringan->nama_jaringan }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $jaringan->email ?? 'Partner Profesional' }}</p>
                    
                    <div class="flex items-center justify-center gap-1 mt-3">
                         <div class="flex text-accent">
                             @for($i=0; $i<5; $i++) <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                         </div>
                         <span class="text-sm font-semibold text-gray-600">5.0</span>
                         <span class="text-sm text-gray-400">({{ $jaringan->orders_count ?? 0 }} Reviews)</span>
                    </div>

                    <div class="flex flex-col gap-3 mt-6">
                        <button class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Hubungi Kami
                        </button>
                    </div>
                </div>

                <!-- About Card -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h3 class="mb-4 font-bold text-gray-900">Tentang Kami</h3>
                    <p class="text-sm leading-relaxed text-gray-600">
                        {{ $jaringan->deskripsi ?? 'Penyedia layanan branding dan digital marketing profesional.' }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-50 text-sm text-gray-500">
                        <p class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $jaringan->kota ?? 'Indonesia' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: SERVICES --}}
            <div class="space-y-8 lg:col-span-2">
                
                {{-- SECTION ALL SERVICES --}}
                <div>
                    <h2 class="flex items-center gap-2 mb-4 text-xl font-bold text-gray-900">
                        <span class="p-2 bg-green-100 rounded-lg text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </span>
                        Layanan Kami
                    </h2>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @forelse($jaringan->layanan as $layanan)
                        <div class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                             <div class="flex items-start justify-between mb-2">
                                 <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary line-clamp-2">{{ $layanan->nama_layanan }}</h3>
                                 <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-green-50 shrink-0 whitespace-nowrap">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                             </div>
                             <p class="flex-1 mb-4 text-sm text-gray-500 line-clamp-3">
                                 {{ $layanan->deskripsi }}
                             </p>

                             <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                 <span class="text-xs text-gray-400">⏱️ {{ $layanan->estimasi_hari ?? '3' }} Hari Kerja</span>
                                 <a href="{{ route('user.layanan.show', $layanan->id) }}"
                                    class="inline-flex items-center justify-center px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-green-600 transition shadow-lg shadow-green-200">
                                    Pesan Sekarang
                                </a>
                             </div>
                        </div>
                        @empty
                        <div class="col-span-full p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada layanan yang tersedia.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
