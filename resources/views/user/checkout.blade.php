@extends('layouts.user')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto space-y-8" x-data="{
    items: JSON.parse(localStorage.getItem('checkoutItems') || '[]'),
    user: {
        name: '{{ $user->name ?? '' }}',
        email: '{{ $user->email ?? '' }}',
        whatsapp: '{{ $user->whatsapp ?? '' }}',
        note: ''
    },
    paymentMethods: [
        { id: 'bca', name: 'BCA', desc: 'Transfer ke Rekening BCA', active: true, logo: '🏦', type: 'bank', category: 'Transfer Bank' },
        { id: 'mandiri', name: 'Mandiri', desc: 'Transfer ke Rekening Mandiri', active: true, logo: '🏦', type: 'bank', category: 'Transfer Bank' },
        { id: 'qris', name: 'QRIS', desc: 'Scan QR Code (OVO, Dana, etc)', active: true, logo: '🔳', type: 'ewallet', category: 'E-Wallet & QRIS' },
        { id: 'dana', name: 'DANA', desc: 'Transfer ke DANA', active: true, logo: '📱', type: 'ewallet', category: 'E-Wallet & QRIS' }
    ],
    get groupedMethods() {
        const groups = {};
        this.paymentMethods.forEach(m => {
            if (!groups[m.category]) groups[m.category] = [];
            groups[m.category].push(m);
        });
        return Object.keys(groups).map(name => ({ name, methods: groups[name] }));
    },
    selectedPayment: null,
    get totalPrice() {
        return this.items.reduce((sum, item) => sum + (item.price * item.qty), 0);
    },
    formatPrice(value) {
        return 'Rp' + value.toLocaleString('id-ID');
    },
    validate() {
        if (!this.user.whatsapp) return alert('Silakan isi nomor WhatsApp Anda.');
        if (!this.selectedPayment) return alert('Silakan pilih metode pembayaran.');
        this.submit();
    },
    async submit() {
        try {
            const response = await fetch('{{ route('user.checkout.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    items: this.items,
                    user: this.user,
                    payment: this.selectedPayment
                })
            });

            const contentType = response.headers.get('content-type');
            let message = 'Unknown error';
            
            if (contentType && contentType.includes('application/json')) {
                const result = await response.json();
                message = result.message || message;
                
                if (response.ok) {
                    localStorage.removeItem('checkoutItems');
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        alert('Pesanan berhasil dibuat!');
                        window.location.href = '{{ route('user.dashboard') }}';
                    }
                    return;
                }
            } else {
                message = 'Server Error (' + response.status + ')';
            }
            
            alert('Gagal membuat pesanan: ' + message);
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses pesanan: ' + (error.message || 'Harap cek koneksi atau hubungi admin.'));
        }
    }
}">
    
    {{-- HEADER --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('user.keranjang') }}" class="p-2 hover:bg-gray-200 rounded-full transition-colors text-gray-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LEFT SIDE: INFO & PAYMENT --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- A. INFORMASI PEMESAN --}}
            <section class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm">1</span>
                    Informasi Pemesan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" x-model="user.name" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Email</label>
                        <input type="email" x-model="user.email" readonly class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">No WhatsApp *</label>
                        <input type="text" x-model="user.whatsapp" placeholder="08123456789" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan Pesanan (Opsional)</label>
                        <input type="text" x-model="user.note" placeholder="Contoh: Tolong kerjakan secepatnya" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none transition-all">
                    </div>
                </div>
            </section>

            {{-- C. METODE PEMBAYARAN --}}
            <section class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm">2</span>
                    Pilih Metode Pembayaran
                </h3>
                
                <div class="space-y-8">
                    <template x-for="group in groupedMethods" :key="group.name">
                        <div class="space-y-4">
                            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <span x-text="group.name"></span>
                                <div class="h-px bg-gray-100 flex-1"></div>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <template x-for="method in group.methods" :key="method.id">
                                    <div 
                                        @click="method.active ? selectedPayment = method : null"
                                        class="relative p-4 border-2 rounded-2xl cursor-pointer transition-all flex items-center gap-4 group"
                                        :class="{
                                            'border-yellow-400 bg-yellow-50': selectedPayment?.id === method.id,
                                            'border-gray-50 hover:border-gray-200 bg-white': selectedPayment?.id !== method.id && method.active,
                                            'opacity-50 grayscale cursor-not-allowed bg-gray-50 border-gray-200': !method.active
                                        }"
                                    >
                                        <div class="text-2xl" x-text="method.logo"></div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800 text-sm" x-text="method.name"></h4>
                                            <p class="text-[10px] text-gray-500" x-text="method.desc"></p>
                                        </div>
                                        <div x-show="!method.active" class="absolute top-2 right-2 px-2 py-0.5 bg-gray-200 text-[10px] font-bold text-gray-600 rounded uppercase">Nonaktif</div>
                                        <div x-show="selectedPayment?.id === method.id" class="text-yellow-500">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

        </div>

        {{-- RIGHT SIDE: SUMMARY --}}
        <div class="space-y-6">
            
            {{-- B. RINGKASAN PESANAN --}}
            <section class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-24">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Ringkasan Pesanan</h3>
                
                <div class="space-y-4 mb-6 max-h-[40vh] overflow-y-auto pr-2 custom-scrollbar">
                    <template x-for="item in items" :key="item.id">
                        <div class="flex gap-4 items-start py-3 border-b border-gray-50 last:border-0">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-800 text-xs truncate" x-text="item.name"></h4>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-[10px] text-gray-500" x-text="item.qty + ' x ' + formatPrice(item.price)"></span>
                                    <span class="text-xs font-bold text-gray-800" x-text="formatPrice(item.price * item.qty)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="space-y-3 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-bold text-gray-800" x-text="formatPrice(totalPrice)"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Biaya Layanan</span>
                        <span class="font-bold text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between text-lg pt-3 border-t border-gray-100">
                        <span class="font-bold text-gray-800">Total</span>
                        <span class="font-extrabold text-yellow-600" x-text="formatPrice(totalPrice)"></span>
                    </div>
                </div>
                <button 
                    @click="validate()"
                    class="w-full mt-8 py-3 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-xl shadow-lg shadow-yellow-100 transition-all transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2"
                >
                    Bayar Sekarang
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>

                <p class="text-[10px] text-gray-400 text-center mt-4">
                    Dengan mengeklik tombol, Anda menyetujui Ketentuan Layanan kami.
                </p>
            </section>

        </div>

    </div>

</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
</style>
@endsection
