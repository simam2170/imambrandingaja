@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        {{-- LEFT SIDEBAR (AVATAR) --}}
        <div class="col-span-12 lg:col-span-4 xl:col-span-3 space-y-6">
            
            <div class="bg-white rounded-2xl p-6 border border-gray-100 text-center shadow-sm">
                <div class="w-32 h-32 mx-auto bg-gray-50 rounded-full mb-4 overflow-hidden border-4 border-white shadow-sm relative group">
                    @if($user->foto_profil)
                        <img src="{{ asset('uploads/profile_photos/' . $user->foto_profil) }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=02B0AF&color=fff&size=128" class="w-full h-full object-cover">
                    @endif
                    <!-- Hover Effect for Edit Avatar -->
                    <label for="foto_profil" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </label>
                </div>
                <h2 class="font-bold text-gray-900 text-xl">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mb-4">Member sejak {{ $user->created_at->format('Y') }}</p>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Online
                </div>
            </div>

            <!-- Optional: Sidedar Menu could go here, but focusing on Form as requested -->
        </div>

        {{-- RIGHT MAIN CONTENT (FORM) --}}
        <div class="col-span-12 lg:col-span-8 xl:col-span-9">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-bold flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-bold">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $isReadOnly = request()->routeIs('admin.user.profile') || request()->routeIs('mitra.user.profile');
            @endphp

            <form action="{{ route('user.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @if(!$isReadOnly)
                    <input type="file" name="foto_profil" id="foto_profil" class="hidden" onchange="this.form.submit()">
                @endif

                <!-- SECTION 1: INFORMASI USER -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">Informasi Pribadi</h2>
                        <p class="text-gray-500 text-sm mt-1">Perbarui detail akun dan informasi kontak Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Username -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required {{ $isReadOnly ? 'readonly' : '' }}
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-400 {{ $isReadOnly ? 'bg-gray-50' : '' }}">
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required {{ $isReadOnly ? 'readonly' : '' }}
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-400 {{ $isReadOnly ? 'bg-gray-50' : '' }}">
                        </div>

                        <!-- No WhatsApp -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">No. WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500 font-medium">+62</span>
                                <input type="tel" name="phone" value="{{ old('phone', $user->whatsapp) }}" {{ $isReadOnly ? 'readonly' : '' }}
                                    class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-400 {{ $isReadOnly ? 'bg-gray-50' : '' }}">
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm font-bold text-gray-700">Bio / Deskripsi Profil</label>
                            <textarea name="bio" rows="4" {{ $isReadOnly ? 'readonly' : '' }}
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-400 {{ $isReadOnly ? 'bg-gray-50' : '' }}"
                                placeholder="Ceritakan sedikit tentang Anda atau usaha Anda...">{{ old('bio', $user->bio) }}</textarea>
                            <p class="text-xs text-gray-400">Maksimal 1000 karakter.</p>
                        </div>

                        @if(!$isReadOnly)
                        <!-- Password Baru -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">Password Baru</label>
                            <input type="password" name="password" placeholder="••••••••" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-400">
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 font-medium focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder-gray-400">
                        </div>
                        @endif

                    </div>
                </div>

                <!-- SECTION 2: KATEGORI BIDANG (MULTI-SELECT) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Bidang yang Anda Geluti</h2>
                        <p class="text-gray-500 text-sm mt-1">Pilih satu atau lebih kategori yang sesuai dengan profesi Anda.</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $categories = ['UMKM', 'Influencer', 'Konten Kreator', 'Instansi', 'Portal Berita', 'Agency', 'Freelancer', 'Lainnya'];
                        @endphp

                        @foreach($categories as $cat)
                        <label class="relative {{ $isReadOnly ? 'cursor-default' : 'cursor-pointer' }} group">
                            <input type="checkbox" name="categories[]" value="{{ $cat }}" class="peer sr-only"
                                {{ in_array($cat, $user->bidang ?? []) ? 'checked' : '' }} {{ $isReadOnly ? 'disabled' : '' }}>
                            
                            <div class="h-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50 text-gray-600 text-sm font-semibold text-center transition-all duration-200
                                        peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary
                                        {{ !$isReadOnly ? 'group-hover:border-primary/50 group-hover:bg-white' : '' }}">
                                {{ $cat }}
                            </div>

                            <!-- Check Icon (Visible when checked) -->
                            <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity text-primary">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                @if(!$isReadOnly)
                <!-- SECTION 3: TOMBOL SIMPAN -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-primary/90 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
                @endif

            </form>
        </div>

    </div>

@endsection