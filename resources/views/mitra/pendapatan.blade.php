@extends('layouts.mitra')

@section('title', 'Pendapatan Mitra')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pendapatan saya</h1>
            <p class="text-gray-500 mt-1">Pantau penghasilan dan riwayat penarikan dana Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('mitra.pendapatan') }}" method="GET" class="flex items-center gap-2">
                <div class="p-1 bg-white border border-gray-100 rounded-xl shadow-sm flex items-center gap-1">
                    <a href="{{ route('mitra.pendapatan') }}" 
                       class="px-4 py-1.5 {{ !request('month') ? 'bg-primary text-white' : 'text-gray-400 hover:bg-gray-50' }} text-xs font-bold rounded-lg shadow-sm transition-all">
                        Semua
                    </a>
                    <select name="month" onchange="this.form.submit()" 
                            class="px-4 py-1.5 bg-transparent text-gray-600 text-xs font-bold rounded-lg focus:outline-none cursor-pointer border-r border-gray-100">
                        <option value="">Bulan</option>
                        @for($m=1; $m<=12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" onchange="this.form.submit()" 
                            class="px-4 py-1.5 bg-transparent text-gray-600 text-xs font-bold rounded-lg focus:outline-none cursor-pointer">
                        @php $currentYear = date('Y'); @endphp
                        @for($y=$currentYear; $y>=$currentYear-2; $y--)
                            <option value="{{ $y }}" {{ request('year', $currentYear) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- HIGHLIGHT STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-110 transition-transform"></div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-3xl font-black text-gray-800 mt-2">Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}</h3>
            <p class="text-xs text-green-500 font-bold mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                +12% dari bulan lalu
            </p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-400/5 rounded-full group-hover:scale-110 transition-transform"></div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Tertahan</p>
            <h3 class="text-3xl font-black text-gray-800 mt-2">Rp {{ number_format($data->saldo_tertahan, 0, ',', '.') }}</h3>
            <div class="mt-2 flex items-center gap-2">
                 <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></span>
                 <p class="text-[10px] text-gray-500 font-medium italic">Sedang proses verifikasi admin</p>
            </div>
        </div>

        <div class="bg-primary p-8 rounded-2xl shadow-lg shadow-primary/20 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform"></div>
            <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Telah Dibayarkan</p>
            <h3 class="text-3xl font-black text-white mt-2">Rp {{ number_format($data->saldo_dibayarkan, 0, ',', '.') }}</h3>
            <p class="text-xs text-secondary font-bold mt-4 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Terakhir: 15 Jan 2024
            </p>
        </div>
    </div>

    {{-- RIWAYAT TRANSFER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Riwayat Pembayaran dari Admin</h3>
            <button class="p-2 hover:bg-gray-50 rounded-lg text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Metode</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($data->riwayat as $trx)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($trx['tanggal'])->format('d M Y') }}</p>
                            <p class="text-[10px] text-gray-400">Pukul 14:00 WIB</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium text-gray-600 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                {{ $trx['metode'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border uppercase bg-green-50 text-green-600 border-green-100">
                                {{ $trx['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-black text-gray-800">Rp {{ number_format($trx['jumlah'], 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
