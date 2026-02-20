@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

    <div class="max-w-7xl mx-auto space-y-10">

        {{-- PARTNER LOGOS SECTION (Fiverr Style Marquee) --}}
        <div class="py-4 overflow-hidden relative group">
            <div class="flex items-center justify-center mb-6">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Mitra Kami</span>
            </div>

            <div class="relative flex overflow-x-hidden">
                <div class="animate-marquee w-full space-nowrap flex items-center gap-16 md:gap-24">
                    {{-- Logos Group 1 --}}
                    <div class="flex items-center gap-16 md:gap-24">
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Google</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Netflix</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">P&G</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Paypal</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Meta</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Amazon</span>
                    </div>
                    {{-- Logos Group 2 (Clone for infinite gapless scroll) --}}
                    <div class="flex items-center gap-16 md:gap-24">
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Google</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Netflix</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">P&G</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Paypal</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Meta</span>
                        <span
                            class="text-xl md:text-2xl font-black text-gray-300/80 hover:text-gray-400 transition-colors uppercase italic tracking-tighter">Amazon</span>
                    </div>
                </div>

                {{-- Fading Edges for smooth entry/exit --}}
                <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10"></div>
                <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10"></div>
            </div>
        </div>

        <style>
            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                display: flex;
                width: max-content;
                animation: marquee 30s linear infinite;
            }

            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>

        {{-- REVISED BANNER SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 h-auto lg:h-[450px]">
            {{-- MAIN CAROUSEL (2/3 width) --}}
            <div x-data="{ 
                                                                                                                        activeSlide: 0,
                                                                                                                        slides: [
                                                                                                                            {
                                                                                                                                title: 'Branding Politik & Personal Branding',
                                                                                                                                desc: 'Bangun citra kepemimpinan yang kuat dan terpercaya untuk masa depan.',
                                                                                                                                price: 'Layanan Eksklusif',
                                                                                                                                discount: 'Konsultasi Sekarang',
                                                                                                                                img: 'https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?auto=format&fit=crop&q=80&w=1200',
                                                                                                                                cta: 'Pelajari Selengkapnya',
                                                                                                                                features: ['Strategi Kemenangan', 'Manajemen Reputasi']
                                                                                                                            },
                                                                                                                            {
                                                                                                                                title: 'Gaya Hidup & Fashion Branding',
                                                                                                                                desc: 'Ciptakan tren dan koneksi emosional melalui identitas visual yang estetik.',
                                                                                                                                price: 'Mulai dari Rp5jt',
                                                                                                                                discount: 'Diskon 15%',
                                                                                                                                img: 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=1200',
                                                                                                                                cta: 'Lihat Portfolio',
                                                                                                                                features: ['Visual Lookbook', 'Influencer Kit']
                                                                                                                            },
                                                                                                                            {
                                                                                                                                title: 'Kuliner & F&B Branding',
                                                                                                                                desc: 'Buat brand kuliner Anda menggugah selera dengan kemasan dan identitas ikonik.',
                                                                                                                                price: 'Paket Komplit',
                                                                                                                                discount: 'Rp2.500.200',
                                                                                                                                img: 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=1200',
                                                                                                                                cta: 'Pesan Paket',
                                                                                                                                features: ['Food Photography', 'Menu Design']
                                                                                                                            },
                                                                                                                            {
                                                                                                                                title: 'Gaming & E-Sports Branding',
                                                                                                                                desc: 'Tampil dominan di dunia digital dengan identitas gaming yang dinamis.',
                                                                                                                                price: 'Streamer Pack',
                                                                                                                                discount: 'Mulai Rp850rb',
                                                                                                                                img: 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&q=80&w=1200',
                                                                                                                                cta: 'Cek Layanan',
                                                                                                                                features: ['Overlay Custom', 'Motion Graphics']
                                                                                                                            }
                                                                                                                        ],
                                                                                                                        next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                                                                                                                        prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                                                                                                                        startAutoplay() { setInterval(() => this.next(), 6000) }
                                                                                                                    }"
                x-init="startAutoplay()"
                class="lg:col-span-2 relative rounded-3xl overflow-hidden group h-80 lg:h-full bg-gray-100 shadow-sm border border-gray-100">

                {{-- Slides --}}
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === index" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform translate-x-4"
                        x-transition:enter-end="opacity-100 transform translate-x-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform translate-x-0"
                        x-transition:leave-end="opacity-0 transform -translate-x-4" class="absolute inset-0">
                        <img :src="slide.img" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/40 to-transparent">
                        </div>

                        <div class="relative h-full flex flex-col justify-center px-8 lg:px-16 text-white space-y-4">
                            <span
                                class="px-3 py-1 bg-primary/20 backdrop-blur-md rounded-full text-[10px] font-bold uppercase tracking-widest text-primary-400 border border-primary/30 w-fit">
                                Branding Scope
                            </span>
                            <h2 class="text-3xl lg:text-5xl font-black max-w-lg leading-tight" x-text="slide.title"></h2>
                            <p class="text-sm lg:text-base text-gray-300 max-w-md opacity-90" x-text="slide.desc"></p>

                            <div class="flex items-center gap-6 py-2">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center backdrop-blur-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-80"
                                        x-text="slide.features[0]"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center backdrop-blur-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider opacity-80"
                                        x-text="slide.features[1]"></span>
                                </div>
                            </div>

                            <div class="space-y-0">
                                <p class="text-xs lg:text-sm text-gray-400 font-medium opacity-70" x-text="slide.price"></p>
                                <p class="text-2xl lg:text-3xl font-black text-accent-400" x-text="slide.discount"></p>
                            </div>

                            <a href="#"
                                class="inline-flex items-center justify-center px-8 py-3 bg-white text-gray-900 rounded-xl font-bold text-sm transition-all hover:bg-primary hover:text-white group/btn w-fit">
                                <span x-text="slide.cta"></span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </template>

                {{-- Navigation Buttons --}}
                <div
                    class="absolute inset-x-0 top-1/2 -translate-y-1/2 px-4 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                    <button @click="prev()"
                        class="p-2 lg:p-3 bg-white/10 backdrop-blur-md rounded-full text-white pointer-events-auto hover:bg-white/30 transition-colors border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="next()"
                        class="p-2 lg:p-3 bg-white/10 backdrop-blur-md rounded-full text-white pointer-events-auto hover:bg-white/30 transition-colors border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                {{-- Indicators --}}
                <div class="absolute bottom-6 right-8 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index"
                            :class="activeSlide === index ? 'bg-primary w-8' : 'bg-white/40 w-2'"
                            class="h-1.5 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>

            {{-- SUB BANNERS (2x2 Grid) --}}
            <div class="grid grid-cols-2 gap-4 lg:col-span-1 h-auto lg:h-full">
                <!-- Banner 1: Berita -->
                <div
                    class="relative rounded-2xl overflow-hidden group cursor-pointer bg-slate-900 aspect-square lg:aspect-auto">
                    <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=600"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-50">
                    <div class="absolute inset-0 bg-primary/20 group-hover:bg-primary/40 transition-colors"></div>
                    <div class="relative p-4 lg:p-5 text-white h-full flex flex-col justify-end">
                        <span class="text-[8px] font-black uppercase tracking-widest text-primary-300 mb-1">Media
                            Services</span>
                        <p class="text-xs lg:text-sm font-black leading-tight">Pembuatan Berita & Press Release</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-accent-400">Pesan Sekarang</span>
                            <div
                                class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:bg-white group-hover:text-primary transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Banner 2: Branding Sosmed -->
                <div
                    class="relative rounded-2xl overflow-hidden group cursor-pointer bg-purple-900 aspect-square lg:aspect-auto">
                    <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&q=80&w=600"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-50">
                    <div class="absolute inset-0 bg-purple-500/20 group-hover:bg-purple-500/40 transition-colors"></div>
                    <div class="relative p-4 lg:p-5 text-white h-full flex flex-col justify-end">
                        <span class="text-[8px] font-black uppercase tracking-widest text-purple-300 mb-1">Content
                            Strategy</span>
                        <p class="text-xs lg:text-sm font-black leading-tight">Branding & Desain Sosial Media</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-yellow-400">Pesan Sekarang</span>
                            <div
                                class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:bg-white group-hover:text-purple-600 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Banner 3: Ads Digital -->
                <div
                    class="relative rounded-2xl overflow-hidden group cursor-pointer bg-emerald-900 aspect-square lg:aspect-auto">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=600"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-50">
                    <div class="absolute inset-0 bg-emerald-500/20 group-hover:bg-emerald-500/40 transition-colors"></div>
                    <div class="relative p-4 lg:p-5 text-white h-full flex flex-col justify-end">
                        <span class="text-[8px] font-black uppercase tracking-widest text-emerald-300 mb-1">Growth
                            Marketing</span>
                        <p class="text-xs lg:text-sm font-black leading-tight">Iklan & Ads Digital Performa</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-accent-400">Optimasi Ads</span>
                            <div
                                class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:bg-white group-hover:text-emerald-600 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Banner 4: Consulting -->
                <div
                    class="relative rounded-2xl overflow-hidden group cursor-pointer bg-amber-900 aspect-square lg:aspect-auto">
                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&q=80&w=600"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-50">
                    <div class="absolute inset-0 bg-amber-500/20 group-hover:bg-amber-500/40 transition-colors"></div>
                    <div class="relative p-4 lg:p-5 text-white h-full flex flex-col justify-end">
                        <span class="text-[8px] font-black uppercase tracking-widest text-amber-300 mb-1">Creative
                            Advisory</span>
                        <p class="text-xs lg:text-sm font-black leading-tight">Consulting Konten Kreator</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-yellow-400">Konsultasi Privat</span>
                            <div
                                class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:bg-white group-hover:text-amber-600 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEARCH HERO SECTION (Fiverr Style) --}}
        <div class="pt-16 pb-8 md:pt-24 md:pb-12 flex flex-col items-center justify-center text-center space-y-10">
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight max-w-4xl px-4 leading-[1.1]">
                Hanya satu pencarian menuju <span class="text-primary italic">branding terbaik</span> Anda
            </h1>

            <div class="w-full max-w-3xl px-4">
                <div
                    class="relative flex items-center bg-white rounded-full shadow-2xl border border-gray-100 p-2 focus-within:ring-4 focus-within:ring-primary/10 transition-all">
                    <div class="pl-6 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari talenta di berbagai kategori..."
                        class="flex-1 bg-transparent border-none focus:ring-0 text-gray-700 px-4 py-2 text-lg md:text-xl font-medium">
                    <button
                        class="bg-gray-900 text-white px-6 md:px-10 py-3 md:py-4 rounded-full font-black text-sm md:text-base hover:bg-gray-800 transition-all flex items-center gap-2 whitespace-nowrap group">
                        Cari sekarang
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-4 px-4 overflow-hidden">
                <p class="text-gray-400 font-bold text-sm w-full md:w-auto mb-2 md:mb-0">Branding Kami</p>
                <a href="#"
                    class="px-6 py-2.5 rounded-full border-2 border-gray-100 text-sm font-black text-gray-600 hover:border-primary hover:text-primary transition-all bg-white hover:shadow-md">Politik</a>
                <a href="#"
                    class="px-6 py-2.5 rounded-full border-2 border-gray-100 text-sm font-black text-gray-600 hover:border-primary hover:text-primary transition-all bg-white hover:shadow-md">Gaming</a>
                <a href="#"
                    class="px-6 py-2.5 rounded-full border-2 border-gray-100 text-sm font-black text-gray-600 hover:border-primary hover:text-primary transition-all bg-white hover:shadow-md">Lifestyle</a>
                <a href="#"
                    class="px-6 py-2.5 rounded-full border-2 border-gray-100 text-sm font-black text-gray-600 hover:border-primary hover:text-primary transition-all bg-white hover:shadow-md flex items-center gap-2">
                    Kuliner & FnB
                    <span
                        class="bg-gray-900 text-white text-[9px] px-1.5 py-0.5 rounded-md uppercase leading-none font-black italic tracking-tighter">Trending</span>
                </a>
            </div>
        </div>

        {{-- MARKETPLACE SECTION (Merged from Order Layanan) --}}
        <div class="pt-2 border-t border-gray-100 space-y-10">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Layanan Populer</h2>
                    <p class="text-gray-500">Layanan pilihan untuk percepat pertumbuhan bisnis Anda.</p>
                </div>
            </div>

            {{-- HORIZONTAL SCROLL SERVICES --}}
            <div x-data="{ 
                                                                                                                                                                            scrollNext() { 
                                                                                                                                                                                const container = this.$refs.container;
                                                                                                                                                                                if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                                                                                                                                                                                    container.scrollTo({ left: 0, behavior: 'smooth' });
                                                                                                                                                                                } else {
                                                                                                                                                                                    container.scrollBy({ left: 300, behavior: 'smooth' });
                                                                                                                                                                                }
                                                                                                                                                                            },
                                                                                                                                                                            scrollPrev() { this.$refs.container.scrollBy({ left: -300, behavior: 'smooth' }); },
                                                                                                                                                                            autoplayInterval: null,
                                                                                                                                                                            startAutoplay() {
                                                                                                                                                                                this.autoplayInterval = setInterval(() => {
                                                                                                                                                                                    this.scrollNext();
                                                                                                                                                                                }, 4000);
                                                                                                                                                                            },
                                                                                                                                                                            stopAutoplay() {
                                                                                                                                                                                if (this.autoplayInterval) {
                                                                                                                                                                                    clearInterval(this.autoplayInterval);
                                                                                                                                                                                }
                                                                                                                                                                            }
                                                                                                                                                                        }"
                x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()" class="relative group">

                {{-- Navigation Buttons --}}
                <button @click="scrollPrev()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 p-2 bg-white rounded-full shadow-lg border border-gray-100 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button @click="scrollNext()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 p-2 bg-white rounded-full shadow-lg border border-gray-100 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>

                <style>
                    .no-scrollbar::-webkit-scrollbar {
                        display: none;
                    }

                    .no-scrollbar {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }
                </style>

                <div x-ref="container" class="flex overflow-x-auto gap-6 no-scrollbar scroll-smooth pb-4">

                    @foreach($popularServices as $service)
                        <div
                            class="group flex-none w-72 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col relative">
                            <div class="aspect-[3/2] bg-gray-50 relative overflow-hidden">
                                <img src="{{ $service->thumbnail ?: 'https://ui-avatars.com/api/?name=' . urlencode($service->nama_layanan) . '&background=random' }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                            </div>

                            <div class="p-4 flex flex-col flex-1 space-y-3">
                                {{-- Mitra Info (clickable) --}}
                                <a href="{{ route('user.mitra', $service->mitra->id) }}"
                                    class="relative z-20 flex items-center gap-2 w-fit group/mitra">
                                    <img src="{{ $service->mitra->foto_profil ? asset('uploads/profile_photos/' . $service->mitra->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($service->mitra->nama_mitra) . '&background=4ade80&color=fff' }}"
                                        class="w-6 h-6 rounded-full object-cover border border-gray-100">
                                    <span
                                        class="text-xs font-bold text-gray-700 group-hover/mitra:text-primary transition-colors">{{ $service->mitra->nama_mitra }}</span>
                                </a>

                                <h4
                                    class="text-sm font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-primary transition-colors">
                                    {{ $service->nama_layanan }}
                                </h4>

                                {{-- Rating Real --}}
                                @php
                                    $svcAvg = $service->reviews->avg('rating') ?? 0;
                                    $svcCount = $service->reviews->count();
                                @endphp
                                <div class="flex items-center gap-1 mt-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 {{ $svcCount > 0 ? 'text-yellow-400' : 'text-gray-300' }}"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    @if($svcCount > 0)
                                        <span class="text-xs font-black text-gray-900">{{ number_format($svcAvg, 1) }}</span>
                                        <span class="text-[10px] text-gray-400 font-medium">({{ $svcCount }})</span>
                                    @else
                                        <span class="text-[10px] text-gray-400 font-medium italic">Belum ada ulasan</span>
                                    @endif
                                </div>

                                <div class="pt-2 border-t border-gray-50 flex items-center justify-between">
                                    <span
                                        class="text-[10px] items-center uppercase font-black tracking-widest text-gray-400">Mulai
                                        dari</span>
                                    <span class="text-sm font-black text-gray-900">Rp
                                        {{ number_format($service->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('user.layanan.show', $service->id) }}" class="absolute inset-0 z-10"></a>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- JARINGAN LIST (Grouped by Mitra) --}}
            <div class="space-y-12">
                @foreach($mitraList as $mitra)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <a href="{{ route('user.mitra', $mitra->id) }}" class="flex items-center gap-4 group/mitra">
                                <div
                                    class="w-14 h-14 rounded-full bg-gray-100 overflow-hidden border-2 border-primary/10 shadow-sm transition group-hover/mitra:border-primary/40">
                                    @if($mitra->foto_profil)
                                        <img src="{{ asset('uploads/profile_photos/' . $mitra->foto_profil) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($mitra->nama_mitra) }}&background=4ade80&color=fff"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h3
                                        class="font-black text-gray-900 text-lg leading-tight group-hover/mitra:text-primary transition-colors">
                                        {{ $mitra->nama_mitra }}</h3>
                                    <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $mitra->kota ?? 'Indonesia' }}
                                    </p>
                                </div>
                            </a>
                            <a href="{{ route('user.mitra', $mitra->id) }}"
                                class="text-xs font-bold text-primary hover:text-primary-700 flex items-center gap-1 bg-primary/5 px-3 py-1.5 rounded-lg transition-colors">
                                Lihat Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        {{-- SERVICES GRID FOR THIS MITRA --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                            @forelse($mitra->layanan->take(5) as $service)
                                <div
                                    class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative">
                                    <div class="aspect-[3/2] bg-gray-50 flex items-center justify-center relative overflow-hidden">
                                        <img src="{{ $service->thumbnail ?: 'https://ui-avatars.com/api/?name=' . urlencode($service->nama_layanan) . '&background=random' }}"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                        <a href="{{ route('user.layanan.show', $service->id) }}" class="absolute inset-0 z-10"></a>
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        {{-- Title --}}
                                        <h4
                                            class="font-bold text-gray-800 text-[13px] line-clamp-2 group-hover:text-primary transition-colors leading-tight mb-2">
                                            {{ $service->nama_layanan }}
                                        </h4>

                                        {{-- Rating Real --}}
                                        @php
                                            $svcAvg2 = $service->reviews->avg('rating') ?? 0;
                                            $svcCount2 = $service->reviews->count();
                                        @endphp
                                        <div class="flex items-center gap-1 mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3 {{ $svcCount2 > 0 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            @if($svcCount2 > 0)
                                                <span
                                                    class="text-[10px] font-black text-gray-900">{{ number_format($svcAvg2, 1) }}</span>
                                                <span class="text-[10px] text-gray-400">({{ $svcCount2 }})</span>
                                            @else
                                                <span class="text-[10px] text-gray-400 italic">Belum ada ulasan</span>
                                            @endif
                                        </div>

                                        <div class="mt-auto pt-3 border-t border-gray-50 flex flex-col">
                                            <span class="text-[9px] text-gray-400 font-black uppercase tracking-widest italic">Mulai
                                                dari</span>
                                            <span class="text-sm font-black text-gray-900">Rp
                                                {{ number_format($service->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <a href="{{ route('user.layanan.show', $service->id) }}" class="absolute inset-0 z-10"></a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-6 text-center text-gray-400 text-xs italic">
                                    Belum ada layanan yang ditambahkan oleh mitra ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

@endsection