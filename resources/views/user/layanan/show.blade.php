@extends('layouts.user')
@section('title', 'Detail Layanan')

@section('content')

<div class="mx-auto space-y-8 max-w-7xl" 
     x-data="{
        tab: 'detail',
        pkg: null,
        qty: 1,
        // Parse packages from JSON or default
        packages: {{ $layanan->harga_json ? json_encode($layanan->harga_json) : json_encode($packages) }},
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
        <a href="{{ route('user.mitra', ['id' => $layanan->mitra_id]) }}" class="transition-colors hover:text-primary">{{ $layanan->mitra->nama_mitra ?? 'Mitra' }}</a>
        <span class="mx-2">/</span>
        <span class="font-medium text-gray-800">{{ $layanan->nama_layanan }}</span>
    </nav>


    {{-- CARD DETAIL LAYANAN --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- LEFT: INFO LAYANAN --}}
        <div class="p-6 bg-white shadow-sm lg:col-span-2 rounded-xl">
            <div class="flex gap-6">
                <!-- Real Thumbnail -->
                <div class="flex-shrink-0 w-40 h-40 overflow-hidden rounded-xl bg-gray-50 border border-gray-100">
                    <img src="{{ $layanan->thumbnail ?: 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80' }}" 
                         alt="{{ $layanan->nama_layanan }}" 
                         class="object-cover w-full h-full">
                </div>

                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-md uppercase">{{ $layanan->kategori ?? 'Layanan' }}</span>
                    </div>
                    <h1 class="text-xl font-bold">{{ $layanan->nama_layanan }}</h1>
                    <p class="mb-3 text-sm text-gray-500" x-text="selectedPkg ? formatPrice(selectedPkg.price) : 'Rp 0'"></p>

                    {{-- TABS --}}
                    <div class="flex gap-6 pb-1 mb-4 text-sm border-b border-gray-100">
                        <button @click="tab = 'detail'" 
                                class="pb-2 font-semibold transition-colors border-b-2"
                                :class="tab === 'detail' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-primary'">
                            Detail Layanan
                        </button>
                        <button @click="tab = 'info'" 
                                class="pb-2 font-semibold transition-colors border-b-2"
                                :class="tab === 'info' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-primary'">
                            Info Penting
                        </button>
                    </div>

                    {{-- TAB CONTENT --}}
                    <div class="relative min-h-[100px]">
                        {{-- Detail Layanan --}}
                        <div x-show="tab === 'detail'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="text-sm leading-relaxed text-gray-600">
                                {!! nl2br(e($layanan->deskripsi)) !!}
                            </div>
                        </div>

                        {{-- Info Penting --}}
                        <div x-show="tab === 'info'" style="display: none;"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="p-4 space-y-3 text-sm text-gray-600 border border-blue-100 rounded-lg bg-blue-50">
                                <p class="font-semibold text-blue-800">📋 Syarat & Ketentuan:</p>
                                <ul class="ml-5 space-y-1 list-disc">
                                    <li>Estimasi pengerjaan: {{ $layanan->estimasi_hari }} Hari.</li>
                                    <li>Revisi sesuai kesepakatan.</li>
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
            <div class="p-6 bg-yellow-50 rounded-xl h-fit">
                <h3 class="pb-3 mb-4 font-bold text-gray-900 border-b border-yellow-100">Atur Pemesanan</h3>

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
                        <input type="text" x-model="qty" readonly class="w-12 p-0 font-bold text-center text-gray-900 bg-transparent border-none outline-none focus:ring-0">
                        <button @click="qty++" 
                                class="flex items-center justify-center w-8 h-8 transition bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary">
                            +
                        </button>
                    </div>
                </div>

                <div class="pt-4 mb-6 border-t border-yellow-200/50">
                    <p class="flex items-end justify-between text-sm font-semibold text-gray-800">
                        <span>Subtotal</span>
                        <span class="text-lg text-primary" x-text="formatPrice(subtotal)"></span>
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <button @click="addToCart()" class="w-full py-2.5 text-sm font-bold border-2 border-primary text-primary rounded-xl hover:bg-primary/5 transition">
                        + Keranjang
                    </button>
                    <button @click="buyNow()" class="w-full py-2.5 text-sm font-bold text-white rounded-xl bg-primary hover:bg-green-600 transition shadow-lg shadow-green-200">
                        Beli Langsung
                    </button>
                </div>
            </div>

            {{-- HELP CARD (Static) --}}
            <div class="bg-primary rounded-2xl p-6 text-white shadow-lg shadow-primary/20 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-20 transform rotate-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg relative z-10">Butuh Bantuan?</h3>
                <p class="text-sm text-white/80 mt-2 relative z-10 leading-relaxed">Hubungi admin jika Anda mengalami kesulitan.</p>
                <a href="#" class="mt-4 inline-block px-6 py-2 bg-white text-primary font-bold text-sm rounded-xl relative z-10 hover:bg-gray-50 transition-colors">
                    Chat Admin
                </a>
            </div>
        </div>
    </div>
    
    {{-- REVIEWS (Static for now) --}}
    <!-- ... same review section as before ... -->
    
</div>
@endsection
