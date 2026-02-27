@extends('layouts.user')
@section('title', 'Detail Layanan')

@section('content')

    <div class="mx-auto space-y-8 max-w-7xl" x-data="{
                                                                            tab: 'detail',
                                                                                pkg: null,
                                                                                qty: 1,
                                                                                // Parse packages from JSON or default
                                                                                packages: {{ $layanan->harga_json ? json_encode($layanan->harga_json) : json_encode($packages) }},
                                                                                detail_klasifikasi: {{ json_encode($layanan->detail_klasifikasi ?? []) }},
                                                                                init() {
                                                                                    // Select first package by default
                                                                                    const keys = Object.keys(this.packages);
                                                                                    if (keys.length > 0) {
                                                                                        this.pkg = keys[0];
                                                                                    }
                                                                                },
                                                                                formatPrice(value) {
                                                                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                                                                },
                                                                                get selectedPkg() {
                                                                                    return this.packages[this.pkg];
                                                                                },
                                                                                get subtotal() {
                                                                                    if (!this.selectedPkg) return 0;
                                                                                    return this.selectedPkg.price * this.qty;
                                                                                },
                                                                                async addToCart() {
                                                                                    if (!this.selectedPkg) return;

                                                                                    try {
                                                                                        const response = await fetch('{{ route('user.cart.add') }}', {
                                                                                            method: 'POST',
                                                                                            headers: {
                                                                                                'Content-Type': 'application/json',
                                                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                                            },
                                                                                            body: JSON.stringify({
                                                                                                layanan_id: {{ $layanan->id }},
                                                                                                qty: this.qty,
                                                                                                pkg: this.pkg,
                                                                                                price: this.selectedPkg.price
                                                                                            })
                                                                                        });

                                                                                        if (response.ok) {
                                                                                            alert('Layanan berhasil ditambahkan ke keranjang!');
                                                                                        } else {
                                                                                            alert('Gagal menambahkan ke keranjang. Silakan login terlebih dahulu.');
                                                                                        }
                                                                                    } catch (error) {
                                                                                        console.error('Error adding to cart:', error);
                                                                                        alert('Terjadi kesalahan saat menambahkan ke keranjang.');
                                                                                    }
                                                                                },
                                                                                buyNow() {
                                                                                    if (!this.selectedPkg) return;
                                                                                    const item = {
                                                                                        id: {{ $layanan->id }},
                                                                                        serviceId: {{ $layanan->id }},
                                                                                        mitraId: {{ $layanan->mitra_id }},
                                                                                        seller: '{{ addslashes($layanan->mitra->nama_mitra ?? 'Mitra') }}',
                                                                                        name: '{{ addslashes($layanan->nama_layanan) }}',
                                                                                        pkg: this.pkg,
                                                                                        pkgLabel: this.selectedPkg.label,
                                                                                        price: this.selectedPkg.price,
                                                                                        qty: this.qty,
                                                                                        checked: true
                                                                                    };
                                                                                    localStorage.setItem('checkoutItems', JSON.stringify([item]));
                                                                                    window.location.href = '{{ route('user.checkout') }}';
                                                                                }
                                                                             }">

        {{-- BREADCRUMB --}}
        <nav class="flex text-sm text-gray-500">
            <a href="{{ route('user.dashboard') }}" class="transition-colors hover:text-primary">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('user.mitra', ['id' => $layanan->mitra_id]) }}"
                class="transition-colors hover:text-primary">{{ $layanan->mitra->nama_mitra ?? 'Mitra' }}</a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">{{ $layanan->nama_layanan }}</span>
        </nav>


        {{-- CARD DETAIL LAYANAN --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- LEFT: INFO LAYANAN --}}
            <div class="p-8 bg-white shadow-sm lg:col-span-2 rounded-[32px] border border-gray-100">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Real Thumbnail -->
                    <div
                        class="flex-shrink-0 w-full md:w-72 aspect-square overflow-hidden rounded-2xl bg-gray-50 border border-gray-100 shadow-sm group">
                        <img src="{{ $layanan->thumbnail ?: 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80' }}"
                            alt="{{ $layanan->nama_layanan }}"
                            class="object-cover w-full h-full transform transition-transform duration-700 group-hover:scale-110">
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            @php
                                $badgeClasses = [
                                    'berita' => 'bg-blue-100 text-blue-700',
                                    'sosmed' => 'bg-pink-100 text-pink-700',
                                    'ads_digital' => 'bg-amber-100 text-amber-700',
                                    'consulting' => 'bg-emerald-100 text-emerald-700',
                                ];
                                $badgeLabels = [
                                    'berita' => 'Berita',
                                    'sosmed' => 'Sosial Media',
                                    'ads_digital' => 'Ads Digital',
                                    'consulting' => 'Consulting',
                                ];
                                $currentKlasifikasi = $layanan->klasifikasi;
                                $displayLabel = $currentKlasifikasi ? ($badgeLabels[$currentKlasifikasi] ?? $currentKlasifikasi) : ($layanan->kategori ?? 'Layanan');
                                $displayClass = $currentKlasifikasi ? ($badgeClasses[$currentKlasifikasi] ?? 'bg-primary/10 text-primary') : 'bg-primary/10 text-primary';
                                $showDk = is_array($layanan->detail_klasifikasi) ? $layanan->detail_klasifikasi : json_decode($layanan->detail_klasifikasi, true);
                                $showKat = $showDk ? (collect([$showDk['info']['jenis_layanan'] ?? null, $showDk['info']['jenis_konten'] ?? null, $showDk['info']['jenis_campaign'] ?? null, $showDk['info']['format'] ?? null])->flatten()->filter()->first()) : null;
                                $showKatColors = ['Politik' => 'bg-red-100 text-red-700', 'Gaming' => 'bg-purple-100 text-purple-700', 'Lifestyle' => 'bg-pink-100 text-pink-700', 'Kuliner & FnB' => 'bg-amber-100 text-amber-700'];
                                $showKatClass = $showKatColors[$showKat] ?? 'bg-gray-100 text-gray-500';
                            @endphp
                            <span class="px-2 py-0.5 text-[10px] font-black rounded-md uppercase {{ $displayClass }}">
                                {{ $displayLabel }}
                            </span>

                            <div class="flex items-center gap-2 ml-auto">
                                <div class="flex items-center gap-1 group/rating cursor-help">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-xs font-black text-gray-800">{{ number_format($avgRating, 1) }}</span>
                                    <span class="text-[10px] font-bold text-gray-400">({{ $reviewCount }} Rating)</span>
                                </div>
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-200"></span>
                                <span class="text-xs font-black text-gray-800">{{ $soldCount }} <span
                                        class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Terjual</span></span>
                            </div>
                        </div>
                        <h1 class="text-2xl font-black text-gray-900 leading-tight mb-2">{{ $layanan->nama_layanan }}</h1>
                        <div class="flex items-baseline gap-2 mb-6 text-primary">
                            <span class="text-3xl font-black"
                                x-text="selectedPkg ? formatPrice(selectedPkg.price) : 'Rp 0'"></span>
                            <span class="text-xs font-bold text-gray-400">/ Paket Terpilih</span>
                        </div>

                        {{-- TOKOPEDIA TABS --}}
                        <div class="flex gap-8 mb-6 border-b border-gray-100 overflow-x-auto no-scrollbar">
                            <button @click="tab = 'detail'"
                                class="pb-3 text-sm font-black transition-all border-b-4 shrink-0"
                                :class="tab === 'detail' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'">
                                Detail Produk
                            </button>
                            <button @click="tab = 'spesifikasi'"
                                class="pb-3 text-sm font-black transition-all border-b-4 shrink-0"
                                :class="tab === 'spesifikasi' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'">
                                Spesifikasi
                            </button>
                            <button @click="tab = 'info'" class="pb-3 text-sm font-black transition-all border-b-4 shrink-0"
                                :class="tab === 'info' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'">
                                Info Penting
                            </button>
                        </div>

                        {{-- TAB CONTENT --}}
                        <div class="relative min-h-[200px]">
                            {{-- 1. DETAIL PRODUK --}}
                            <div x-show="tab === 'detail'" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4">
                                <div class="flex gap-2 text-xs">
                                    <span class="font-bold text-gray-400 w-24">Kondisi:</span>
                                    <span class="font-black text-gray-800">Baru</span>
                                </div>
                                <div class="flex gap-2 text-xs">
                                    <span class="font-bold text-gray-400 w-24">Waktu Kerja:</span>
                                    <span class="font-black text-primary">{{ $layanan->estimasi_hari ?? '3' }} Hari</span>
                                </div>
                                <div class="pt-4 border-t border-gray-50">
                                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                        {!! nl2br(e($layanan->deskripsi)) !!}
                                    </p>
                                </div>
                            </div>

                            {{-- 2. SPESIFIKASI --}}
                            <div x-show="tab === 'spesifikasi'" style="display: none;"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                @if($layanan->detail_klasifikasi)
                                    @php
                                        $detailLabels = [
                                            'platform_target' => 'Platform Target',
                                            'jenis_konten' => 'Jenis Konten',
                                            'platform' => 'Platform',
                                            'jenis_layanan' => 'Jenis Layanan',
                                            'platform_iklan' => 'Platform Iklan',
                                            'jenis_campaign' => 'Jenis Campaign',
                                            'bidang_konsultasi' => 'Bidang Konsultasi',
                                            'format' => 'Format',
                                        ];
                                        $infoEntries = $layanan->detail_klasifikasi['info'] ?? [];
                                        if (empty($infoEntries) && !isset($layanan->detail_klasifikasi['platform_pricing'])) {
                                            $infoEntries = array_filter($layanan->detail_klasifikasi, fn($v) => !is_array($v));
                                        }
                                    @endphp
                                    @if(!empty($infoEntries))
                                        <div class="space-y-6">
                                            @foreach($infoEntries as $key => $values)
                                                @php $values = is_array($values) ? $values : [$values]; @endphp
                                                @if(count($values) > 0)
                                                    <div class="flex gap-4">
                                                        <p class="text-xs font-bold text-gray-400 w-28 shrink-0 py-1">
                                                            {{ $detailLabels[$key] ?? $key }}
                                                        </p>
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($values as $val)
                                                                <span
                                                                    class="px-3 py-1 bg-primary/5 text-primary text-[10px] font-black rounded-lg border border-primary/10">{{ $val }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-400 italic">Tidak ada spesifikasi tambahan.</p>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-400 italic">Tidak ada spesifikasi tambahan.</p>
                                @endif
                            </div>

                            {{-- 3. INFO PENTING --}}
                            <div x-show="tab === 'info'" style="display: none;"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                    <h5 class="text-sm font-black text-gray-800 mb-4 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Kebijakan Layanan & Waktu Kerja
                                    </h5>
                                    <ul class="text-xs text-gray-500 space-y-3 list-disc list-inside">
                                        <li>Estimasi pengerjaan: <span
                                                class="font-black text-gray-700">{{ $layanan->estimasi_hari }} Hari
                                                Kerja</span>.</li>
                                        <li>Revisi dilakukan sesuai dengan paket yang dipilih.</li>
                                        <li>Pastikan memberikan brief yang jelas sebelum pengerjaan dimulai.</li>
                                        <li>Komunikasi hanya dilakukan melalui platform <span
                                                class="font-black text-primary">BrandingAja</span>.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- TARGET SELECTION --}}
                        <div class="pt-4 mt-6 border-t border-gray-100" x-show="Object.keys(packages).length > 0">
                            <p class="mb-2 text-sm font-semibold">Pilih Paket :</p>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(package, key) in packages" :key="key">
                                    <button @click="pkg = key; qty = 1"
                                        class="px-4 py-2 text-xs font-semibold transition-all border rounded-full"
                                        :class="pkg === key 
                                                                                                                    ? 'bg-primary text-white border-primary shadow-md transform scale-105' 
                                                                                                                    : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-100'">
                                        <span x-text="package.label"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: ATUR PEMESANAN & HELP --}}
            <div class="space-y-6 lg:col-span-1 lg:sticky lg:top-28 self-start">

                {{-- ATUR PEMESANAN --}}
                <div class="p-6 bg-accent-50 rounded-xl h-fit">
                    <h3 class="pb-3 mb-4 font-bold text-gray-900 border-b border-accent-100">Atur Pemesanan</h3>

                    <div class="mb-4 space-y-2 text-sm" x-show="selectedPkg">
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Paket</span>
                            <span class="font-bold text-gray-900" x-text="selectedPkg.viewLabel"></span>
                        </div>
                        <div class="flex items-center justify-between text-gray-600">
                            <span>Harga Satuan</span>
                            <span class="font-medium" x-text="formatPrice(selectedPkg.price)"></span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-semibold text-gray-800">Jumlah Pesanan</label>
                        <div class="flex items-center gap-3">
                            <button @click="if(qty > 1) qty--"
                                class="flex items-center justify-center w-8 h-8 transition bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary disabled:opacity-50"
                                :disabled="qty <= 1">
                                -
                            </button>
                            <input type="text" x-model="qty" readonly
                                class="w-12 p-0 font-bold text-center text-gray-900 bg-transparent border-none outline-none focus:ring-0">
                            <button @click="qty++"
                                class="flex items-center justify-center w-8 h-8 transition bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary">
                                +
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 mb-6 border-t border-accent-200/50">
                        <p class="flex items-end justify-between text-sm font-semibold text-gray-800">
                            <span>Subtotal</span>
                            <span class="text-lg text-primary" x-text="formatPrice(subtotal)"></span>
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button @click="addToCart()"
                            class="w-full py-2.5 text-sm font-bold border-2 border-primary text-primary rounded-xl hover:bg-primary/5 transition">
                            + Keranjang
                        </button>
                        <button @click="buyNow()"
                            class="w-full py-2.5 text-sm font-bold text-white rounded-xl bg-primary hover:bg-green-600 transition shadow-lg shadow-green-200">
                            Beli Langsung
                        </button>
                    </div>
                </div>

                {{-- HELP CARD (Static) --}}
                <div class="bg-primary rounded-2xl p-6 text-white shadow-lg shadow-primary/20 relative overflow-hidden">
                    <div class="absolute -right-8 -bottom-8 opacity-20 transform rotate-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg relative z-10">Butuh Bantuan?</h3>
                    <p class="text-sm text-white/80 mt-2 relative z-10 leading-relaxed">Hubungi admin jika Anda mengalami
                        kesulitan.</p>
                    <a href="https://wa.me/6282328786328" target="_blank"
                        class="mt-4 inline-block px-6 py-2 bg-white text-primary font-bold text-sm rounded-xl relative z-10 hover:bg-gray-50 transition-colors">
                        Chat Admin
                    </a>
                </div>
            </div>
        </div>

        {{-- ====================================================
        REVIEWS SECTION — real data from database
        ==================================================== --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-6">
            {{-- Header: Rating Summary --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-6 pb-6 border-b border-gray-100">
                {{-- Big Score --}}
                <div class="text-center shrink-0">
                    <p class="text-5xl font-black text-gray-800">{{ number_format($avgRating, 1) }}</p>
                    <div class="flex justify-center gap-0.5 my-2">
                        @for($s = 1; $s <= 5; $s++)
                            <svg class="w-4 h-4 {{ $s <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-xs text-gray-400">{{ $reviewCount }} Ulasan</p>
                </div>

                {{-- Bar breakdown --}}
                <div class="flex-1 space-y-1.5">
                    @for($s = 5; $s >= 1; $s--)
                        @php
                            $countStar = $layanan->reviews->where('rating', $s)->count();
                            $pct = $reviewCount > 0 ? round(($countStar / $reviewCount) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-3 shrink-0">{{ $s }}</span>
                            <svg class="w-3 h-3 text-yellow-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="h-2 bg-yellow-400 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-xs text-gray-400 w-6 text-right shrink-0">{{ $countStar }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Review List --}}
            <h4 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Semua Ulasan
            </h4>

            @forelse($layanan->reviews as $review)
                <div class="py-4 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div class="flex items-start gap-3">
                        {{-- Avatar --}}
                        <div
                            class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-sm font-bold text-primary shrink-0">
                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <p class="text-sm font-bold text-gray-800">{{ $review->user->name ?? 'Pengguna' }}</p>
                                <span
                                    class="text-xs text-gray-400">{{ $review->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                            </div>
                            {{-- Stars --}}
                            <div class="flex gap-0.5 my-1">
                                @for($s = 1; $s <= 5; $s++)
                                    <svg class="w-3.5 h-3.5 {{ $s <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            @if($review->review)
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $review->review }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-10 text-center">
                    <p class="text-4xl mb-3">⭐</p>
                    <p class="text-sm font-semibold text-gray-600">Belum ada ulasan untuk layanan ini.</p>
                    <p class="text-xs text-gray-400 mt-1">Jadilah yang pertama memberikan ulasan!</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection