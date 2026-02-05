@extends('layouts.mitra')

@section('title', 'Layanan Saya')

@section('content')
<div x-data="{ 
    services: {{ json_encode($layanan) }},
    openAddModal: false, 
    openDetailModal: false,
    selectedService: null,
    newService: {
        nama_layanan: '',
        kategori: 'Desain Grafis',
        harga: '',
        deskripsi: '',
        thumbnail: '',
        paket: [{ nama: '', harga: '', deskripsi: '' }]
    },

    addService() {
        if (!this.newService.nama_layanan || !this.newService.harga) return;
        
        const service = {
            id: Date.now(),
            ...this.newService,
            status: 'aktif',
            thumbnail: this.newService.thumbnail || 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=500&q=80'
        };
        
        this.services.push(service);
        this.resetForm();
        this.openAddModal = false;
        alert('Layanan berhasil ditambahkan (Frontend Only)!');
    },

    resetForm() {
        this.newService = {
            nama_layanan: '',
            kategori: 'Desain Grafis',
            harga: '',
            deskripsi: '',
            thumbnail: '',
            paket: [{ nama: '', harga: '', deskripsi: '' }]
        };
    },

    addPackage() {
        this.newService.paket.push({ nama: '', harga: '', deskripsi: '' });
    },

    removePackage(index) {
        this.newService.paket.splice(index, 1);
    }
}" class="space-y-8">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Layanan Saya</h1>
            <p class="text-gray-500 mt-1">Kelola portofolio layanan Anda yang muncul di marketplace.</p>
        </div>
        <button @click="openAddModal = true" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Layanan Baru
        </button>
    </div>

    {{-- SERVICES GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="item in services" :key="item.id">
            <div @click="selectedService = item; openDetailModal = true" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all cursor-pointer">
                <div class="relative h-48 overflow-hidden">
                    <img :src="item.thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-4 right-4">
                        <span :class="item.status === 'aktif' ? 'bg-green-500 text-white' : 'bg-gray-400 text-white'" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider" x-text="item.status"></span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-md" x-text="item.kategori"></span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg group-hover:text-primary transition-colors line-clamp-1" x-text="item.nama_layanan"></h3>
                    <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed" x-text="item.deskripsi"></p>
                    
                    <div class="mt-6 pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Mulai dari</p>
                            <p class="text-primary font-bold" x-text="'Rp ' + (new Intl.NumberFormat('id-ID').format(item.harga))"></p>
                        </div>
                        <div class="flex items-center gap-2" @click.stop>
                            <button class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                            <button @click="services = services.filter(s => s.id !== item.id)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- ADD MODAL --}}
    <div x-show="openAddModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
         x-cloak>
        
        <div @click.away="openAddModal = false" 
             class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between flex-shrink-0">
                <h3 class="text-xl font-bold text-gray-800">Tambah Layanan Baru</h3>
                <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form @submit.prevent="addService()" class="flex flex-col flex-1 overflow-hidden">
                <div class="p-8 space-y-6 overflow-y-auto flex-1 custom-scrollbar">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Layanan</label>
                            <input type="text" x-model="newService.nama_layanan" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="Contoh: Desain Logo Minimalis">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                                <select x-model="newService.kategori" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                                    <option>Desain Grafis</option>
                                    <option>Video & Animasi</option>
                                    <option>Penulisan & Penerjemahan</option>
                                    <option>Pemasaran Digital</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga Mulai (Rp)</label>
                                <input type="number" x-model="newService.harga" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="500000">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea x-model="newService.deskripsi" rows="2" required class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="Jelaskan apa yang didapatkan pembeli..."></textarea>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-bold text-gray-700">Paket Layanan</label>
                                <button type="button" @click="addPackage()" class="text-xs font-bold text-primary hover:underline">+ Tambah Paket</button>
                            </div>
                            <template x-for="(pkg, index) in newService.paket" :key="index">
                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 space-y-3 relative">
                                    <button type="button" @click="removePackage(index)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" x-model="pkg.nama" placeholder="Nama Paket (e.g. 10k views)" class="text-xs px-3 py-2 rounded-lg border-gray-200 w-full" required>
                                        <input type="number" x-model="pkg.harga" placeholder="Harga (Rp)" class="text-xs px-3 py-2 rounded-lg border-gray-200 w-full" required>
                                    </div>
                                    <textarea x-model="pkg.deskripsi" rows="2" placeholder="Deskripsi paket..." class="text-xs px-3 py-2 rounded-lg border-gray-200 w-full"></textarea>
                                </div>
                            </template>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail URL</label>
                            <input type="text" x-model="newService.thumbnail" class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm" placeholder="https://unsplash.com/...">
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6 border-t border-gray-50 flex gap-3 flex-shrink-0">
                    <button type="button" @click="openAddModal = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                        Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- DETAIL MODAL --}}
    <div x-show="openDetailModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
         x-cloak>
        
        <div @click.away="openDetailModal = false" 
             class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">
            
            <template x-if="selectedService">
                <div class="flex flex-col h-full overflow-hidden">
                    <div class="relative h-64 flex-shrink-0">
                        <img :src="selectedService.thumbnail" class="w-full h-full object-cover">
                        <button @click="openDetailModal = false" class="absolute top-4 right-4 p-2 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/40 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-8 overflow-y-auto">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg" x-text="selectedService.kategori"></span>
                            <span class="px-2.5 py-1 bg-green-100 text-green-600 text-[10px] font-bold uppercase" x-text="selectedService.status"></span>
                        </div>
                        <h2 class="text-3xl font-black text-gray-800" x-text="selectedService.nama_layanan"></h2>
                        <p class="mt-4 text-gray-500 leading-relaxed" x-text="selectedService.deskripsi"></p>

                        <div class="mt-8">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Paket Tersedia
                            </h3>
                            <div class="grid grid-cols-1 gap-4">
                                <template x-for="paket in selectedService.paket || []" :key="paket.nama">
                                    <div class="p-4 rounded-2xl border border-gray-100 bg-gray-50/50 hover:border-primary/30 transition-all group">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="font-bold text-gray-800 group-hover:text-primary transition-colors" x-text="paket.nama"></h4>
                                            <span class="font-black text-primary" x-text="'Rp ' + (new Intl.NumberFormat('id-ID').format(paket.harga))"></span>
                                        </div>
                                        <p class="text-sm text-gray-500" x-text="paket.deskripsi"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 border-t border-gray-50 flex gap-4">
                        <button @click="openDetailModal = false" class="flex-1 py-4 bg-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-200 transition-all">Tutup</button>
                        <button class="flex-1 py-4 bg-primary text-white font-bold rounded-2xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit Layanan
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection
