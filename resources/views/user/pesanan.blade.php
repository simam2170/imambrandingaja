@extends('layouts.user')
@section('title', 'Pesanan')
@section('content')
    <div x-data="{ activeStatus: 'menunggu_pembayaran' }" class="mx-auto space-y-6 max-w-7xl">

        {{-- HEADER --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Pesanan</h1>
            <p class="mt-2 text-gray-500">Pantau status pengerjaan branding Anda.</p>
        </div>

        {{-- TABS --}}
        <div class="border-b border-gray-200">

            <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                @foreach (['menunggu_pembayaran' => 'Belum Bayar', 'direview' => 'Direview', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak', 'dibatalkan' => 'Dibatalkan'] as $key => $label)
                    <button @click="activeStatus = '{{ $key }}'"
                        :class="activeStatus === '{{ $key }}' 
                                                                                    ? 'border-primary text-primary' 
                                                                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="relative px-1 py-4 text-sm font-medium transition-colors border-b-2 whitespace-nowrap">
                        {{ $label }}

                        {{-- Active Indicator Dot (Optional) --}}
                        <span x-show="activeStatus === '{{ $key }}'" class="absolute flex w-2 h-2 -top-1 -right-2">
                            <span
                                class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-75 animate-ping"></span>
                            <span class="relative inline-flex w-2 h-2 rounded-full bg-primary"></span>
                        </span>
                    </button>
                @endforeach
            </nav>
        </div>

        {{-- CONTENT --}}
        <div class="space-y-6">

            {{-- SEARCH & FILTER --}}
            <div class="flex flex-col gap-4 md:flex-row">
                <div class="relative flex-1">
                    <input type="text" placeholder="Cari pesanan..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                    <svg class="absolute w-5 h-5 text-gray-400 left-3 top-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="flex gap-2">
                    <select
                        class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 focus:ring-2 focus:ring-primary/20 focus:border-primary cursor-pointer outline-none">
                        <option>Urutkan Terbaru</option>
                        <option>Urutkan Terlama</option>
                        <option>Harga Tertinggi</option>
                        <option>Harga Terendah</option>
                    </select>
                </div>
            </div>

            {{-- LIST CONTAINER --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 min-h-[400px]">

                {{-- STATUS HEADER (Dynamic based on Tab) --}}
                <div class="mb-6">
                    <span class="px-6 py-2 text-sm font-bold text-white capitalize rounded-full shadow-sm" :class="{
                                                          'bg-gray-500': activeStatus === 'menunggu_pembayaran',
                                                          'bg-yellow-500': activeStatus === 'direview',
                                                          'bg-primary': activeStatus === 'diproses',
                                                          'bg-green-500': activeStatus === 'selesai',
                                                          'bg-red-500': activeStatus === 'ditolak' || activeStatus === 'dibatalkan'
                                                      }"
                        x-text="activeStatus === 'menunggu_pembayaran' ? 'Menunggu Pembayaran' : (activeStatus === 'direview' ? 'Menunggu Review Admin' : activeStatus)">
                    </span>
                </div>

                <div class="max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">

                    @foreach (['menunggu_pembayaran', 'direview', 'diproses', 'selesai', 'ditolak', 'dibatalkan'] as $status)
                        <div x-show="activeStatus === '{{ $status }}'" class="space-y-4" @if($status !== 'menunggu_pembayaran')
                        style="display: none;" @endif>
                            @forelse($orders->get($status, []) as $order)
                                <div
                                    class="relative flex items-center gap-6 p-6 overflow-hidden transition-all bg-white border border-gray-100 shadow-sm cursor-pointer group rounded-xl hover:shadow-md hover:border-primary/50">
                                    <div class="flex flex-col gap-4 sm:flex-row w-full">
                                        <div
                                            class="w-24 h-24 overflow-hidden bg-gray-100 rounded-lg shrink-0 flex items-center justify-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order->layanan->nama_layanan ?? 'Service') }}&background=f3f4f6&color=666"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex flex-col justify-between flex-1">
                                            <div>
                                                <h3 class="text-base font-bold text-gray-800">
                                                    {{ $order->layanan->nama_layanan ?? 'Layanan Tidak Diketahui' }}
                                                    <span class="text-sm font-normal text-gray-600 block sm:inline sm:ml-2">
                                                        @if($order->isExpired() && !$order->bukti_pembayaran)
                                                            <span class="text-red-500 font-bold">Waktu Pembayaran Habis (Hangus)</span>
                                                        @elseif($order->status === 'menunggu_pembayaran') Menunggu pembayaran Anda.
                                                        @elseif($order->status === 'direview') Menunggu konfirmasi admin.
                                                        @elseif($order->status === 'diproses') Sedang dikerjakan oleh mitra.
                                                        @elseif($order->status === 'selesai') Pesanan telah selesai.
                                                        @elseif($order->status === 'ditolak') Pesanan ditolak oleh admin.
                                                        @elseif($order->status === 'dibatalkan') Pesanan dibatalkan.
                                                        @endif
                                                    </span>
                                                </h3>
                                                <span class="mt-2 text-sm text-gray-500"> Jumlah :
                                                    {{ $order->jumlah }} x Rp
                                                    {{ number_format($order->layanan->harga, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <div class="flex flex-col justify-between gap-4 mt-3 sm:flex-row sm:items-end">
                                                <div class="text-sm text-gray-500">No. Pesanan : <span
                                                        class="font-bold text-gray-700">#{{ $order->order_number }}</span></div>
                                                <div class="flex items-center gap-4">
                                                    <div class="text-right">
                                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Total Pembayaran
                                                        </p>
                                                        <div class="text-lg font-bold text-primary">Rp
                                                            {{ number_format($order->jumlah * $order->layanan->harga, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('user.invoice', $order->id) }}"
                                                        class="px-4 py-2 bg-gray-50 text-gray-700 text-xs font-bold rounded-lg border border-gray-200 hover:bg-primary hover:text-white hover:border-primary transition-all">Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="flex flex-col items-center justify-center p-12 text-center bg-white/50 rounded-xl border border-dashed border-yellow-300">
                                    <div
                                        class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 text-yellow-400 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada pesanan dengan status "{{ ucfirst($status) }}"
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection