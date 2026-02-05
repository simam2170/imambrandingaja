@extends('layouts.user')
@section('title', 'Invoice')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8" x-data="{
            order: JSON.parse(localStorage.getItem('currentOrder') || '{}'),
            showUpload: false,
            proofFile: null,
            proofPreview: null,
            uploadStatus: '', // '', 'uploading', 'success'
            timeLeft: '24:00:00',

            init() {
                if (this.order.status === 'direview' && !this.order.hasProof) {
                    this.startTimer();
                }
            },

            startTimer() {
                const orderTime = new Date(this.order.timestamp).getTime();
                const deadline = orderTime + (24 * 60 * 60 * 1000); // 24 hours later

                const update = () => {
                    const now = new Date().getTime();
                    const diff = deadline - now;

                    if (diff <= 0) {
                        this.timeLeft = '00:00:00';
                        this.order.status = 'ditolak';
                        localStorage.setItem('currentOrder', JSON.stringify(this.order));
                        return;
                    }

                    const h = Math.floor(diff / (1000 * 60 * 60));
                    const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((diff % (1000 * 60)) / 1000);

                    this.timeLeft = [h, m, s].map(v => v.toString().padStart(2, '0')).join(':');
                    setTimeout(update, 1000);
                };
                update();
            },

            // Status Logic
            statuses: ['direview', 'diproses', 'selesai', 'ditolak'],
            get currentStatusIndex() {
                return this.statuses.indexOf(this.order.status);
            },

            formatPrice(value) {
                return value ? 'Rp' + value.toLocaleString('id-ID') : 'Rp0';
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                // Validation
                const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    return alert('Hanya file JPG, PNG, atau PDF yang diperbolehkan.');
                }
                if (file.size > 2 * 1024 * 1024) {
                    return alert('Ukuran file maksimal 2MB.');
                }

                this.proofFile = file;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => this.proofPreview = e.target.result;
                    reader.readAsDataURL(file);
                } else {
                    this.proofPreview = 'pdf-icon'; // Simplified for demo
                }
            },

            submitProof() {
                if (!this.proofFile) return alert('Pilih file terlebih dahulu.');
                this.uploadStatus = 'uploading';
                setTimeout(() => {
                    this.uploadStatus = 'success';
                    this.showUpload = false;
                    // Proof saved mock
                    this.order.hasProof = true;
                    localStorage.setItem('currentOrder', JSON.stringify(this.order));
                }, 1500);
            },

            cancelOrder() {
                if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                    this.order.status = 'ditolak';
                    localStorage.setItem('currentOrder', JSON.stringify(this.order));
                    alert('Pesanan telah dibatalkan.');
                }
            },

            // Admin Simulation
            simulateAdminAction(newStatus) {
                this.order.status = newStatus;
                localStorage.setItem('currentOrder', JSON.stringify(this.order));
            }
        }">

        {{-- STATUS HEADER --}}
        <div class="p-8 bg-white border border-gray-100 shadow-sm rounded-3xl text-center">
            <template x-if="!order.hasProof">
                <h2 class="text-2xl font-black text-gray-800">Menunggu Pembayaran</h2>
            </template>
            <template x-if="order.hasProof">
                <h2 class="text-2xl font-black text-blue-600">Pembayaran Sedang Diverifikasi</h2>
            </template>

            <div class="pt-4 space-y-4 border-t border-yellow-200" x-show="!order.hasProof">
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Batas Waktu Pembayaran</p>
                <p class="font-mono text-2xl font-black text-red-600" x-text="timeLeft"></p>
                <p class="text-[10px] text-red-600 font-bold leading-relaxed">
                    Pesanan Anda akan diproses jika sudah upload bukti pembayaran.
                </p>
            </div>
            
            <template x-if="order.hasProof">
                <div class="pt-4 text-center">
                    <p class="text-sm text-gray-500">Terima kasih! Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi oleh admin.</p>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            {{-- LEFT: ORDER INFO --}}
            <div class="space-y-6 md:col-span-2">
                <section class="p-6 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-3xl">
                    <div class="flex items-start justify-between mb-6">
                        <h3 class="flex items-center gap-2 font-bold text-gray-800">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Detail Pesanan
                        </h3>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order ID</p>
                            <p class="font-bold text-gray-800" x-text="'#' + order.id"></p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <template x-for="item in order.items" :key="item.id">
                            <div class="flex items-center gap-4 p-4 border bg-gray-50/50 rounded-2xl border-gray-50">
                                <div class="w-16 h-16 bg-gray-200 rounded-xl shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="mb-1 text-sm font-bold text-gray-800 truncate" x-text="item.name"></h4>
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span x-text="item.seller"></span>
                                        <span class="font-bold text-yellow-600"
                                            x-text="item.qty + ' x ' + formatPrice(item.price)"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-200 border-dashed">
                        <span class="text-xs font-bold tracking-widest text-gray-500 uppercase">Total Pembayaran</span>
                        <span class="text-2xl font-black text-gray-800" x-text="formatPrice(order.total)"></span>
                    </div>
                </section>

                <section class="p-6 bg-white border border-gray-100 shadow-sm rounded-3xl">
                    <h3 class="flex items-center gap-2 mb-6 font-bold text-gray-800">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pemesan
                    </h3>
                    <div class="grid grid-cols-2 text-sm gap-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama</p>
                            <p class="font-bold text-gray-800" x-text="order.user?.name"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">WhatsApp</p>
                            <p class="font-bold text-gray-800" x-text="order.user?.whatsapp || '-'"></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Catatan</p>
                            <p class="italic text-gray-600" x-text="order.user?.note || 'Tidak ada catatan'"></p>
                        </div>
                    </div>
                </section>
            </div>

            {{-- RIGHT: PAYMENT INSTRUCTIONS --}}
            <div class="space-y-6">
                <section class="p-6 border border-yellow-100 shadow-sm bg-yellow-50 rounded-3xl">
                    <h3 class="flex items-center gap-2 mb-4 font-bold text-yellow-800">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Instruksi Pembayaran
                    </h3>
                    <div class="space-y-4">
                        {{-- BANK TRANSFER INSTRUCTIONS --}}
                        <template x-if="order.payment?.type === 'bank'">
                            <div class="p-4 bg-white border border-yellow-200 rounded-2xl">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1" x-text="order.payment?.name"></p>
                                <p class="mb-1 text-sm font-black text-gray-800" x-text="'Bank ' + order.payment?.name"></p>
                                <div class="flex items-center justify-between px-2 py-1 font-mono text-lg font-bold text-yellow-600 rounded-lg bg-yellow-50">
                                    <span x-text="order.payment?.id === 'bca' ? '123 456 7890' : '987 654 3210'"></span>
                                    <button @click="alert('Copied!')" class="text-[10px] font-bold text-blue-500 uppercase">Copy</button>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2">a.n PT Branding Aja Indonesia</p>
                            </div>
                        </template>

                        {{-- E-WALLET / QRIS INSTRUCTIONS --}}
                        <template x-if="order.payment?.type === 'ewallet'">
                            <div class="p-4 bg-white border border-yellow-200 rounded-2xl text-center">
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-3 text-left" x-text="order.payment?.name"></p>
                                <div class="w-32 h-32 bg-gray-100 rounded-xl mx-auto mb-3 flex items-center justify-center border-2 border-dashed border-gray-200">
                                    <span class="text-3xl">🔳</span>
                                </div>
                                <p class="text-xs font-bold text-gray-800 mb-1">Pindai QRIS</p>
                                <p class="text-[10px] text-gray-500 leading-relaxed">Silakan pindai kode QR di atas menggunakan aplikasi e-wallet Anda.</p>
                            </div>
                        </template>

                        {{-- SHOW ONLY IF NO PROOF YET --}}
                        <template x-if="!order.hasProof && order.status === 'direview'">
                            <div class="space-y-6">
                                <div class="w-full p-6 bg-white border border-gray-100 shadow-sm rounded-3xl">
                                    <h3 class="mb-4 text-lg font-black text-gray-800">Upload Bukti Bayar</h3>

                                    <div class="space-y-4">
                                        <div class="relative group">
                                            <div
                                                class="relative flex flex-col items-center justify-center w-full h-40 gap-3 overflow-hidden transition-all border-2 border-gray-100 border-dashed rounded-2xl bg-gray-50 group-hover:bg-gray-100">
                                                <template x-if="!proofPreview">
                                                    <div class="p-4 text-center">
                                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <p class="text-[10px] font-bold text-gray-400 uppercase">Pilih File</p>
                                                    </div>
                                                </template>
                                                <template x-if="proofPreview === 'pdf-icon'">
                                                    <div class="text-center">
                                                        <svg class="w-10 h-10 mx-auto text-red-400" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <p class="mt-2 text-[10px] font-bold text-gray-500 truncate px-4" x-text="proofFile.name"></p>
                                                    </div>
                                                </template>
                                                <template x-if="proofPreview && proofPreview !== 'pdf-icon'">
                                                    <img :src="proofPreview" class="object-cover w-full h-full">
                                                </template>
                                                <input type="file" @change="handleFileUpload"
                                                    class="absolute inset-0 opacity-0 cursor-pointer">
                                            </div>
                                        </div>

                                        <button @click="submitProof()"
                                            class="flex items-center justify-center w-full gap-2 py-3 font-bold text-gray-900 transition-all bg-yellow-400 shadow-lg hover:bg-yellow-500 rounded-2xl shadow-yellow-100"
                                            :disabled="uploadStatus === 'uploading'">
                                            <span x-show="uploadStatus !== 'uploading'">Kirim Bukti</span>
                                            <span x-show="uploadStatus === 'uploading'" class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-900 animate-spin"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Mengirim...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        {{-- SHOW SUCCESS MESSAGE IF PROOF UPLOADED --}}
                        <template x-if="order.hasProof && order.status === 'direview'">
                            <div class="p-6 text-center border border-blue-100 bg-blue-50/50 rounded-3xl">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm font-black text-blue-600">Bukti Pembayaran Terupload</p>
                                <p class="text-[10px] text-blue-400 mt-1 uppercase font-bold tracking-wider">Menunggu Verifikasi Admin</p>
                            </div>
                        </template>

                        <template x-if="order.status === 'direview' && !order.hasProof">
                            <button @click="cancelOrder()"
                                class="w-full text-xs font-bold tracking-widest text-red-400 uppercase transition-colors hover:text-red-500">
                                Batalkan Pesanan
                            </button>
                        </template>
                    </div>
                </section>
            </div>
        </div>

    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection