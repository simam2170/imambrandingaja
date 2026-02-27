@extends('layouts.user')

@section('title', 'Katalog Branding Kami')

@section('content')

    <div class="max-w-7xl mx-auto space-y-10 py-8">

        {{-- HERO SECTION --}}
        <div class="pt-8 pb-4 flex flex-col items-center justify-center text-center space-y-6">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight max-w-4xl px-4 leading-[1.1]">
                Katalog <span class="text-primary italic">Branding Kami</span>
            </h1>
            <p class="text-gray-500 max-w-2xl px-4">
                Jelajahi berbagai layanan unggulan kami yang telah dikelompokkan secara khusus untuk memenuhi kebutuhan
                spesifik industri Anda.
            </p>
        </div>

        {{-- FILTER BAR --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-12 relative overflow-hidden">
            <!-- decorative element -->
            <div class="absolute top-0 right-0 w-32 h-32 opacity-5 transform translate-x-8 -translate-y-8">
                <div class="w-full h-full rounded-full bg-gradient-to-br from-primary to-orange-400"></div>
            </div>

            <p class="text-[10px] uppercase font-bold text-gray-400 mb-3 tracking-widest">Filter Kategori</p>
            <div class="flex flex-wrap gap-2 relative z-10">
                <a href="{{ route('user.katalog') }}"
                    class="px-5 py-2.5 rounded-full border-2 text-sm font-bold transition-all {{ empty($selectedCategory) ? 'border-primary bg-primary text-white shadow-md' : 'border-gray-100 text-gray-500 hover:border-primary hover:text-primary bg-white' }}">
                    Semua Layanan
                </a>

                @foreach($filterCategories as $cat)
                    <a href="{{ route('user.katalog', ['kategori' => $cat]) }}"
                        class="px-5 py-2.5 rounded-full border-2 text-sm font-bold transition-all {{ $selectedCategory == $cat ? 'border-primary bg-primary text-white shadow-md' : 'border-gray-100 text-gray-500 hover:border-primary hover:text-primary bg-white' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- SERVICES GRID --}}
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b-2 border-primary/20 pb-2">
                <h2 class="text-2xl font-black text-gray-900 flex items-center gap-2">
                    {{ $selectedCategory ? 'Layanan: ' . $selectedCategory : 'Semua Layanan' }}
                    <span class="text-xs font-bold text-gray-400 bg-gray-100 rounded-full px-3 py-1">
                        {{ $services->total() }} Layanan
                    </span>
                </h2>
            </div>

            @if($services->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($services as $service)
                        <div
                            class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                            <div class="aspect-[3/2] bg-gray-50 flex items-center justify-center relative overflow-hidden">
                                <img src="{{ $service->thumbnail ?: 'https://ui-avatars.com/api/?name=' . urlencode($service->nama_layanan) . '&background=random' }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <a href="{{ route('user.layanan.show', $service->id) }}" class="absolute inset-0 z-10"></a>
                            </div>
                            <div class="p-4 flex flex-col flex-1">
                                {{-- Mitra Info --}}
                                <div class="relative z-20 flex items-center gap-2 mb-2 w-fit">
                                    <img src="{{ $service->mitra->foto_profil ? asset('uploads/profile_photos/' . $service->mitra->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($service->mitra->nama_mitra) . '&background=4ade80&color=fff' }}"
                                        class="w-5 h-5 rounded-full object-cover border border-gray-100">
                                    <span
                                        class="text-[10px] font-bold text-gray-600 truncate max-w-[120px]">{{ $service->mitra->nama_mitra }}</span>
                                </div>

                                {{-- Title --}}
                                <h4
                                    class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-primary transition-colors leading-snug mb-2">
                                    {{ $service->nama_layanan }}
                                </h4>

                                {{-- Details --}}
                                <div class="flex items-center gap-2 mt-auto mb-4">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5 {{ $service->reviews_count > 0 ? 'text-yellow-400' : 'text-gray-300' }}"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @if($service->reviews_count > 0)
                                            <span
                                                class="text-[11px] font-black text-gray-900">{{ number_format($service->reviews_avg_rating, 1) }}</span>
                                        @else
                                            <span class="text-[11px] font-black text-gray-400">0.0</span>
                                        @endif
                                    </div>
                                    <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                                    <span
                                        class="text-[11px] font-bold text-gray-500">{{ current(explode(' ', strval($service->sold_count ?? 0))) }}
                                        Terjual</span>
                                </div>

                                <div class="pt-3 border-t border-gray-50 flex items-center justify-between">
                                    <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest italic">Mulai
                                        dari</span>
                                    <span class="text-sm font-black text-gray-900">Rp
                                        {{ number_format($service->harga, 0, ',', '.') }}</span>
                                </div>
                                <a href="{{ route('user.layanan.show', $service->id) }}" class="absolute inset-0 z-10"></a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($services->hasPages())
                    <div class="mt-8">
                        {{ $services->links('pagination::tailwind') }}
                    </div>
                @endif

            @else
                <div
                    class="py-16 bg-gray-50 rounded-2xl border border-gray-100 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Layanan tidak ditemukan</h3>
                    <p class="text-sm text-gray-500 mt-1">Coba gunakan filter pencarian yang lain.</p>
                </div>
            @endif
        </div>

    </div>

@endsection