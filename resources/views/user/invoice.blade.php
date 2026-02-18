@extends('layouts.user')
@section('title', 'Invoice')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8" x-data="{
                                order: {{ Js::from($order) }},
                                showUpload: false,
                                proofFile: null,
                                proofPreview: null,
                                uploadStatus: '', // '', 'uploading', 'success'
                                timeLeft: '01:00:00',
                                paymentMethods: [
                                    { id: 'bca', name: 'BCA', desc: 'Transfer ke Rekening BCA', active: true, logo: '🏦', type: 'bank', category: 'Transfer Bank' },
                                    { id: 'mandiri', name: 'Mandiri', desc: 'Transfer ke Rekening Mandiri', active: true, logo: '🏦', type: 'bank', category: 'Transfer Bank' },
                                    { id: 'qris', name: 'QRIS', desc: 'Scan QR Code (OVO, Dana, etc)', active: true, logo: '🔳', type: 'ewallet', category: 'E-Wallet & QRIS' },
                                    { id: 'dana', name: 'DANA', desc: 'Transfer ke DANA', active: true, logo: '📱', type: 'ewallet', category: 'E-Wallet & QRIS' }
                                ],

                                init() {
                                    if (['menunggu_pembayaran', 'direview'].includes(this.order.status) && !this.order.bukti_pembayaran) {
                                        this.startTimer();
                                    }
                                },

                                startTimer() {
                                    const deadline = new Date(this.order.expired_at).getTime();

                                    const update = () => {
                                        const now = new Date().getTime();
                                        const diff = deadline - now;

                                        if (diff <= 0) {
                                            this.timeLeft = '00:00:00';
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

                                formatPrice(value) {
                                    return value ? 'Rp' + Number(value).toLocaleString('id-ID') : 'Rp0';
                                },

                                get hasProof() {
                                    return !!this.order.bukti_pembayaran;
                                },

                                handleFileUpload(event) {
                                    const file = event.target.files[0];
                                    if (!file) return;

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
                                        this.proofPreview = 'pdf-icon'; 
                                    }
                                },

                                async submitProof() {
                                    if (!this.proofFile) return alert('Pilih file terlebih dahulu.');
                                    this.uploadStatus = 'uploading';

                                    const formData = new FormData();
                                    formData.append('bukti_pembayaran', this.proofFile);
                                    formData.append('_token', '{{ csrf_token() }}');

                                    try {
                                        const response = await fetch('{{ route('user.payment.upload', $order->id) }}', {
                                            method: 'POST',
                                            body: formData
                                        });

                                        if (response.ok) {
                                            this.uploadStatus = 'success';
                                            this.showUpload = false;
                                            setTimeout(() => {
                                                window.location.reload(); 
                                            }, 1000);
                                        } else {
                                            const res = await response.json();
                                            alert('Gagal mengupload: ' + (res.message || 'Unknown error'));
                                            this.uploadStatus = '';
                                        }
                                    } catch (e) {
                                        console.error(e);
                                        alert('Terjadi kesalahan.');
                                        this.uploadStatus = '';
                                    }
                                },

                                async cancelOrder() {
                                    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                                        try {
                                            const response = await fetch('{{ route('user.order.cancel', $order->id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                }
                                            });
                                            if (response.ok) {
                                                window.location.reload();
                                            } else {
                                                alert('Gagal membatalkan pesanan.');
                                            }
                                        } catch (e) {
                                            alert('Terjadi kesalahan.');
                                        }
                                    }
                                }
                            }">

        {{-- SIMPLIFIED VIEW FOR UPLOADED PROOF (Only if status is still waiting payment) --}}
        <template x-if="hasProof && order.status === 'menunggu_pembayaran'">
            <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
                <div class="w-full max-w-2xl p-12 bg-white border border-primary-100 shadow-xl rounded-3xl">
                    <div class="w-20 h-20 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-primary-600 mb-4">Pembayaran Sedang Diverifikasi</h2>
                    <p class="text-gray-500 text-lg leading-relaxed">
                        Terima kasih! Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi oleh admin.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('user.pesanan') }}"
                            class="inline-flex items-center justify-center px-8 py-3 text-sm font-bold text-white transition-all bg-primary-600 rounded-xl hover:bg-primary-700 shadow-lg shadow-primary-200">
                            Lihat Pesanan Saya
                        </a>
                    </div>
                </div>
            </div>
        </template>

        {{-- NORMAL VIEW --}}
        <template x-if="!hasProof || order.status !== 'menunggu_pembayaran'">
            <div>
                {{-- STATUS HEADER --}}
                <div class="p-8 mb-8 bg-white border border-gray-100 shadow-sm rounded-3xl text-center"
                    x-show="(order.status === 'menunggu_pembayaran' && !hasProof) || order.status === 'dibatalkan'">
                    <template x-if="!hasProof && order.status !== 'dibatalkan'">
                        <h2 class="text-2xl font-black text-gray-800">Menunggu Pembayaran</h2>
                    </template>

                    <div class="pt-4 space-y-4 border-t border-accent-200"
                        x-show="!hasProof && order.status !== 'dibatalkan'">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Batas Waktu Pembayaran</p>
                        <p class="font-mono text-2xl font-black text-red-600" x-text="timeLeft"></p>
                        <p class="text-[10px] text-red-600 font-bold leading-relaxed">
                            Pesanan Anda akan diproses jika sudah upload bukti pembayaran.
                        </p>
                    </div>

                    <template x-if="order.status === 'dibatalkan'">
                        <div class="pt-4 text-center">
                            <p class="text-xl font-black text-red-600">PESANAN DIBATALKAN</p>
                            <p class="text-sm text-gray-500">Pesanan ini telah dibatalkan.</p>
                        </div>
                    </template>
                </div>

                <div class="p-8 mb-8 bg-white border border-gray-100 shadow-sm rounded-3xl text-center">
                    <template
                        x-if="order.status === 'direview' || order.status === 'diproses' || order.status === 'selesai' || order.status === 'ditolak' || order.status === 'dibatalkan'">
                        <h2 class="text-2xl font-black text-gray-800">Detail dan Status Pesanan Saya</h2>
                    </template>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    {{-- LEFT: ORDER INFO --}}
                    <div class="space-y-6 md:col-span-2">
                        <section class="p-6 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-3xl">
                            <div class="flex items-start justify-between mb-6">
                                <h3 class="flex items-center gap-2 font-bold text-gray-800">
                                    <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Detail Pesanan
                                </h3>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order ID</p>
                                    <p class="font-bold text-gray-800" x-text="order.order_number"></p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <template x-for="item in order.items" :key="item.id">
                                    <div
                                        class="flex items-center gap-4 p-4 border bg-gray-50/50 rounded-2xl border-gray-50">
                                        <div class="w-16 h-16 bg-gray-200 rounded-xl shrink-0"></div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="mb-1 text-sm font-bold text-gray-800 truncate"
                                                x-text="item.layanan?.nama_layanan || 'Layanan'"></h4>
                                            <div class="flex items-center justify-between text-xs text-gray-500">
                                                <span x-text="order.mitra?.nama_mitra || 'Mitra'"></span>
                                                <span class="font-bold text-accent-600"
                                                    x-text="item.qty + ' x ' + formatPrice(item.harga)"></span>
                                            </div>
                                            <p class="text-[10px] text-gray-400" x-text="item.jenis_layanan"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex items-center justify-between pt-6 mt-8 border-t border-gray-200 border-dashed">
                                <span class="text-xs font-bold tracking-widest text-gray-500 uppercase">Total
                                    Pembayaran</span>
                                <span class="text-2xl font-black text-gray-800" x-text="formatPrice(order.total)"></span>
                            </div>
                        </section>

                        <section class="p-6 bg-white border border-gray-100 shadow-sm rounded-3xl">
                            <h3 class="flex items-center gap-2 mb-6 font-bold text-gray-800">
                                <svg class="w-5 h-5 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Informasi Pemesan
                            </h3>
                            <div class="grid grid-cols-2 text-sm gap-y-4">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nama</p>
                                    <p class="font-bold text-gray-800">{{ $user->name ?? $order->user->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">WhatsApp</p>
                                    <p class="font-bold text-gray-800">
                                        {{ $user->whatsapp ?? $order->user->whatsapp ?? '-' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Catatan</p>
                                    <p class="italic text-gray-600">{{ $order->catatan ?? '-' }}</p>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- RIGHT: PAYMENT INSTRUCTIONS & STATUS CARDS --}}
                    <div class="space-y-6">

                        {{-- WAITING FOR PAYMENT --}}
                        <template x-if="order.status === 'menunggu_pembayaran'">
                            <section class="p-6 border border-accent-100 shadow-sm bg-accent-50 rounded-3xl">
                                <h3 class="flex items-center gap-2 mb-4 font-bold text-accent-800">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Instruksi Pembayaran
                                </h3>
                                <div class="space-y-4">
                                    <template x-if="['bca', 'mandiri'].includes(order.metode_pembayaran)">
                                        <div class="p-4 bg-white border border-accent-200 rounded-2xl">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1"
                                                x-text="order.metode_pembayaran"></p>
                                            <p class="mb-1 text-sm font-black text-gray-800"
                                                x-text="'Bank ' + order.metode_pembayaran.toUpperCase()"></p>
                                            <div
                                                class="flex items-center justify-between px-2 py-1 font-mono text-lg font-bold text-accent-600 rounded-lg bg-accent-50">
                                                <span
                                                    x-text="order.metode_pembayaran === 'bca' ? '123 456 7890' : '987 654 3210'"></span>
                                                <button @click="alert('Copied!')"
                                                    class="text-[10px] font-bold text-primary-500 uppercase">Copy</button>
                                            </div>
                                            <p class="text-[10px] text-gray-400 mt-2">a.n PT Branding Aja Indonesia</p>
                                        </div>
                                    </template>

                                    <template x-if="['qris', 'dana'].includes(order.metode_pembayaran)">
                                        <div class="p-4 bg-white border border-accent-200 rounded-2xl text-center">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-3 text-left"
                                                x-text="order.metode_pembayaran"></p>
                                            <div
                                                class="w-32 h-32 bg-gray-100 rounded-xl mx-auto mb-3 flex items-center justify-center border-2 border-dashed border-gray-200">
                                                <span class="text-3xl">🔳</span>
                                            </div>
                                            <p class="text-xs font-bold text-gray-800 mb-1">Pindai QRIS / DANA</p>
                                            <p class="text-[10px] text-gray-500 leading-relaxed">Silakan pindai kode QR di
                                                atas menggunakan aplikasi e-wallet Anda.</p>
                                        </div>
                                    </template>

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
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                <p class="text-[10px] font-bold text-gray-400 uppercase">
                                                                    Pilih File</p>
                                                            </div>
                                                        </template>
                                                        <template x-if="proofPreview === 'pdf-icon'">
                                                            <div class="text-center">
                                                                <svg class="w-10 h-10 mx-auto text-red-400"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd"
                                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <p class="mt-2 text-[10px] font-bold text-gray-500 truncate px-4"
                                                                    x-text="proofFile.name"></p>
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
                                                    class="flex items-center justify-center w-full gap-2 py-3 font-bold text-gray-900 transition-all bg-accent-400 shadow-lg hover:bg-accent-500 rounded-2xl shadow-accent-100"
                                                    :disabled="uploadStatus === 'uploading'">
                                                    <span x-show="uploadStatus !== 'uploading'">Kirim Bukti</span>
                                                    <span x-show="uploadStatus === 'uploading'"
                                                        class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-900 animate-spin"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                stroke="currentColor" stroke-width="4"></circle>
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

                                    <template x-if="!hasProof">
                                        <button @click="cancelOrder()"
                                            class="w-full text-xs font-bold tracking-widest text-red-400 uppercase transition-colors hover:text-red-500">
                                            Batalkan Pesanan
                                        </button>
                                    </template>
                                </div>
                            </section>
                        </template>

                        {{-- DIREVIEW --}}
                        <template x-if="order.status === 'direview'">
                            <section class="p-6 border border-primary-100 shadow-sm bg-primary-50 rounded-3xl text-center">
                                <div
                                    class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 font-bold text-primary-800">Pesanan Sedang Direview</h3>
                                <p class="text-xs text-primary-600">Admin sedang memverifikasi bukti pembayaran Anda.</p>
                            </section>
                        </template>

                        {{-- DIPROSES --}}
                        <template x-if="order.status === 'diproses'">
                            <section class="p-6 border border-purple-100 shadow-sm bg-purple-50 rounded-3xl text-center">
                                <div
                                    class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 font-bold text-purple-800">Pesanan Sedang Diproses</h3>
                                <p class="text-xs text-purple-600">Pesanan Anda sedang dikerjakan oleh mitra kami.</p>
                            </section>
                        </template>

                        {{-- SELESAI --}}
                        <template x-if="order.status === 'selesai'">
                            <section class="p-6 border border-green-100 shadow-sm bg-green-50 rounded-3xl text-center">
                                <div
                                    class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 font-bold text-green-800">Pesanan Selesai</h3>
                                <p class="text-xs text-green-600">Terima kasih telah menggunakan layanan kami.</p>
                            </section>
                        </template>

                        {{-- REJECTED/CANCELLED --}}
                        <template x-if="['ditolak', 'dibatalkan'].includes(order.status)">
                            <section class="p-6 border border-red-100 shadow-sm bg-red-50 rounded-3xl text-center">
                                <div
                                    class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 font-bold text-red-800"
                                    x-text="'Pesanan ' + (order.status === 'ditolak' ? 'Ditolak' : 'Dibatalkan')"></h3>
                                <p class="text-xs text-red-600">Pesanan ini tidak dapat dilanjutkan.</p>
                            </section>
                        </template>
                    </div>
                </div>
            </div>
        </template>

    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
