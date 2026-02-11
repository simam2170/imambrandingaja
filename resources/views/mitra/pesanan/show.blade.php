@extends('layouts.mitra')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="space-y-8" x-data="{ 
    files: [],
    addFiles(e) {
        const newFiles = Array.from(e.target.files);
        this.files = [...this.files, ...newFiles];
    },
    removeFile(index) {
        this.files = this.files.filter((_, i) => i !== index);
    }
}">
    {{-- BACK BUTTON & STATUS --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('mitra.pesanan', $mitra->id ?? 0) }}" class="p-2 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-primary transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">Dipesan pada {{ is_string($order->created_at) ? $order->created_at : $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <span class="px-4 py-1.5 rounded-full text-xs font-bold border uppercase bg-yellow-50 text-yellow-600 border-yellow-100">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- LEFT COLUMN: ORDER INFO --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- USER & DESCRIPTION --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi User
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-12 h-12 bg-white border border-gray-100 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name ?? 'User') }}&background=random" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $order->user->name ?? 'User' }}</h4>
                            <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-2">Catatan dari User:</h4>
                        <div class="p-4 bg-yellow-50/50 border border-yellow-100 rounded-xl text-sm text-gray-700 leading-relaxed italic">
                            "{{ $order->catatan ?? 'Tidak ada catatan.' }}"
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 border border-gray-100 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Layanan</p>
                            <p class="text-sm font-bold text-gray-800">{{ $order->layanan->nama_layanan ?? 'N/A' }}</p>
                        </div>
                        <div class="p-4 border border-gray-100 rounded-xl">
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Status</p>
                            <p class="text-sm font-bold text-gray-800 capitalize">{{ $order->status }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- UPLOAD AREA (Fitur Utama) --}}
            @if($order->status == 'diproses')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Hasil Pekerjaan
                    </h3>
                    <span class="text-xs text-gray-400 font-medium">Bisa upload gambar, PDF, ZIP, atau link</span>
                </div>
                    {{-- FILE SELECTION --}}
                    <form action="{{ route('mitra.pesanan.complete', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div class="relative group">
                                <input type="file" name="bukti_selesai" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('file-name-display').innerText = this.files[0].name">
                                <div class="p-10 border-2 border-dashed border-gray-200 rounded-2xl flex flex-col items-center justify-center gap-4 group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-bold text-gray-800">Klik untuk pilih bukti pekerjaan selesai</p>
                                        <p id="file-name-display" class="text-sm text-primary font-bold mt-2"></p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Selesaikan Pesanan & Kirim Bukti
                            </button>
                        </div>
                    </form>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-12 text-center">
                    @if($order->status == 'direview')
                        <div class="w-20 h-20 bg-blue-50 text-blue-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Menunggu Review Admin</h3>
                        <p class="text-gray-500 mt-2 max-w-sm mx-auto">Silahkan tunggu admin mereview pesanan. Fitur upload akan tersedia setelah pesanan diproses.</p>
                    @else
                        <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Pekerjaan Selesai</h3>
                        <p class="text-gray-500 mt-2 max-w-sm mx-auto">Pesanan ini telah selesai atau ditolak, sehingga fitur upload tidak lagi tersedia.</p>
                        
                        @if($order->bukti_selesai)
                        <div class="mt-8 p-4 bg-green-50 rounded-xl border border-green-100 inline-block">
                            <p class="text-xs font-bold text-green-600 uppercase mb-2">Bukti Pekerjaan Terkirim</p>
                            <a href="{{ asset('uploads/completion_proofs/' . $order->bukti_selesai) }}" target="_blank" class="flex items-center gap-3 bg-white p-3 rounded-lg border border-green-200 hover:shadow-md transition-all group">
                                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-green-700 transition-colors">Lihat Bukti Pekerjaan</p>
                                    <p class="text-xs text-green-500">Klik untuk melihat file</p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-green-600 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: TIMELINE --}}
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Timeline Progres
                    </h3>
                </div>
                <div class="p-6">
                    <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:h-full before:w-0.5 before:bg-gray-100">
                        @foreach($order->timeline as $item)
                        <div class="relative flex items-start gap-6">
                            <div class="absolute inset-0 flex items-center justify-center w-10">
                                <div class="w-3 h-3 bg-primary rounded-full ring-4 ring-primary/20"></div>
                            </div>
                            <div class="ml-10">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $item['time'] }}</p>
                                <h4 class="font-bold text-gray-800 mt-1">{{ $item['status'] }}</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- HELP CARD --}}
            <div class="bg-primary rounded-2xl p-6 text-white shadow-lg shadow-primary/20 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 opacity-20 transform rotate-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg relative z-10">Butuh Bantuan?</h3>
                <p class="text-sm text-white/80 mt-2 relative z-10 leading-relaxed">Hubungi admin jika Anda mengalami kesulitan dalam pengerjaan atau upload file.</p>
                <a href="#" class="mt-4 inline-block px-6 py-2 bg-white text-primary font-bold text-sm rounded-xl relative z-10 hover:bg-gray-50 transition-colors">
                    Chat Admin
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
