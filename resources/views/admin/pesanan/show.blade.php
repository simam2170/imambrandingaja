@extends('layouts.admin') 

@section('title', 'Admin - Detail Pesanan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.pesanan.index') }}" class="text-blue-500 hover:underline">&larr; Kembali</a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Detail Pesanan #{{ $order->order_number }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail transaksi dan status pembayaran.</p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 rounded-full text-sm font-bold {{ $order->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ strtoupper($order->status) }}
                </span>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Pemesan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->user->name ?? '-' }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $order->user->whatsapp ?? '-' }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Layanan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $order->layanan->nama_layanan ?? '-' }} 
                        <br>
                        <span class="text-xs text-gray-500">Mitra: {{ $order->layanan->mitra->nama_mitra ?? '-' }}</span>
                    </dd>
                </div>
                <!-- Items Loop -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Item Pesanan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <ul class="list-disc pl-5">
                            @foreach($order->items as $item)
                                <li>{{ $item->jenis_layanan }} (x{{ $item->qty }}) - Rp {{ number_format($item->harga, 0, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Tagihan</dt>
                    <dd class="mt-1 text-sm font-bold text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($order->total, 0, ',', '.') }}</dd>
                </div>
                
                <!-- Payment Verification -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-t-4 border-blue-50">
                    <dt class="text-sm font-medium text-gray-500">Bukti Pembayaran</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($order->bukti_pembayaran)
                            <div class="mb-4">
                                <a href="{{ asset('uploads/payments/' . $order->bukti_pembayaran) }}" target="_blank">
                                    <img src="{{ asset('uploads/payments/' . $order->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="max-w-xs h-auto rounded border shadow-sm">
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Klik gambar untuk memperbesar</p>
                            </div>

                            @if($order->status === 'direview')
                                <div class="flex gap-4">
                                    <form action="{{ route('admin.payment.verify', ['id' => $order->id, 'status' => 'diproses']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-bold shadow">
                                            ✔ Terima & Proses
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payment.verify', ['id' => $order->id, 'status' => 'ditolak']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-bold shadow">
                                            ✖ Tolak Pesanan
                                        </button>
                                    </form>
                                </div>
                            @elseif($order->status === 'ditolak')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                    PESANAN DITOLAK
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                    PEMBAYARAN DITERIMA
                                </span>
                            @endif
                        @else
                            <p class="text-yellow-600 italic">Belum ada bukti pembayaran diupload.</p>
                        @endif
                    </dd>
                </div>

                <!-- Step 4: Admin Transfer to Mitra (Payout) -->
                @if($order->status === 'selesai')
                <div class="bg-gray-50 px-4 py-8 sm:px-6 border-t-4 border-green-500">
                    <h4 class="text-md font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Pembayaran ke Mitra (Payout)
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-sm text-gray-600 mb-4">
                                Pekerjaan telah diselesaikan oleh Mitra. Silakan transfer pembayaran ke Mitra dan upload buktinya di sini.
                            </p>
                            @if($order->bukti_transfer_mitra)
                                <div class="p-4 bg-green-100 rounded-lg border border-green-200">
                                    <p class="text-xs font-bold text-green-800">BUKTI TRANSFER TERUPLOAD:</p>
                                    <a href="{{ asset('uploads/payouts/' . $order->bukti_transfer_mitra) }}" target="_blank" class="text-blue-600 hover:underline text-xs block mt-1">
                                        {{ $order->bukti_transfer_mitra }}
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('admin.payout.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <input type="file" name="bukti_transfer_mitra" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    </div>
                                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition-all">
                                        Upload Bukti Transfer Mitra
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <h5 class="text-xs font-bold text-gray-400 uppercase mb-3">Bukti Pekerjaan Mitra:</h5>
                            @if($order->bukti_selesai)
                                <a href="{{ asset('uploads/completion_proofs/' . $order->bukti_selesai) }}" target="_blank">
                                    <img src="{{ asset('uploads/completion_proofs/' . $order->bukti_selesai) }}" alt="Bukti Selesai" class="max-w-full h-auto rounded border">
                                </a>
                            @else
                                <p class="text-xs italic text-gray-400">Tidak ada bukti pengerjaan.</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection
