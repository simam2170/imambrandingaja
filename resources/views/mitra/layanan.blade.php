@extends('layouts.mitra')

@section('title', 'Layanan Saya')

@section('content')
    <div x-data="{ 
                                                                        services: {{ json_encode($layanan) }},
                                                                        openAddModal: false, 
                                                                        openDetailModal: false,
                                                                        selectedService: null,
                                                                        showDeleteConfirm: false,
                                                                        deleteId: null,
                                                                        notification: { show: false, message: '', type: 'success' },
                                                                        step: 1,
                                                                        editMode: false,
                                                                        editId: null,
                                                                        newService: {
                                                                            nama_layanan: '',
                                                                            klasifikasi: '',
                                                                            estimasi_hari: 1,
                                                                            deskripsi: '',
                                                                            thumbnail: '',
                                                                            detail_klasifikasi: {
                                                                                info: {},
                                                                                tipe: [], // Fallback for non-platform specific
                                                                                platform_pricing: {} // New: { 'Instagram': [{nama:'', harga:''}], 'YouTube': [...] }
                                                                            }
                                                                        },
                                                                        customInput: {},
                                                                        showCustomInput: {},

                                                                klasifikasiList: [
                                                                    { 
                                                                        key: 'berita', label: 'Berita', 
                                                                        icon: `<svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'/></svg>`,
                                                                        color: 'from-blue-500 to-indigo-600',
                                                                        bgLight: 'bg-blue-50 border-blue-200 hover:border-blue-400',
                                                                        desc: 'Pembuatan konten berita, artikel, press release'
                                                                    },
                                                                    { 
                                                                        key: 'sosmed', label: 'Sosial Media',
                                                                        icon: `<svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0h4a1 1 0 011 1v3a4 4 0 01-4 4h-1m-8 0H5a4 4 0 01-4-4V5a1 1 0 011-1h4m0 0V2m0 2h10M9 12v6m3-6v6m3-6v6'/></svg>`,
                                                                        color: 'from-pink-500 to-rose-600',
                                                                        bgLight: 'bg-pink-50 border-pink-200 hover:border-pink-400',
                                                                        desc: 'Manajemen akun, konten, dan pertumbuhan sosial media'
                                                                    },
                                                                    { 
                                                                        key: 'ads_digital', label: 'Ads Digital', 
                                                                        icon: `<svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z'/><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z'/></svg>`,
                                                                        color: 'from-amber-500 to-orange-600',
                                                                        bgLight: 'bg-amber-50 border-amber-200 hover:border-amber-400',
                                                                        desc: 'Iklan digital di Google Ads, Meta Ads, TikTok Ads'
                                                                    },
                                                                    { 
                                                                        key: 'consulting', label: 'Consulting', 
                                                                        icon: `<svg xmlns='http://www.w3.org/2000/svg' class='h-8 w-8' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'/></svg>`,
                                                                        color: 'from-emerald-500 to-teal-600',
                                                                        bgLight: 'bg-emerald-50 border-emerald-200 hover:border-emerald-400',
                                                                        desc: 'Konsultasi branding, marketing, dan strategi konten'
                                                                    }
                                                                ],

                                                                // Field definitions per classification
                                                                fieldDefs: {
                                                                    'berita': {
                                                                        anchorField: 'platform_target',
                                                                        infoFields: [
                                                                            { key: 'platform_target', label: 'Platform Target', options: ['Portal Berita Online', 'Media Nasional', 'Media Lokal', 'Blog / Website'] },
                                                                            { key: 'jenis_konten', label: 'Kategori', options: ['Politik', 'Gaming', 'Lifestyle', 'Kuliner & FnB'], noCustom: true }
                                                                        ],
                                                                        tipeLabel: 'Tipe Penayangan'
                                                                    },
                                                                    'sosmed': {
                                                                        anchorField: 'platform',
                                                                        infoFields: [
                                                                            { key: 'platform', label: 'Platform', options: ['Instagram', 'TikTok', 'YouTube', 'Facebook', 'Twitter/X', 'LinkedIn'] },
                                                                            { key: 'jenis_layanan', label: 'Kategori', options: ['Politik', 'Gaming', 'Lifestyle', 'Kuliner & FnB'], noCustom: true }
                                                                        ],
                                                                        tipeLabel: 'Tipe Kontrak'
                                                                    },
                                                                    'ads_digital': {
                                                                        anchorField: 'platform_iklan',
                                                                        infoFields: [
                                                                            { key: 'platform_iklan', label: 'Platform Iklan', options: ['Google Ads', 'Meta Ads (Facebook/Instagram)', 'TikTok Ads', 'LinkedIn Ads', 'Twitter/X Ads'] },
                                                                            { key: 'jenis_campaign', label: 'Kategori', options: ['Politik', 'Gaming', 'Lifestyle', 'Kuliner & FnB'], noCustom: true }
                                                                        ],
                                                                        tipeLabel: 'Tipe Campaign'
                                                                    },
                                                                    'consulting': {
                                                                        anchorField: 'bidang_konsultasi',
                                                                        infoFields: [
                                                                            { key: 'bidang_konsultasi', label: 'Bidang Konsultasi', options: ['Branding', 'Marketing Strategy', 'Content Strategy', 'Social Media Strategy', 'Business Development'] },
                                                                            { key: 'format', label: 'Kategori', options: ['Politik', 'Gaming', 'Lifestyle', 'Kuliner & FnB'], noCustom: true }
                                                                        ],
                                                                        tipeLabel: 'Tipe Konsultasi'
                                                                    }
                                                                },

                                                                getKlasifikasiLabel(key) {
                                                                    const item = this.klasifikasiList.find(k => k.key === key);
                                                                    return item ? item.label : key;
                                                                },

                                                                getKlasifikasiBadgeClass(key) {
                                                                    const map = {
                                                                        'berita': 'bg-blue-100 text-blue-700',
                                                                        'sosmed': 'bg-pink-100 text-pink-700',
                                                                        'ads_digital': 'bg-amber-100 text-amber-700',
                                                                        'consulting': 'bg-emerald-100 text-emerald-700'
                                                                    };
                                                                    return map[key] || 'bg-gray-100 text-gray-600';
                                                                },

                                                                selectKlasifikasi(key) {
                                                                    this.newService.klasifikasi = key;
                                                                    const def = this.fieldDefs[key];
                                                                    const info = {};
                                                                    (def.infoFields || []).forEach(f => { info[f.key] = []; });
                                                                    this.newService.detail_klasifikasi = {
                                                                        info: info,
                                                                        tipe: [],
                                                                        platform_pricing: {}
                                                                    };
                                                                    this.customInput = {};
                                                                    this.showCustomInput = {};
                                                                    this.step = 2;
                                                                },

                                                                        toggleInfoTag(fieldKey, value) {
                                                                            // Ensure the info field array is initialized
                                                                            if (!this.newService.detail_klasifikasi.info[fieldKey]) {
                                                                                this.newService.detail_klasifikasi.info[fieldKey] = [];
                                                                            }

                                                                            const arr = this.newService.detail_klasifikasi.info[fieldKey];
                                                                            const idx = arr.indexOf(value);
                                                                            const anchorField = this.fieldDefs[this.newService.klasifikasi]?.anchorField;

                                                                            if (idx >= 0) {
                                                                                arr.splice(idx, 1);
                                                                                // If this is anchor field (platform), remove its pricing block
                                                                                if (fieldKey === anchorField) {
                                                                                    delete this.newService.detail_klasifikasi.platform_pricing[value];
                                                                                }
                                                                            } else {
                                                                                arr.push(value);
                                                                                // If this is anchor field, initialize its pricing block
                                                                                if (fieldKey === anchorField) {
                                                                                    this.newService.detail_klasifikasi.platform_pricing[value] = [{ nama: '', harga: '' }];
                                                                                }
                                                                            }
                                                                        },

                                                                        isInfoSelected(fieldKey, value) {
                                                                            return (this.newService.detail_klasifikasi.info[fieldKey] || []).includes(value);
                                                                        },

                                                                        addCustomInfo(fieldKey) {
                                                                            const val = (this.customInput[fieldKey] || '').trim();
                                                                            if (!val) return;

                                                                            // Ensure the info field array is initialized
                                                                            if (!this.newService.detail_klasifikasi.info[fieldKey]) {
                                                                                this.newService.detail_klasifikasi.info[fieldKey] = [];
                                                                            }

                                                                            if (!this.newService.detail_klasifikasi.info[fieldKey].includes(val)) {
                                                                                this.newService.detail_klasifikasi.info[fieldKey].push(val);

                                                                                // Handle pricing block for custom anchor value
                                                                                const anchorField = this.fieldDefs[this.newService.klasifikasi]?.anchorField;
                                                                                if (fieldKey === anchorField) {
                                                                                    this.newService.detail_klasifikasi.platform_pricing[val] = [{ nama: '', harga: '' }];
                                                                                }
                                                                            }
                                                                            this.customInput[fieldKey] = '';
                                                                            this.showCustomInput[fieldKey] = false;
                                                                        },

                                                                        addTipe(platform = null) {
                                                                            if (platform) {
                                                                                this.newService.detail_klasifikasi.platform_pricing[platform].push({ nama: '', harga: '' });
                                                                            } else {
                                                                                this.newService.detail_klasifikasi.tipe.push({ nama: '', harga: '' });
                                                                            }
                                                                        },

                                                                        removeTipe(index, platform = null) {
                                                                            if (platform) {
                                                                                this.newService.detail_klasifikasi.platform_pricing[platform].splice(index, 1);
                                                                            } else {
                                                                                this.newService.detail_klasifikasi.tipe.splice(index, 1);
                                                                            }
                                                                        },

                                                                        async addService() {
                                                                            if (!this.newService.nama_layanan || !this.newService.klasifikasi) return;

                                                                            // Calculate base harga from minimum of all prices
                                                                            let prices = [];

                                                                            // From regular tipe
                                                                            this.newService.detail_klasifikasi.tipe.forEach(t => {
                                                                                if (parseFloat(t.harga) > 0) prices.push(parseFloat(t.harga));
                                                                            });

                                                                            // From platform specific pricing
                                                                            Object.values(this.newService.detail_klasifikasi.platform_pricing).forEach(list => {
                                                                                list.forEach(t => {
                                                                                    if (parseFloat(t.harga) > 0) prices.push(parseFloat(t.harga));
                                                                                });
                                                                            });

                                                                            const baseHarga = prices.length > 0 ? Math.min(...prices) : 0;

                                                                            try {
                                                                                const formData = new FormData();
                                                                                formData.append('nama_layanan', this.newService.nama_layanan);
                                                                                formData.append('klasifikasi', this.newService.klasifikasi);
                                                                                formData.append('harga', baseHarga);
                                                                                formData.append('estimasi_hari', this.newService.estimasi_hari);
                                                                                formData.append('deskripsi', this.newService.deskripsi);

                                                                                const fileInput = document.getElementById('thumbnail_file');
                                                                                if (fileInput && fileInput.files.length > 0) {
                                                                                    formData.append('thumbnail', fileInput.files[0]);
                                                                                } else if (this.newService.thumbnail) {
                                                                                    formData.append('thumbnail_url', this.newService.thumbnail);
                                                                                }

                                                                                // Append info fields
                                                                                Object.entries(this.newService.detail_klasifikasi.info).forEach(([key, values]) => {
                                                                                    values.forEach((val, i) => {
                                                                                        formData.append(`detail_klasifikasi[info][${key}][${i}]`, val);
                                                                                    });
                                                                                });

                                                                                // Append platform specific pricing entries
                                                                                Object.entries(this.newService.detail_klasifikasi.platform_pricing).forEach(([platform, list]) => {
                                                                                    list.forEach((tipe, i) => {
                                                                                        formData.append(`detail_klasifikasi[platform_pricing][${platform}][${i}][nama]`, tipe.nama);
                                                                                        formData.append(`detail_klasifikasi[platform_pricing][${platform}][${i}][harga]`, tipe.harga);
                                                                                    });
                                                                                });

                                                                                // Append regular tipe entries (if any)
                                                                                this.newService.detail_klasifikasi.tipe.forEach((tipe, i) => {
                                                                                    formData.append(`detail_klasifikasi[tipe][${i}][nama]`, tipe.nama);
                                                                                    formData.append(`detail_klasifikasi[tipe][${i}][harga]`, tipe.harga);
                                                                                });

                                                                                let url = '{{ route('mitra.layanan.store') }}';
                                                                                if (this.editMode) {
                                                                                    url = `/mitra/layanan-saya/${this.editId}`;
                                                                                    formData.append('_method', 'PUT');
                                                                                }

                                                                                const response = await fetch(url, {
                                                                                    method: 'POST',
                                                                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                                                    body: formData
                                                                                });

                                                                                const data = await response.json();
                                                                                if (response.ok) {
                                                                                    this.showNotification(this.editMode ? 'Layanan berhasil diperbarui!' : 'Layanan berhasil ditambahkan!');
                                                                                    setTimeout(() => window.location.reload(), 1500);
                                                                                } else {
                                                                                    this.showNotification(data.message || (this.editMode ? 'Gagal mengubah layanan' : 'Gagal menambahkan layanan'), 'error');
                                                                                }
                                                                            } catch (error) {
                                                                                console.error('Error:', error);
                                                                                this.showNotification('Terjadi kesalahan koneksi', 'error');
                                                                            }
                                                                        },

                                                                        showNotification(message, type = 'success') {
                                                                            this.notification.message = message;
                                                                            this.notification.type = type;
                                                                            this.notification.show = true;
                                                                            setTimeout(() => {
                                                                                this.notification.show = false;
                                                                            }, 3000);
                                                                        },

                                                                        resetForm() {
                                                                            this.step = 1;
                                                                            this.editMode = false;
                                                                            this.editId = null;
                                                                            this.newService = {
                                                                                nama_layanan: '',
                                                                                klasifikasi: '',
                                                                                estimasi_hari: 1,
                                                                                deskripsi: '',
                                                                                thumbnail: '',
                                                                                detail_klasifikasi: { info: {}, tipe: [], platform_pricing: {} }
                                                                            };
                                                                            this.customInput = {};
                                                                            this.showCustomInput = {};
                                                                        },

                                                                        startEditService() {
                                                                            this.editMode = true;
                                                                            this.editId = this.selectedService.id;

                                                                            let dk = JSON.parse(JSON.stringify(this.selectedService.detail_klasifikasi || { info: {}, tipe: [], platform_pricing: {} }));
                                                                            if(!dk.info) dk.info = {};
                                                                            if(!dk.tipe) dk.tipe = [];
                                                                            if(!dk.platform_pricing) dk.platform_pricing = {};

                                                                            this.newService = {
                                                                                nama_layanan: this.selectedService.nama_layanan,
                                                                                klasifikasi: this.selectedService.klasifikasi,
                                                                                estimasi_hari: this.selectedService.estimasi_hari || 1,
                                                                                deskripsi: this.selectedService.deskripsi,
                                                                                thumbnail: this.selectedService.thumbnail,
                                                                                detail_klasifikasi: dk
                                                                            };

                                                                            this.step = 2;
                                                                            this.openDetailModal = false;
                                                                            this.openAddModal = true;
                                                                        },

                                                                    deleteService(id) {
                                                                        this.deleteId = id;
                                                                        this.showDeleteConfirm = true;
                                                                    },

                                                                    async confirmDeleteService() {
                                                                        if (!this.deleteId) return;
                                                                        try {
                                                                            const response = await fetch(`/mitra/layanan-saya/${this.deleteId}`, {
                                                                                method: 'DELETE',
                                                                                headers: { 
                                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                                    'Accept': 'application/json'
                                                                                }
                                                                            });

                                                                            const data = await response.json();
                                                                            if (response.ok) {
                                                                                this.services = this.services.filter(s => s.id !== this.deleteId);
                                                                                if (this.selectedService && this.selectedService.id === this.deleteId) {
                                                                                    this.openDetailModal = false;
                                                                                }
                                                                                this.showNotification('Layanan berhasil dihapus!');
                                                                            } else {
                                                                                this.showNotification(data.message || 'Gagal menghapus layanan', 'error');
                                                                            }
                                                                        } catch (error) {
                                                                            console.error('Error:', error);
                                                                            this.showNotification('Terjadi kesalahan koneksi', 'error');
                                                                        } finally {
                                                                            this.showDeleteConfirm = false;
                                                                            this.deleteId = null;
                                                                        }
                                                                    },

                                                                        formatRupiah(val) {
                                                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                                                                        },

                                                                        getMinHarga(service) {
                                                                            const dk = service.detail_klasifikasi;
                                                                            if (!dk) return service.harga || 0;

                                                                            let prices = [];
                                                                            if (dk.tipe && Array.isArray(dk.tipe)) {
                                                                                dk.tipe.forEach(t => {
                                                                                    if (parseFloat(t.harga) > 0) prices.push(parseFloat(t.harga));
                                                                                });
                                                                            }
                                                                            if (dk.platform_pricing) {
                                                                                Object.values(dk.platform_pricing).forEach(list => {
                                                                                    list.forEach(t => {
                                                                                        if (parseFloat(t.harga) > 0) prices.push(parseFloat(t.harga));
                                                                                    });
                                                                                });
                                                                            }

                                                                            if (prices.length > 0) return Math.min(...prices);
                                                                            return service.harga || 0;
                                                                        },

                                                                        getDetailLabel(key) {
                                                                            const labels = {
                                                                                'platform_target': 'Platform Target', 'jenis_konten': 'Jenis Konten',
                                                                                'platform': 'Platform', 'jenis_layanan': 'Jenis Layanan',
                                                                                'platform_iklan': 'Platform Iklan', 'jenis_campaign': 'Jenis Campaign',
                                                                                'bidang_konsultasi': 'Bidang Konsultasi', 'format': 'Format'
                                                                            };
                                                                            return labels[key] || key;
                                                                        },

                                                                        getTipeLabel(klasifikasi) {
                                                                            const def = this.fieldDefs[klasifikasi];
                                                                            return def ? def.tipeLabel : 'Tipe';
                                                                        },

                                                                        getServiceInfoEntries(service) {
                                                                            const dk = service.detail_klasifikasi;
                                                                            if (!dk) return [];
                                                                            // New format with info object
                                                                            if (dk.info) return Object.entries(dk.info).filter(([k, v]) => Array.isArray(v) && v.length > 0);
                                                                            return [];
                                                                        },

                                                                        getServiceTipe(service) {
                                                                            const dk = service.detail_klasifikasi;
                                                                            if (!dk) return [];

                                                                            let allTipe = [];
                                                                            if (dk.tipe) {
                                                                                allTipe = [...dk.tipe.filter(t => t.nama)];
                                                                            }

                                                                            if (dk.platform_pricing) {
                                                                                Object.entries(dk.platform_pricing).forEach(([platform, list]) => {
                                                                                    list.forEach(t => {
                                                                                        if (t.nama) {
                                                                                            allTipe.push({
                                                                                                ...t,
                                                                                                nama: `${platform} - ${t.nama}`
                                                                                            });
                                                                                        }
                                                                                    });
                                                                                });
                                                                            }

                                                                            return allTipe;
                                                                        }
                                                                    }" class="space-y-8">
        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Layanan Saya</h1>
                <p class="text-gray-500 mt-1">Kelola portofolio layanan Anda yang muncul di marketplace.</p>
            </div>
            <button @click="openAddModal = true; resetForm()"
                class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Layanan Baru
            </button>
        </div>

        {{-- FILTER TABS --}}
        <div x-data="{ filter: 'semua' }" class="space-y-6">
            <div class="flex gap-2 flex-wrap">
                <button @click="filter = 'semua'" class="px-4 py-2 text-sm font-bold rounded-full transition-all"
                    :class="filter === 'semua' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                    Semua
                </button>
                <template x-for="kl in klasifikasiList" :key="kl.key">
                    <button @click="filter = kl.key" class="px-4 py-2 text-sm font-bold rounded-full transition-all"
                        :class="filter === kl.key ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        x-text="kl.label">
                    </button>
                </template>
            </div>

            {{-- SERVICES GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <template x-for="item in services.filter(s => filter === 'semua' || s.klasifikasi === filter)"
                    :key="item.id">
                    <div @click="selectedService = item; openDetailModal = true"
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all cursor-pointer">
                        <div class="relative aspect-[3/2] overflow-hidden">
                            <img :src="item.thumbnail"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 right-4">
                                <span
                                    :class="item.status === 'aktif' ? 'bg-green-500 text-white' : 'bg-gray-400 text-white'"
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                    x-text="item.status"></span>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span :class="getKlasifikasiBadgeClass(item.klasifikasi)"
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider backdrop-blur-sm"
                                    x-text="getKlasifikasiLabel(item.klasifikasi)"></span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-gray-800 text-lg group-hover:text-primary transition-colors line-clamp-1"
                                x-text="item.nama_layanan"></h3>
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed" x-text="item.deskripsi"></p>

                            <div class="mt-6 pt-4 border-t border-gray-50 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Mulai dari</p>
                                    <p class="text-primary font-bold" x-text="formatRupiah(getMinHarga(item))"></p>
                                </div>
                                <div class="flex items-center gap-2" @click.stop>
                                    <button @click.stop="selectedService = item; startEditService()"
                                        class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button @click="deleteService(item.id)"
                                        class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ==================== ADD MODAL ==================== --}}
        <div x-show="openAddModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak>

            <div @click.away="openAddModal = false"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100">

                <!-- Header -->
                <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-gray-800"
                            x-text="editMode ? 'Edit Layanan' : 'Tambah Layanan Baru'"></h3>
                        <div class="flex items-center gap-2">
                            <span
                                class="w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center transition-all"
                                :class="step >= 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500'">1</span>
                            <div class="w-8 h-0.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-primary transition-all duration-300"
                                    :style="step >= 2 ? 'width:100%' : 'width:0%'"></div>
                            </div>
                            <span
                                class="w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center transition-all"
                                :class="step >= 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500'">2</span>
                        </div>
                    </div>
                    <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- ===== STEP 1: PILIH KLASIFIKASI ===== --}}
                <div x-show="step === 1" class="p-8 overflow-y-auto flex-1 custom-scrollbar">
                    <div class="text-center mb-8">
                        <h4 class="text-lg font-bold text-gray-800">Pilih Klasifikasi Layanan</h4>
                        <p class="text-sm text-gray-500 mt-1">Pilih jenis layanan yang ingin Anda tawarkan</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <template x-for="kl in klasifikasiList" :key="kl.key">
                            <button @click="selectKlasifikasi(kl.key)" :class="kl.bgLight"
                                class="p-6 rounded-2xl border-2 text-left transition-all hover:shadow-md group relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 w-24 h-24 opacity-5 transform translate-x-6 -translate-y-6">
                                    <div class="w-full h-full rounded-full" :class="'bg-gradient-to-br ' + kl.color"></div>
                                </div>
                                <div class="mb-3" :class="kl.color.replace('from-', 'text-').split(' ')[0]"
                                    x-html="kl.icon"></div>
                                <h5 class="font-bold text-gray-800 text-base" x-text="kl.label"></h5>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed" x-text="kl.desc"></p>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- ===== STEP 2: DETAIL LAYANAN ===== --}}
                <form x-show="step === 2" @submit.prevent="addService()" class="flex flex-col flex-1 overflow-hidden">
                    <div class="p-8 space-y-6 overflow-y-auto flex-1 custom-scrollbar">

                        {{-- Klasifikasi badge + back --}}
                        <div class="flex items-center gap-3">
                            <button type="button" @click="step = 1"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <span :class="getKlasifikasiBadgeClass(newService.klasifikasi)"
                                class="px-3 py-1.5 rounded-full text-xs font-bold"
                                x-text="'Klasifikasi: ' + getKlasifikasiLabel(newService.klasifikasi)"></span>
                        </div>

                        <div class="space-y-5">
                            {{-- Nama Layanan --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Layanan</label>
                                <input type="text" x-model="newService.nama_layanan" required
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm"
                                    placeholder="Contoh: Pembuatan Artikel SEO">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Estimasi Hari Kerja</label>
                                    <input type="number" x-model="newService.estimasi_hari" min="1" required
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Singkat</label>
                                <textarea x-model="newService.deskripsi" rows="2" required
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm"
                                    placeholder="Jelaskan apa yang didapatkan pembeli..."></textarea>
                            </div>

                            {{-- ===== INFO FIELDS (multi-tag selector) ===== --}}
                            <div class="p-5 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50/50 space-y-5">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <h5 class="text-sm font-bold text-gray-700">Detail <span
                                            x-text="getKlasifikasiLabel(newService.klasifikasi)"></span></h5>
                                </div>
                                <p class="text-xs text-gray-400 -mt-3">Pilih atau tambahkan detail layanan. Klik untuk
                                    memilih, klik lagi untuk membatalkan.</p>

                                <template x-for="field in (fieldDefs[newService.klasifikasi]?.infoFields || [])"
                                    :key="field.key">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-600" x-text="field.label"></label>
                                        <div class="flex flex-wrap gap-2">
                                            {{-- Predefined options as tags --}}
                                            <template x-for="opt in field.options" :key="opt">
                                                <button type="button" @click="toggleInfoTag(field.key, opt)"
                                                    class="px-3 py-1.5 rounded-full text-xs font-semibold border transition-all"
                                                    :class="isInfoSelected(field.key, opt) 
                                                                                                                            ? 'bg-primary text-white border-primary shadow-sm' 
                                                                                                                            : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                                    x-text="opt">
                                                </button>
                                            </template>

                                            {{-- Custom added tags --}}
                                            <template
                                                x-for="val in (newService.detail_klasifikasi.info[field.key] || []).filter(v => !(field.options || []).includes(v))"
                                                :key="val">
                                                <span
                                                    class="px-3 py-1.5 rounded-full text-xs font-semibold bg-primary text-white border border-primary shadow-sm flex items-center gap-1">
                                                    <span x-text="val"></span>
                                                    <button type="button" @click="toggleInfoTag(field.key, val)"
                                                        class="hover:text-white/70">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            </template>

                                            {{-- Add custom button — hidden for noCustom fields --}}
                                            <div class="relative" x-show="!field.noCustom">
                                                <button type="button" x-show="!showCustomInput[field.key]"
                                                    @click="showCustomInput[field.key] = true; $nextTick(() => $refs['customInput_' + field.key]?.focus())"
                                                    class="px-3 py-1.5 rounded-full text-xs font-semibold border border-dashed border-gray-300 text-gray-400 hover:border-primary hover:text-primary transition-all flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Tambah
                                                </button>
                                                <div x-show="showCustomInput[field.key]" class="flex items-center gap-1">
                                                    <input type="text" x-model="customInput[field.key]"
                                                        :x-ref="'customInput_' + field.key"
                                                        @keydown.enter.prevent="addCustomInfo(field.key)"
                                                        @keydown.escape="showCustomInput[field.key] = false"
                                                        class="px-3 py-1.5 rounded-full text-xs border border-gray-300 focus:border-primary focus:ring-primary w-32"
                                                        placeholder="Ketik...">
                                                    <button type="button" @click="addCustomInfo(field.key)"
                                                        class="p-1 text-primary hover:text-primary/70">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" @click="showCustomInput[field.key] = false"
                                                        class="p-1 text-gray-400 hover:text-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- ===== TIPE + HARGA (per platform or global) ===== --}}
                            <div class="space-y-4">
                                {{-- Global Tipe (if no anchor field selected) --}}
                                <template x-if="Object.keys(newService.detail_klasifikasi.platform_pricing).length === 0">
                                    <div
                                        class="p-5 rounded-2xl border-2 border-dashed border-primary/30 bg-primary/5 space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <h5 class="text-sm font-bold text-gray-700"
                                                    x-text="getTipeLabel(newService.klasifikasi) + ' & Harga'"></h5>
                                            </div>
                                            <button type="button" @click="addTipe()"
                                                class="text-xs font-bold text-primary hover:text-primary/80 transition-all flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Tipe
                                            </button>
                                        </div>
                                        <div class="space-y-3">
                                            <template x-for="(tipe, index) in newService.detail_klasifikasi.tipe"
                                                :key="index">
                                                <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                                                    <div class="flex gap-3 items-start">
                                                        <div class="flex-1 space-y-2">
                                                            <input type="text" x-model="tipe.nama"
                                                                class="w-full px-3 py-2.5 rounded-lg border-gray-200 text-sm focus:border-primary focus:ring-primary"
                                                                :placeholder="getTipeLabel(newService.klasifikasi)">
                                                        </div>
                                                        <div class="w-44">
                                                            <div class="relative">
                                                                <span
                                                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-bold">Rp</span>
                                                                <input type="number" x-model="tipe.harga"
                                                                    placeholder="Harga"
                                                                    class="w-full pl-9 pr-3 py-2.5 rounded-lg border-gray-200 text-sm focus:border-primary focus:ring-primary">
                                                            </div>
                                                        </div>
                                                        <button type="button" @click="removeTipe(index)"
                                                            x-show="newService.detail_klasifikasi.tipe.length > 1"
                                                            class="p-2 text-gray-300 hover:text-red-500 transition-colors mt-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                {{-- Platform Specific Tipe --}}
                                <template x-for="(list, platform) in newService.detail_klasifikasi.platform_pricing"
                                    :key="platform">
                                    <div class="p-5 rounded-2xl border-2 border-primary/20 bg-primary/5 space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-xs"
                                                    x-text="platform.substring(0,2).toUpperCase()"></div>
                                                <div>
                                                    <h5 class="text-sm font-bold text-gray-700" x-text="platform"></h5>
                                                    <p class="text-[10px] text-gray-400">Tentukan harga khusus untuk
                                                        platform ini</p>
                                                </div>
                                            </div>
                                            <button type="button" @click="addTipe(platform)"
                                                class="text-xs font-bold text-primary hover:text-primary/80 transition-all flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Tipe
                                            </button>
                                        </div>

                                        <div class="space-y-3">
                                            <template x-for="(tipe, index) in list" :key="index">
                                                <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
                                                    <div class="flex gap-3 items-start">
                                                        <div class="flex-1 space-y-2">
                                                            <input type="text" x-model="tipe.nama"
                                                                class="w-full px-3 py-2.5 rounded-lg border-gray-200 text-sm focus:border-primary focus:ring-primary"
                                                                :placeholder="getTipeLabel(newService.klasifikasi) + ' (e.g. Basic, Premium)'">
                                                        </div>
                                                        <div class="w-44">
                                                            <div class="relative">
                                                                <span
                                                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-bold">Rp</span>
                                                                <input type="number" x-model="tipe.harga"
                                                                    placeholder="Harga"
                                                                    class="w-full pl-9 pr-3 py-2.5 rounded-lg border-gray-200 text-sm focus:border-primary focus:ring-primary">
                                                            </div>
                                                        </div>
                                                        <button type="button" @click="removeTipe(index, platform)"
                                                            x-show="list.length > 1"
                                                            class="p-2 text-gray-300 hover:text-red-500 transition-colors mt-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- THUMBNAIL --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail Layanan</label>
                                <div class="space-y-3">
                                    <input type="file" id="thumbnail_file" accept="image/*"
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                                    <div class="relative">
                                        <div
                                            class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center px-4 pointer-events-none">
                                            <div class="w-full border-t border-gray-100"></div>
                                        </div>
                                        <div
                                            class="relative flex justify-center text-[10px] uppercase font-bold text-gray-400">
                                            <span class="bg-white px-2">Atau gunakan URL</span>
                                        </div>
                                    </div>
                                    <input type="text" x-model="newService.thumbnail"
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm"
                                        placeholder="https://unsplash.com/...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-6 border-t border-gray-50 flex gap-3 flex-shrink-0">
                        <button type="button" @click="step = 1"
                            class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </button>
                        <button type="submit"
                            class="flex-1 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all"
                            x-text="editMode ? 'Simpan Perubahan' : 'Simpan Layanan'">
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ==================== DETAIL MODAL (TOKOPEDIA STYLE) ==================== --}}
        <div x-show="openDetailModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak>

            <div @click.away="openDetailModal = false"
                class="bg-white rounded-[32px] shadow-2xl w-full max-w-5xl overflow-hidden max-h-[90vh] flex flex-col"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-data="{ detailTab: 'detail' }">

                <template x-if="selectedService">
                    <div class="flex flex-col md:flex-row h-full overflow-hidden">
                        {{-- LEFT: IMAGE PANEL --}}
                        <div class="md:w-2/5 p-8 bg-gray-50/50 flex flex-col">
                            <div
                                class="relative aspect-square rounded-2xl overflow-hidden shadow-sm border border-gray-100 bg-white group">
                                <img :src="selectedService.thumbnail"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute top-4 left-4 flex flex-col gap-2">
                                    <span :class="getKlasifikasiBadgeClass(selectedService.klasifikasi)"
                                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm backdrop-blur-md"
                                        x-text="getKlasifikasiLabel(selectedService.klasifikasi)"></span>
                                    <span
                                        class="px-3 py-1.5 bg-white/90 text-green-600 text-[10px] font-black uppercase rounded-lg shadow-sm backdrop-blur-md flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        <span x-text="selectedService.status"></span>
                                    </span>
                                </div>
                            </div>

                            {{-- MINI STATS --}}
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <div class="p-3 bg-white rounded-xl border border-gray-100 shadow-sm">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Terjual</p>
                                    <p class="text-sm font-black text-gray-800"
                                        x-text="(selectedService.sold_count || 0) + ' +'"></p>
                                </div>
                                <div class="p-3 bg-white rounded-xl border border-gray-100 shadow-sm">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Rating</p>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <p class="text-sm font-black text-gray-800">
                                            <span
                                                x-text="selectedService.reviews_avg_rating ? parseFloat(selectedService.reviews_avg_rating).toFixed(1) : '0.0'"></span>
                                            <span class="text-[10px] text-gray-400 font-bold"
                                                x-text="'(' + (selectedService.reviews_count || 0) + ')'"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: INFO PANEL --}}
                        <div class="md:w-3/5 flex flex-col bg-white">
                            {{-- CLOSE BUTTON --}}
                            <button @click="openDetailModal = false"
                                class="absolute top-6 right-6 p-2 text-gray-300 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="p-10 flex-1 overflow-y-auto custom-scrollbar">
                                {{-- TITLE --}}
                                <h2 class="text-2xl font-black text-gray-900 leading-tight mb-2"
                                    x-text="selectedService.nama_layanan"></h2>

                                {{-- PRICE --}}
                                <div class="flex items-baseline gap-2 mb-8">
                                    <span class="text-3xl font-black text-primary"
                                        x-text="formatRupiah(getMinHarga(selectedService))"></span>
                                    <span class="text-xs font-bold text-gray-400">/ Paket Terendah</span>
                                </div>

                                {{-- TOKOPEDIA TABS --}}
                                <div class="border-b border-gray-100 mb-6 flex gap-8">
                                    <button @click="detailTab = 'detail'"
                                        class="pb-3 text-sm font-black transition-all border-b-4"
                                        :class="detailTab === 'detail' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'">
                                        Detail Produk
                                    </button>
                                    <button @click="detailTab = 'spesifikasi'"
                                        class="pb-3 text-sm font-black transition-all border-b-4"
                                        :class="detailTab === 'spesifikasi' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'">
                                        Spesifikasi
                                    </button>
                                    <button @click="detailTab = 'info'"
                                        class="pb-3 text-sm font-black transition-all border-b-4"
                                        :class="detailTab === 'info' ? 'text-primary border-primary' : 'text-gray-400 border-transparent hover:text-gray-600'">
                                        Info Penting
                                    </button>
                                </div>

                                {{-- TAB CONTENTS --}}
                                <div class="space-y-6 min-h-[200px]">
                                    {{-- 1. DETAIL PRODUK --}}
                                    <div x-show="detailTab === 'detail'" x-transition class="space-y-4">
                                        <div class="flex gap-2 text-xs">
                                            <span class="font-bold text-gray-400 w-24">Kondisi:</span>
                                            <span class="font-black text-gray-800">Baru</span>
                                        </div>
                                        <div class="flex gap-2 text-xs">
                                            <span class="font-bold text-gray-400 w-24">Waktu Kerja:</span>
                                            <span class="font-black text-primary"
                                                x-text="selectedService.estimasi_hari + ' Hari'"></span>
                                        </div>
                                        <div class="pt-4 border-t border-gray-50">
                                            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line"
                                                x-text="selectedService.deskripsi"></p>
                                        </div>
                                    </div>

                                    {{-- 2. SPESIFIKASI (Info Tags) --}}
                                    <div x-show="detailTab === 'spesifikasi'" x-transition class="space-y-6">
                                        <template x-if="getServiceInfoEntries(selectedService).length > 0">
                                            <div class="grid grid-cols-1 gap-6">
                                                <template x-for="([key, values]) in getServiceInfoEntries(selectedService)"
                                                    :key="key">
                                                    <div class="flex gap-4">
                                                        <p class="text-xs font-bold text-gray-400 w-28 shrink-0 py-1"
                                                            x-text="getDetailLabel(key)"></p>
                                                        <div class="flex flex-wrap gap-2">
                                                            <template x-for="val in values" :key="val">
                                                                <span
                                                                    class="px-3 py-1 bg-primary/5 text-primary text-[10px] font-black rounded-lg border border-primary/10"
                                                                    x-text="val"></span>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                        <template x-if="getServiceInfoEntries(selectedService).length === 0">
                                            <p class="text-xs text-gray-400 italic italic">Tidak ada spesifikasi tambahan.
                                            </p>
                                        </template>
                                    </div>

                                    {{-- 3. INFO PENTING --}}
                                    <div x-show="detailTab === 'info'" x-transition
                                        class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                                        <h5 class="text-sm font-black text-gray-800 mb-3 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Kebijakan Layanan
                                        </h5>
                                        <ul class="text-xs text-gray-500 space-y-2 list-disc list-inside">
                                            <li>Pastikan detail pesanan sudah sesuai sebelum checkout.</li>
                                            <li>Revisi dapat dilakukan sesuai dengan paket yang dipilih.</li>
                                            <li>Komunikasi dilakukan sepenuhnya melalui sistem BrandingAja.</li>
                                            <li>Pelunasan dilakukan setelah pekerjaan dinyatakan selesai.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER ACTIONS --}}
                            <div class="p-8 border-t border-gray-50 bg-gray-50/30 flex gap-4">
                                <button
                                    @click="selectedService = selectedService; startEditService(); openDetailModal = false"
                                    class="flex-1 py-4 bg-white border-2 border-primary text-primary font-black rounded-2xl hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit Layanan
                                </button>
                                <button @click="openDetailModal = false"
                                    class="flex-1 py-4 bg-gray-900 text-white font-black rounded-2xl hover:bg-gray-800 transition-all shadow-xl shadow-gray-200">
                                    Tutup Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        {{-- ==================== DELETE CONFIRMATION MODAL ==================== --}}
        <div x-show="showDeleteConfirm" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak>
            <div @click.away="showDeleteConfirm = false"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden p-8 text-center"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Layanan?</h3>
                <p class="text-gray-500 text-sm mb-8">Apakah Anda yakin ingin menghapus layanan ini? Tindakan ini tidak
                    dapat dibatalkan.</p>
                <div class="flex gap-3">
                    <button @click="showDeleteConfirm = false"
                        class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">
                        Batal
                    </button>
                    <button @click="confirmDeleteService()"
                        class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl shadow-lg shadow-red-500/20 hover:bg-red-600 transition-all">
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        {{-- ==================== TOAST NOTIFICATION ==================== --}}
        <div x-show="notification.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4 md:translate-y-0 md:translate-x-4"
            x-transition:enter-end="opacity-100 transform translate-y-0 md:translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed bottom-6 right-6 z-[70] w-full max-w-sm" x-cloak>
            <div :class="notification.type === 'success' ? 'bg-white border-green-500' : 'bg-white border-red-500'"
                class="rounded-2xl shadow-2xl border-l-4 p-5 flex items-center gap-4 bg-white">
                <div :class="notification.type === 'success' ? 'bg-green-50 text-green-500' : 'bg-red-50 text-red-500'"
                    class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                    <template x-if="notification.type === 'success'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </template>
                    <template x-if="notification.type === 'error'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </template>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-sm"
                        x-text="notification.type === 'success' ? 'Berhasil!' : 'Gagal!'"></h4>
                    <p class="text-xs text-gray-500 mt-0.5" x-text="notification.message"></p>
                </div>
                <button @click="notification.show = false" class="ml-auto text-gray-300 hover:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection