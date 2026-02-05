@extends('layouts.user')
@section('title', 'Detail Layanan')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto" 
     x-data="{
        tab: 'detail',
        pkg: '10k',
        qty: 1,
        packages: {
            '10k': { label: '10K', price: 100000, viewLabel: '10.000 Views' },
            '50k': { label: '50K', price: 450000, viewLabel: '50.000 Views' },
            '100k': { label: '100K', price: 800000, viewLabel: '100.000 Views' }
        },
        formatPrice(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
        },
        get selectedPkg() {
            return this.packages[this.pkg];
        },
        get subtotal() {
            return this.selectedPkg.price * this.qty;
        },
        addToCart() {
            let cart = JSON.parse(localStorage.getItem('cartItems') || '[]');
            const newItem = {
                id: Date.now(),
                seller: 'Jaringan Alpha',
                name: 'Youtube Podcast',
                views: this.selectedPkg.viewLabel,
                price: this.selectedPkg.price,
                qty: this.qty,
                checked: true
            };
            cart.push(newItem);
            localStorage.setItem('cartItems', JSON.stringify(cart));
            alert('Layanan berhasil ditambahkan ke keranjang!');
        },
        buyNow() {
            const item = {
                id: Date.now(),
                seller: 'Jaringan Alpha',
                name: 'Youtube Podcast',
                views: this.selectedPkg.viewLabel,
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
        <a href="{{ route('user.jaringan', ['id' => 'jaringan1']) }}" class="transition-colors hover:text-primary">Jaringan 1</a>
        <span class="mx-2">/</span>
        <span class="font-medium text-gray-800">Youtube Podcast</span>
    </nav>


    {{-- CARD DETAIL LAYANAN --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- LEFT: INFO LAYANAN --}}
        <div class="p-6 bg-white shadow-sm lg:col-span-2 rounded-xl">
            <div class="flex gap-6">
                <div class="w-40 h-40 bg-gray-300 rounded-xl flex-shrink-0"></div>

                <div class="flex-1">
                    <h1 class="text-xl font-bold">Youtube Podcast</h1>
                    <p class="mb-3 text-sm text-gray-500" x-text="formatPrice(selectedPkg.price)"></p>

                    {{-- TABS --}}
                    <div class="flex gap-6 mb-4 text-sm border-b border-gray-100 pb-1">
                        <button @click="tab = 'detail'" 
                                class="font-semibold transition-colors pb-2 border-b-2"
                                :class="tab === 'detail' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-primary'">
                            Detail Layanan
                        </button>
                        <button @click="tab = 'info'" 
                                class="font-semibold transition-colors pb-2 border-b-2"
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
                            <p class="text-sm leading-relaxed text-gray-600">
                                Deskripsi lengkap layanan secara detail. Jelaskan apa saja
                                yang perlu diketahui oleh client yang akan memesan layanan.
                                <br><br>
                                Paket ini mencakup:
                                <ul class="list-disc ml-5 mt-2 text-gray-600">
                                    <li>Rekaman Studio 1 Jam</li>
                                    <li>Editing Profesional (Cut, Color Grading, Audio Mixing)</li>
                                    <li>Thumbnail Eksklusif</li>
                                    <li>Upload & Optimasi SEO Youtube</li>
                                </ul>
                            </p>
                        </div>

                        {{-- Info Penting --}}
                        <div x-show="tab === 'info'" style="display: none;"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="space-y-3 text-sm text-gray-600 bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <p class="font-semibold text-blue-800">📋 Syarat & Ketentuan:</p>
                                <ul class="list-disc ml-5 space-y-1">
                                    <li>Materi materi mentah wajib dikirim via Google Drive.</li>
                                    <li>Revisi maksimal 2x (minor).</li>
                                    <li>Tidak menerima konten berbau SARA/Judi/Pornografi.</li>
                                </ul>
                                <p class="font-semibold text-blue-800 mt-4">⚠️ Persiapan Client:</p>
                                <ul class="list-disc ml-5 space-y-1">
                                    <li>Brief topik podcast yang jelas.</li>
                                    <li>Jadwal rekaman H-3.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- TARGET SELECTION --}}
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <p class="mb-2 text-sm font-semibold">Pilih Paket :</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="(package, key) in packages" :key="key">
                                <button @click="pkg = key; qty = 1" 
                                        class="px-4 py-2 text-xs font-semibold rounded-full transition-all border"
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

        {{-- RIGHT: ATUR PEMESANAN --}}
        <div class="p-6 bg-yellow-50 rounded-xl h-fit sticky top-24">
            <h3 class="mb-4 font-bold text-gray-900 border-b border-yellow-100 pb-3">Atur Pemesanan</h3>

            <div class="mb-4 text-sm space-y-2">
                <div class="flex justify-between items-center text-gray-600">
                    <span>Target Views</span>
                    <span class="font-bold text-gray-900" x-text="selectedPkg.viewLabel"></span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Harga Satuan</span>
                    <span class="font-medium" x-text="formatPrice(selectedPkg.price)"></span>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-semibold text-gray-800">Jumlah Pesanan</label>
                <div class="flex items-center gap-3">
                    <button @click="if(qty > 1) qty--" 
                            class="w-8 h-8 flex items-center justify-center bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary transition disabled:opacity-50"
                            :disabled="qty <= 1">
                        -
                    </button>
                    <input type="text" x-model="qty" readonly class="w-12 text-center bg-transparent font-bold text-gray-900 outline-none border-none p-0 focus:ring-0">
                    <button @click="qty++" 
                            class="w-8 h-8 flex items-center justify-center bg-white border border-gray-200 rounded-lg hover:border-primary hover:text-primary transition">
                        +
                    </button>
                </div>
            </div>

            <div class="mb-6 pt-4 border-t border-yellow-200/50">
                <p class="flex justify-between items-end text-sm font-semibold text-gray-800">
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
    </div>

    {{-- RATING & REVIEWS --}}
    <div x-data="{ showModal: false }" class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
        <h3 class="mb-6 text-lg font-bold text-gray-900">Ulasan & Rating</h3>

        <div class="grid grid-cols-1 gap-8 mb-8 md:grid-cols-3">
             {{-- LEFT: SUMMARY --}}
             <div class="flex flex-col justify-center md:col-span-1">
                 <div class="flex items-end gap-2 mb-1">
                     <span class="text-5xl font-bold text-gray-900">4.9</span>
                     <span class="mb-2 text-lg font-semibold text-gray-500">/ 5.0</span>
                 </div>
                 <div class="flex mb-2 text-xl text-yellow-400">
                     @for($i=0; $i<5; $i++) 
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                     @endfor
                 </div>
                 <p class="text-sm text-gray-500">Berdasarkan 120 ulasan</p>
             </div>

             {{-- RIGHT: BARS --}}
             <div class="space-y-2 md:col-span-2">
                 @foreach([5,4,3,2,1] as $star)
                 <div class="flex items-center w-full gap-3 p-1 text-sm transition rounded group hover:bg-gray-50">
                     <span class="w-3 font-medium text-gray-600">{{ $star }}</span>
                     <span class="text-gray-400">★</span>
                     <div class="flex-1 h-2 overflow-hidden bg-gray-100 rounded-full">
                         <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $loop->first ? '80%' : ($loop->iteration == 2 ? '15%' : '0%') }}"></div>
                     </div>
                     <span class="w-6 text-right text-gray-400">{{ $loop->first ? '100' : ($loop->iteration == 2 ? '15' : '0') }}</span>
                 </div>
                 @endforeach
             </div>
        </div>
        
        <div class="pt-6 border-t border-gray-100">
            <h4 class="mb-6 font-bold text-gray-900">Ulasan Pilihan</h4>
            
            {{-- REVIEW ITEM (LOOP) --}}
            <div class="space-y-6">
                <!-- Helper for dummy data -->
                @php 
                    $reviews = [
                        ['name' => 'Budi Santoso', 'date' => '2 Hari yang lalu', 'rating' => 5, 'comment' => 'Sangat puas dengan hasilnya! Pengerjaan cepat dan sesuai brief. Recommended banget buat yang butuh podcast berkualitas.'],
                        ['name' => 'Siti Aminah', 'date' => '1 Minggu yang lalu', 'rating' => 5, 'comment' => 'Editing rapi, audionya jernih. Adminnya juga ramah dan fast respon. Bakal langganan terus nih.'],
                    ];
                @endphp

                @foreach($reviews as $review)
                <div class="flex gap-4">
                     <div class="flex-shrink-0 w-10 h-10 overflow-hidden bg-gray-200 rounded-full">
                         <img src="https://ui-avatars.com/api/?name={{ urlencode($review['name']) }}&background=random" class="object-cover w-full h-full">
                     </div>
                     <div class="flex-1">
                         <div class="flex items-start justify-between mb-1">
                             <div>
                                 <h5 class="text-sm font-bold text-gray-900">{{ $review['name'] }}</h5>
                                 <div class="flex items-center gap-2">
                                     <div class="flex text-xs text-yellow-400">
                                         @for($i=0; $i<$review['rating']; $i++)
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                         @endfor
                                     </div>
                                     <span class="text-xs text-gray-400">• {{ $review['date'] }}</span>
                                 </div>
                             </div>
                         </div>
                         <p class="text-sm leading-relaxed text-gray-600">{{ $review['comment'] }}</p>
                     </div>
                </div>
                <div class="border-b border-gray-50 last:border-0"></div> <!-- Separator -->
                @endforeach
            </div>

            <div class="mt-8">
                 <button @click="showModal = true" class="flex items-center gap-1 text-sm font-semibold text-primary hover:underline">
                     Lihat Semua Ulasan 
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                 </button>
            </div>
        </div>

        {{-- MODAL --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div @click.outside="showModal = false" class="bg-white rounded-2xl w-full max-w-2xl max-h-[80vh] overflow-hidden flex flex-col shadow-2xl">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 bg-white border-b border-gray-100 sticky top-0 z-10">
                    <h3 class="text-lg font-bold">Semua Ulasan (120)</h3>
                    <button @click="showModal = false" class="p-2 text-gray-500 transition rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Body (Scrollable) -->
                <div class="flex-1 p-6 space-y-6 overflow-y-auto">
                    <!-- Dummy repeated content for modal -->
                     @foreach(range(1, 5) as $i)
                        @foreach($reviews as $review)
                        <div class="flex gap-4">
                             <div class="flex-shrink-0 w-10 h-10 overflow-hidden bg-gray-200 rounded-full">
                                 <img src="https://ui-avatars.com/api/?name={{ urlencode($review['name']) }}&background=random" class="object-cover w-full h-full">
                             </div>
                             <div class="flex-1">
                                 <h5 class="text-sm font-bold text-gray-900">{{ $review['name'] }}</h5>
                                 <div class="flex items-center gap-2 mb-2">
                                     <div class="flex text-xs text-yellow-400">
                                         @for($j=0; $j<5; $j++)
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                         @endfor
                                     </div>
                                     <span class="text-xs text-gray-400">• {{ $review['date'] }}</span>
                                 </div>
                                 <p class="text-sm leading-relaxed text-gray-600">{{ $review['comment'] }}</p>
                             </div>
                        </div>
                        <div class="border-b border-gray-100 last:hidden"></div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
