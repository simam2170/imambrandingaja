@extends('layouts.user')
@section('title', 'Jaringan Beta')
@section('content')

    <div class="mx-auto space-y-8 max-w-7xl">

        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500">
            <a href="/user/dashboard" class="transition-colors hover:text-primary">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">Jaringan Beta</span>
        </nav>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- LEFT COLUMN: PROVIDER INFO --}}
            <div class="space-y-6 lg:col-span-1 lg:sticky lg:top-28 self-start">
                <div class="p-6 text-center bg-white border border-gray-100 shadow-sm rounded-xl">
                    <div
                        class="relative w-32 h-32 mx-auto mb-4 overflow-hidden bg-gray-100 border-4 border-white rounded-full shadow-md">
                        <img src="{{ asset('img/jaringan/jaringan2.png') }}" class="object-contain w-full h-full p-2">
                    </div>

                    <h1 class="text-xl font-bold text-gray-900">Jaringan Beta</h1>
                    <p class="mt-1 text-sm text-gray-500">Creative Design & Multimedia</p>

                    <div class="flex items-center justify-center gap-1 mt-3">
                        <div class="flex text-accent">
                            @for($i = 0; $i < 5; $i++) <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg> @endfor
                        </div>
                        <span class="text-sm font-semibold text-gray-600">4.8</span>
                        <span class="text-sm text-gray-400">(85 Reviews)</span>
                    </div>

                    <div class="flex flex-col gap-3 mt-6">
                        <button
                            class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Hubungi Kami
                        </button>
                    </div>

                    <div class="pt-6 mt-6 space-y-3 text-sm text-left border-t border-gray-100">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Lokasi</span>
                            <span class="font-medium text-gray-800">Jakarta</span>
                        </div>
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
            <div class="space-y-8 lg:col-span-2">
                {{-- SOSMED --}}
                <div>
                    <h2 class="flex items-center gap-2 mb-4 text-xl font-bold text-gray-900">
                        <span class="p-2 bg-green-100 rounded-lg text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        Layanan Desain Grafis
                    </h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div> 
                            
                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  

                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  

                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  

                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  

                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  

                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  
                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
                                        Pesan Sekarang
                                    </button>
                                </div>
                            </div>  

                            <div
                                class="flex flex-col p-4 transition-all bg-white border border-gray-200 rounded-xl hover:shadow-md group">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-bold text-gray-800 transition-colors group-hover:text-primary">Logo Branding
                                        Package</h3>
                                    <span class="px-2 py-1 text-xs font-bold rounded text-primary bg-primary-50">Rp 300k</span>
                                </div>
                                <p class="flex-1 mb-4 text-sm text-gray-500">
                                    Desain logo profesional + panduan branding lengkap.
                                </p>
                                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                                    <span class="text-xs text-gray-400">⏱️ 5 Hari Kerja</span>
                                    <button
                                        class="px-4 py-1.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-600 transition shadow-lg shadow-primary-200">
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
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection