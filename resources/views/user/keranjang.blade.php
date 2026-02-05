@extends('layouts.user')
@section('title', 'Keranjang')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{
    items: [],
    init() {
        this.items = JSON.parse(localStorage.getItem('cartItems') || '[]');
        this.$watch('items', (val) => {
            localStorage.setItem('cartItems', JSON.stringify(val));
        }, { deep: true });
    },
    get allChecked() {
        return this.items.length > 0 && this.items.every(i => i.checked);
    },
    set allChecked(value) {
        this.items.forEach(i => i.checked = value);
    },
    get selectedCount() {
        return this.items.filter(i => i.checked).length;
    },
    get totalPrice() {
        return this.items.filter(i => i.checked).reduce((sum, item) => sum + (item.price * item.qty), 0);
    },
    formatPrice(value) {
        return 'Rp' + value.toLocaleString('id-ID');
    },
    decreaseQty(item) {
        if (item.qty > 1) item.qty--;
    },
    removeItem(id) {
        this.items = this.items.filter(i => i.id !== id);
    }
}">
    
    {{-- HEADER --}}
    <div>
        <span class="inline-block px-6 py-2 text-white font-bold bg-yellow-500 rounded-full shadow-sm">
            Keranjang
        </span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        {{-- LEFT: CART ITEMS --}}
        <div class="flex-1 space-y-6">
            
            {{-- SELECT ALL --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-center gap-3">
                <input type="checkbox" x-model="allChecked" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary">
                <label class="font-bold text-gray-800 text-sm">Pilih semua <span class="text-gray-500 font-normal" x-text="'(' + items.length + ')'"></span></label>
            </div>

            {{-- CART LIST --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 space-y-8">
                
                {{-- ITEM LOOP --}}
                <template x-for="(item, index) in items" :key="item.id">
                    <div>
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 text-primary font-bold text-sm">
                                <input type="checkbox" x-model="item.checked" class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary">
                                <span x-text="item.seller"></span>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row gap-4">
                                {{-- IMAGE --}}
                                <div class="w-full sm:w-24 h-24 bg-gray-400 rounded shrink-0"></div>
                                
                                {{-- DETAILS --}}
                                <div class="flex-1">
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <h3 class="font-bold text-gray-800 text-sm leading-snug" x-text="item.name"></h3>
                                            <p class="text-gray-500 text-xs mt-1" x-text="'Views ' + item.views"></p>
                                        </div>
                                        <span class="text-yellow-500 font-bold text-sm whitespace-nowrap" x-text="formatPrice(item.price * item.qty)"></span>
                                    </div>
                                    
                                    {{-- ACTION --}}
                                    <div class="flex justify-end items-center gap-4 mt-4">
                                        <button @click="removeItem(item.id)" class="text-gray-600 hover:text-red-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                        
                                        <div class="flex items-center bg-gray-300 rounded overflow-hidden">
                                            <button @click="decreaseQty(item)" class="px-3 py-1 text-gray-600 hover:bg-gray-400 text-xs font-bold transition-colors">-</button>
                                            <input type="text" x-model="item.qty" class="w-8 py-1 text-center bg-transparent border-none text-xs font-bold text-gray-700 p-0 focus:ring-0" readonly>
                                            <button @click="item.qty++" class="px-3 py-1 text-gray-600 hover:bg-gray-400 text-xs font-bold transition-colors">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-yellow-200 mt-6 pt-6" x-show="index !== items.length - 1"></div>
                    </div>
                </template>
                
                {{-- EMPTY CART MESSAGE (OPTIONAL) --}}
                <div x-show="items.length === 0" class="text-center py-8 text-gray-500">
                    Keranjang kosong
                </div>

            </div>
        </div>

        {{-- RIGHT: SUMMARY --}}
        <div class="w-full lg:w-96 bg-yellow-50/50 border border-yellow-100 rounded-xl p-6 h-fit backdrop-blur-sm sticky top-24 transition-all duration-300">
            <h3 class="font-bold text-gray-900 text-center mb-6">Ringkasan belanja</h3>
            
            <div class="flex items-end justify-between border-t border-gray-300 pt-4 mb-8">
                <span class="text-sm text-gray-600">Total :</span>
                <span class="font-bold text-gray-900" x-text="formatPrice(totalPrice)"></span>
            </div>

            <button class="w-full py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold rounded-full shadow-lg shadow-yellow-200 transition-all transform hover:scale-105"
                :disabled="selectedCount === 0"
                :class="{'opacity-50 cursor-not-allowed transform-none shadow-none': selectedCount === 0}"
                @click="
                    localStorage.setItem('checkoutItems', JSON.stringify(items.filter(i => i.checked)));
                    window.location.href = '{{ route('user.checkout') }}';
                ">
                <span x-text="'BELI (' + selectedCount + ')'"></span>
            </button>
        </div>

    </div>

</div>
@endsection
