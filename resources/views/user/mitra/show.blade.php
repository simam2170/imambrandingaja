@extends('layouts.user')
@section('title', $mitra->nama_mitra)
@section('content')

    <div class="mx-auto space-y-8 max-w-7xl">

        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500">
            <a href="{{ route('user.dashboard') }}" class="transition-colors hover:text-primary">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">{{ $mitra->nama_mitra }}</span>
        </nav>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- LEFT COLUMN: PROVIDER INFO --}}
            <div class="space-y-6 lg:col-span-1 lg:sticky lg:top-28 self-start">
                <!-- Profile Card -->
                <div class="p-6 text-center bg-white border border-gray-100 shadow-sm rounded-xl">
                    <div
                        class="relative w-32 h-32 mx-auto mb-4 overflow-hidden bg-gray-100 border-4 border-white rounded-full shadow-md">
                        @if($mitra->foto_profil)
                            <img src="{{ asset('uploads/profile_photos/' . $mitra->foto_profil) }}"
                                alt="{{ $mitra->nama_mitra }}" class="w-full h-full object-cover"
                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($mitra->nama_mitra) }}&background=4ade80&color=fff'">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mitra->nama_mitra) }}&background=4ade80&color=fff"
                                alt="{{ $mitra->nama_mitra }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <h1 class="text-xl font-bold text-gray-900">{{ $mitra->nama_mitra }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $mitra->email ?? 'Partner Profesional' }}</p>

                    <div class="flex items-center justify-center gap-1.5 mt-3">
                        <div class="flex gap-0.5">
                            @for($s = 1; $s <= 5; $s++)
                                <svg class="w-4 h-4 {{ $s <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span
                            class="text-sm font-bold text-gray-700">{{ $reviewCount > 0 ? number_format($avgRating, 1) : '—' }}</span>
                        <span class="text-sm text-gray-400">({{ $reviewCount }} Ulasan)</span>
                    </div>

                    <div class="flex flex-col gap-3 mt-6">
                        <button
                            class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Hubungi Kami
                        </button>
                    </div>
                </div>


                <!-- About Card -->
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
                    <h3 class="mb-4 font-bold text-gray-900">Tentang Kami</h3>
                    <p class="text-sm leading-relaxed text-gray-600">
                        {{ $mitra->deskripsi ?? 'Penyedia layanan branding dan digital marketing profesional.' }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-50 text-sm text-gray-500">
                        <p class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $mitra->kota ?? 'Indonesia' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: TABS & CONTENT --}}
            <div class="space-y-6 lg:col-span-2"
                x-data="{ activeTab: 'services', portfolioModal: false, selectedItem: null }">

                {{-- TABS NAVIGATION --}}
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">


                        <button @click="activeTab = 'services'"
                            :class="{ 'border-primary text-primary': activeTab === 'services', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'services' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Layanan
                            <span
                                class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $mitra->layanan->count() }}</span>
                        </button>

                        <button @click="activeTab = 'portfolio'"
                            :class="{ 'border-primary text-primary': activeTab === 'portfolio', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'portfolio' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Portofolio
                            <span
                                class="ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">{{ $mitra->portofolios->count() }}</span>
                        </button>


                    </nav>
                </div>

                {{-- TAB CONTENTS --}}



                {{-- 2. LAYANAN --}}
                <div x-show="activeTab === 'services'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @forelse($mitra->layanan as $layanan)
                            <div
                                class="flex flex-col transition-all bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl group">
                                {{-- Service Thumbnail --}}
                                <div class="relative aspect-[3/2] overflow-hidden bg-gray-50">
                                    <img src="{{ $layanan->thumbnail ?: 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80' }}"
                                        alt="{{ $layanan->nama_layanan }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="px-2 py-1 text-[10px] font-bold rounded-lg text-primary bg-white/90 backdrop-blur-sm shadow-sm whitespace-nowrap">
                                            Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-5 flex flex-col flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span
                                            class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-md uppercase">{{ $layanan->klasifikasi ?? 'Layanan' }}</span>

                                        @php
                                            $lAvg = $layanan->reviews->avg('rating') ?? 0;
                                            $lCount = $layanan->reviews->count();
                                        @endphp
                                        <div class="flex items-center gap-2 ml-auto">
                                            <div class="flex items-center gap-0.5">
                                                <svg class="w-3 h-3 {{ $lCount > 0 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                @if($lCount > 0)
                                                    <span
                                                        class="text-[11px] font-bold text-gray-700">{{ number_format($lAvg, 1) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <h3
                                        class="font-bold text-gray-900 transition-colors group-hover:text-primary line-clamp-1 mb-2">
                                        {{ $layanan->nama_layanan }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4 flex-1">
                                        {{ $layanan->deskripsi }}
                                    </p>

                                    <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">⏱️
                                            {{ $layanan->estimasi_hari ?? '3' }} Hari</span>
                                        <a href="{{ route('user.layanan.show', $layanan->id) }}"
                                            class="text-primary text-xs font-black uppercase tracking-widest hover:translate-x-1 transition-transform flex items-center gap-1 group/btn">
                                            Detail
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <p class="text-gray-500">Belum ada layanan yang tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- 3. PORTOFOLIO --}}
                <div x-show="activeTab === 'portfolio'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                        @forelse($mitra->portofolios as $portfolio)
                            <div @click="portfolioModal = true; selectedItem = {{ $portfolio->load('layanan', 'order.user', 'order.review') }}"
                                class="group cursor-pointer">
                                {{-- Image Container --}}
                                <div
                                    class="relative aspect-[4/3] bg-gray-100 rounded-xl overflow-hidden border border-gray-200 mb-3 transition-all group-hover:shadow-md">
                                    <img src="{{ asset('uploads/completion_proofs/' . $portfolio->file_portofolio) }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        alt="Portofolio {{ $mitra->nama_mitra }}">
                                </div>

                                {{-- Content --}}
                                <div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1 line-clamp-1">
                                        <span class="font-normal text-gray-400 mx-1">—</span>
                                        {{ $portfolio->layanan->nama_layanan ?? 'Service' }}
                                    </h3>
                                    <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                                        {{ $portfolio->deskripsi }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full py-12 px-6 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                                <div
                                    class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-gray-900 font-medium">Belum ada portofolio</h3>
                                <p class="text-gray-500 text-sm mt-1">Mitra ini belum membagikan hasil karya mereka.</p>
                            </div>
                        @endforelse
                    </div>
                </div>




                {{-- PORTFOLIO MODAL --}}
                <div x-show="portfolioModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                    {{-- Backdrop --}}
                    <div @click="portfolioModal = false" x-show="portfolioModal"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black/70 transition-opacity"></div>

                    {{-- Modal Content --}}
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div x-show="portfolioModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh]">

                            {{-- Close Button --}}
                            <button @click="portfolioModal = false"
                                class="absolute top-4 right-4 z-10 p-2 bg-white/10 hover:bg-black/10 rounded-full text-gray-500 hover:text-gray-900 transition-colors">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            {{-- Left: Image --}}
                            <div class="w-full md:w-2/3 bg-gray-100 flex items-center justify-center bg-gray-900">
                                <template x-if="selectedItem">
                                    <img :src="'/uploads/completion_proofs/' + selectedItem.file_portofolio"
                                        class="max-w-full max-h-[60vh] md:max-h-[90vh] object-contain" alt="Project Image">
                                </template>
                            </div>

                            {{-- Right: Details --}}
                            <div
                                class="w-full md:w-1/3 flex flex-col bg-white border-l border-gray-100 h-full overflow-y-auto">
                                <div class="p-6 flex-1">
                                    {{-- Header: Mitra Info --}}
                                    <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                                        <div
                                            class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                                            @if($mitra->foto_profil)
                                                <img src="{{ asset('uploads/profile_photos/' . $mitra->foto_profil) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($mitra->nama_mitra) }}&background=4ade80&color=fff"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Made by</p>
                                            <h4 class="text-sm font-bold text-gray-900">{{ $mitra->nama_mitra }}</h4>
                                        </div>
                                    </div>

                                    {{-- Project Info --}}
                                    <div class="space-y-4">
                                        <template x-if="selectedItem">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span
                                                        class="px-2.5 py-1 rounded-full bg-gray-100 border border-gray-200 text-xs font-semibold text-gray-600 flex items-center gap-1">
                                                        <svg class="w-3 h-3 text-gray-500" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span
                                                            x-text="selectedItem.layanan ? selectedItem.layanan.nama_layanan : 'Project'"></span>
                                                    </span>
                                                </div>

                                                <h2 class="text-xl font-bold text-gray-900 leading-tight mb-3"
                                                    x-text="selectedItem.deskripsi"></h2>

                                                <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-6">
                                                    <span
                                                        class="flex items-center gap-1 bg-green-50 text-green-700 px-2 py-1 rounded font-medium">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Made on BrandingAja
                                                    </span>
                                                    <template x-if="selectedItem.order">
                                                        <span
                                                            class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                                            Ordered by <span class="font-bold text-gray-700"
                                                                x-text="selectedItem.order.user ? selectedItem.order.user.name : 'Unknown'"></span>
                                                        </span>
                                                    </template>
                                                </div>

                                                {{-- Review Section --}}
                                                <template x-if="selectedItem.order && selectedItem.order.review">
                                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                                        <div class="flex items-center gap-1 text-yellow-500 mb-2">
                                                            <template x-for="i in 5">
                                                                <svg class="w-3.5 h-3.5"
                                                                    :class="i <= selectedItem.order.review.rating ? 'fill-current' : 'text-gray-300 fill-current'"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </template>
                                                            <span class="text-xs font-bold text-gray-900 ml-1"
                                                                x-text="selectedItem.order.review.rating + '.0'"></span>
                                                        </div>
                                                        <p class="text-sm text-gray-600 italic">
                                                            "<span x-text="selectedItem.order.review.ulasan"></span>"
                                                        </p>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- Footer --}}
                                <div class="p-6 border-t border-gray-100 bg-gray-50">
                                    <template x-if="selectedItem && selectedItem.layanan">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500">Price Range</p>
                                                <p class="text-lg font-bold text-gray-900">
                                                    Rp <span
                                                        x-text="new Intl.NumberFormat('id-ID').format(selectedItem.layanan.harga)"></span>
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500">Duration</p>
                                                <p class="text-sm font-bold text-gray-900"
                                                    x-text="(selectedItem.layanan.estimasi_hari || '3') + ' Days'"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection