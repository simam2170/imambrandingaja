@extends('layouts.mitra')

@section('title', 'Daftar Pesanan')

@section('content')
    <div x-data="{ activeStatus: 'semua' }" class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
                <p class="text-gray-500 mt-1">Daftar pesanan yang perlu Anda kerjakan atau tinjau.</p>
            </div>

            {{-- FILTERS --}}
            <div class="flex items-center gap-2 bg-white p-1 rounded-xl shadow-sm border border-gray-100 overflow-x-auto">
                <button @click="activeStatus = 'semua'"
                    :class="activeStatus === 'semua' ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all">Semua</button>
                <button @click="activeStatus = 'direview'"
                    :class="activeStatus === 'direview' ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all">Direview</button>
                <button @click="activeStatus = 'diproses'"
                    :class="activeStatus === 'diproses' ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all">Diproses</button>
                <button @click="activeStatus = 'selesai'"
                    :class="activeStatus === 'selesai' ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all">Selesai</button>
                <button @click="activeStatus = 'ditolak'"
                    :class="activeStatus === 'ditolak' ? 'bg-primary text-white' : 'text-gray-500 hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all">Ditolak</button>
            </div>
        </div>

        {{-- ORDER TABLE / LIST --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Layanan</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pesan/Jumlah</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $order)
                            <tr x-show="activeStatus === 'semua' || activeStatus === '{{ $order->status }}'"
                                class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-800">#{{ $order->order_number }}</span>
                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                        {{ is_string($order->created_at) ? $order->created_at : $order->created_at->format('d M Y') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('user.layanan.show', $order->layanan->id ?? 0) }}"
                                            class="w-12 h-12 overflow-hidden bg-gray-100 rounded-lg shrink-0 flex items-center justify-center hover:opacity-80 transition-opacity">
                                            @if($order->layanan && $order->layanan->thumbnail)
                                                <img src="{{ $order->layanan->thumbnail }}" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order->layanan->nama_layanan ?? 'Service') }}&background=f3f4f6&color=666"
                                                    class="w-full h-full object-cover">
                                            @endif
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-800">
                                                <a href="{{ route('user.layanan.show', $order->layanan->id ?? 0) }}"
                                                    class="hover:text-primary transition-colors">
                                                    {{ $order->layanan->nama_layanan ?? 'N/A' }}
                                                </a>
                                            </h4>
                                            <p class="text-xs text-gray-500 truncate max-w-xs mt-0.5">
                                                {{ Str::limit($order->catatan ?? '', 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center text-xs">
                                            <span
                                                class="px-2 py-0.5 bg-gray-100 text-gray-600 font-bold rounded-full mr-2">{{ $item->jenis_layanan ?? 'Standard' }}</span>
                                            <span class="text-gray-700">x{{ $item->qty }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'direview' => 'bg-primary-50 text-primary-600 border-primary-100',
                                            'diproses' => 'bg-accent-50 text-accent-600 border-accent-100',
                                            'selesai' => 'bg-green-50 text-green-600 border-green-100',
                                            'ditolak' => 'bg-red-50 text-red-600 border-red-100',
                                        ];
                                        $class = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-500 border-gray-100';
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border uppercase {{ $class }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('mitra.pesanan.show', $order->id) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:border-primary hover:text-primary transition-all">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection