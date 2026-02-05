@extends('layouts.mitra')

@section('title', 'Profil Mitra')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Profil & Pengaturan</h1>
        <p class="text-gray-500 mt-1">Kelola identitas brand dan informasi pembayaran Anda.</p>
    </div>

    <form action="{{ route('mitra.profil.update') }}" method="POST" class="space-y-8">
        @csrf
        {{-- CARD 1: IDENTITY --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Identitas Mitra</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex items-center gap-6 pb-6 border-b border-gray-50">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mitra->nama_mitra) }}&background=60a5fa&color=fff&size=128" class="w-full h-full object-cover">
                        </div>
                        <button type="button" class="absolute -bottom-2 -right-2 p-2 bg-primary text-white rounded-xl shadow-lg hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $mitra->nama_mitra }}</h4>
                        <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider font-bold">Status: 
                            <span class="text-green-500">{{ $mitra->status_verifikasi }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Nama Brand / Jasa</label>
                        <input type="text" name="nama_mitra" value="{{ $mitra->nama_mitra }}" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Email Utama</label>
                        <input type="email" name="email" value="{{ $mitra->email }}" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-gray-700">Deskripsi Layanan</label>
                        <textarea name="deskripsi" rows="4" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">{{ $mitra->deskripsi }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Kota</label>
                        <input type="text" name="kota" value="{{ $mitra->kota }}" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Provinsi</label>
                        <input type="text" name="provinsi" value="{{ $mitra->provinsi }}" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 2: REKENING --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Informasi Pencairan (Rekening)</h3>
            </div>
            <div class="p-6">
                <div class="p-4 bg-primary/5 rounded-2xl flex items-start gap-4 mb-6 border border-primary/10">
                    <div class="p-2 bg-primary/10 text-primary rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">Pastikan data rekening benar. Admin akan menggunakan informasi ini untuk mentransfer setiap pendapatan yang masuk dari pesanan yang telah diselesaikan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Nama Bank / E-Wallet</label>
                        <input type="text" name="nama_bank" value="{{ $mitra->nama_bank }}" placeholder="Contoh: BCA / Mandiri / GoPay" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700">Nomor Rekening / Akun</label>
                        <input type="text" name="nomor_rekening" value="{{ $mitra->nomor_rekening }}" placeholder="0000 0000 0000" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-gray-700">Nama Pemilik Rekening</label>
                        <input type="text" name="nama_pemilik_rekening" value="{{ $mitra->nama_pemilik_rekening }}" placeholder="Sesuai buku tabungan" class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4">
             <button type="button" class="px-8 py-3 bg-white border border-gray-200 text-gray-500 font-bold rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
             <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 hover:-translate-y-0.5 transition-all">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
