@extends(request()->routeIs('admin.*') ? 'layouts.admin' : 'layouts.mitra')

@section('title', 'Profil User - ' . $user->name)

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- BACK BUTTON --}}
        <div class="flex items-center gap-4">
            <a href="javascript:history.back()"
                class="p-2 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-primary transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Profil Pemesan</h1>
        </div>

        {{-- HERO PROFILE CARD --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Header Gradient --}}
            <div class="h-32 bg-gradient-to-r from-primary to-primary/60 relative">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;">
                </div>
            </div>

            <div class="px-8 pb-8">
                <div class="relative flex flex-col items-center sm:items-start">
                    {{-- Avatar --}}
                    <div
                        class="-mt-16 w-32 h-32 bg-white rounded-3xl p-1 shadow-lg overflow-hidden border-4 border-white mb-4">
                        @if($user->foto_profil)
                            <img src="{{ asset('uploads/profile_photos/' . $user->foto_profil) }}"
                                class="w-full h-full object-cover rounded-2xl">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=02B0AF&color=fff&size=128"
                                class="w-full h-full object-cover rounded-2xl">
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-end justify-between w-full gap-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-500 font-medium">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $user->email }}
                                </span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    +62 {{ $user->whatsapp }}
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="https://wa.me/62{{ $user->whatsapp }}" target="_blank"
                                class="px-6 py-2.5 bg-green-500 text-white font-bold rounded-xl shadow-lg shadow-green-200 hover:bg-green-600 transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884 0 2.225.584 4.393 1.696 6.14l-.881 3.211 3.284-.86c1.611.879 3.098 1.411 4.709 1.411zm11.367-7.461c-.301-.15-1.781-.879-2.057-.979-.275-.101-.476-.15-.675.151-.199.301-.771.979-.944 1.179-.173.201-.347.227-.648.077-.301-.15-1.272-.469-2.423-1.496-.895-.798-1.5-1.784-1.675-2.085-.175-.301-.019-.463.131-.612.135-.134.301-.351.451-.526.15-.175.201-.301.301-.501.101-.199.049-.375-.025-.526-.075-.151-.675-1.628-.924-2.228-.243-.585-.487-.506-.675-.515-.173-.008-.374-.01-.576-.01-.202 0-.527.076-.802.376-.275.301-1.053 1.028-1.053 2.507s1.078 2.906 1.228 3.107c.15.201 2.122 3.241 5.138 4.542.717.31 1.277.496 1.711.635.72.229 1.375.196 1.893.119.577-.087 1.781-.727 2.031-1.428.251-.701.251-1.303.176-1.428-.075-.125-.275-.201-.576-.351z" />
                                </svg>
                                Kirim Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Left: Bio --}}
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Bio / Tentang User
                    </h3>
                    <div class="text-gray-700 leading-relaxed text-lg whitespace-pre-wrap text-justify">
                        {{ $user->bio ?? 'User ini belum mengisi biodata profil.' }}
                    </div>
                </div>
            </div>

            {{-- Right: Categories & Stats --}}
            <div class="space-y-8">
                {{-- Categories --}}
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Kategori Bidang</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->bidang ?? [] as $cat)
                            <span
                                class="px-4 py-2 bg-primary/5 text-primary text-sm font-bold rounded-xl border border-primary/10">
                                {{ $cat }}
                            </span>
                        @empty
                            <span class="text-gray-400 italic text-sm">Belum ditentukan</span>
                        @endforelse
                    </div>
                </div>

                {{-- Stats --}}
                <div class="bg-gray-900 rounded-3xl p-8 text-white shadow-xl shadow-gray-200">
                    <h3 class="text-gray-400 text-xs font-bold uppercase mb-6 tracking-widest">Aktivitas</h3>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase">Member Sejak</p>
                                <p class="font-bold text-sm">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 118 0m-4 8a2 2 0 110-4 2 2 0 010 4zm-8 8a2 2 0 110-4 2 2 0 010 4zm-4-8a2 2 0 110-4 2 2 0 010 4m-4 8a2 2 0 110-4 2 2 0 010 4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase">Tipe Akun</p>
                                <p class="font-bold text-sm capitalize">{{ $user->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection