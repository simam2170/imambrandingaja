<nav x-data="{ mobileOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     class="fixed top-0 z-50 w-full transition-all duration-300 border-b border-transparent"
     :class="scrolled ? 'bg-white shadow-sm py-3 border-gray-200' : 'bg-primary py-4'"
>

    <div class="flex items-center justify-between px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Logo / Beranda -->
        <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2">
            <!-- Logo logic: White when primary (top), Colored when scrolled (white bg) -->
            <span class="text-2xl font-bold tracking-tight" :class="scrolled ? 'text-gray-900' : 'text-white'">
                Branding<span class="italic" :class="scrolled ? 'text-secondary' : 'text-white/90'">Aja</span><span :class="scrolled ? 'text-primary' : 'text-white/90'">.</span>
            </span>
        </a>

        <!-- Desktop Menu -->
        <div class="items-center hidden gap-8 lg:flex">
            <ul class="flex items-center gap-6 font-medium" :class="scrolled ? 'text-gray-500' : 'text-white/90'">
                <li>
                    <a href="{{ route('user.dashboard') }}"
                        class="transition-colors hover:text-accent {{ request()->routeIs('user.dashboard') ? 'font-bold' : '' }} "
                        :class="[scrolled ? ({{ request()->routeIs('user.dashboard') ? '\'text-primary\'' : '\'hover:text-primary\'' }}) : ({{ request()->routeIs('user.dashboard') ? '\'text-white\'' : '\'hover:text-white\'' }})]"
                    >
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.pesanan') }}"
                         class="transition-colors hover:text-accent {{ request()->routeIs('user.pesanan') ? 'font-bold' : '' }} "
                        :class="[scrolled ? ({{ request()->routeIs('user.pesanan') ? '\'text-primary\'' : '\'hover:text-primary\'' }}) : ({{ request()->routeIs('user.pesanan') ? '\'text-white\'' : '\'hover:text-white\'' }})]"
                    >
                        Pesanan Saya
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.keranjang') }}"
                         class="transition-colors hover:text-accent {{ request()->routeIs('user.keranjang') ? 'font-bold' : '' }} "
                        :class="[scrolled ? ({{ request()->routeIs('user.keranjang') ? '\'text-primary\'' : '\'hover:text-primary\'' }}) : ({{ request()->routeIs('user.keranjang') ? '\'text-white\'' : '\'hover:text-white\'' }})]"
                    >
                        Keranjang
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile') }}"
                         class="transition-colors hover:text-accent {{ request()->routeIs('user.profile') ? 'font-bold' : '' }} "
                        :class="[scrolled ? ({{ request()->routeIs('user.profile') ? '\'text-primary\'' : '\'hover:text-primary\'' }}) : ({{ request()->routeIs('user.profile') ? '\'text-white\'' : '\'hover:text-white\'' }})]"
                    >
                        Profil
                    </a>
                </li>
            </ul>

            <!-- Separator -->
            <div class="hidden lg:block w-px h-6 transition-colors" :class="scrolled ? 'bg-gray-200' : 'bg-white/30'"></div>

            <!-- User Dropdown (Avatar) -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 transition-opacity hover:opacity-80">
                    <div class="hidden text-right xl:block">
                        <p class="text-sm font-bold transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Hi, {{ $user->name ?? Auth::user()->name ?? 'Username' }}</p>
                    </div>
                    <div class="w-10 h-10 overflow-hidden transition-all border rounded-full bg-white/20 border-white/30 ring-2 ring-transparent hover:ring-secondary">
                        @if(($user->foto_profil ?? Auth::user()->foto_profil ?? null))
                            <img src="{{ asset('uploads/profile_photos/' . ($user->foto_profil ?? Auth::user()->foto_profil)) }}" alt="Avatar" class="object-cover w-full h-full">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? Auth::user()->name ?? 'User Name') }}&background=random" alt="Avatar" class="object-cover w-full h-full">
                        @endif
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="[open ? 'rotate-180' : '', scrolled ? 'text-gray-400' : 'text-white/80']" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition.origin.top.right x-cloak @click.outside="open = false"
                    class="absolute right-0 w-48 mt-3 overflow-hidden bg-white border border-gray-100 shadow-xl rounded-xl ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-sm font-bold leading-none text-gray-900">{{ $user->name ?? Auth::user()->name ?? 'Username' }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $user->email ?? Auth::user()->email ?? 'user@example.com' }}</p>
                        </div>
                        
                        <a href="{{ route('user.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-primary/10 hover:text-primary">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            Profil
                        </a>
                        
                        <div class="h-px my-1 bg-gray-50"></div>

                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-primary/10 hover:text-primary transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hamburger (Mobile) -->
        <button @click="mobileOpen = !mobileOpen" class="p-2 text-2xl rounded-md lg:hidden focus:outline-none hover:bg-white/10" :class="scrolled ? 'text-gray-700' : 'text-white'">
            ☰
        </button>

    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" x-transition x-cloak
        class="lg:hidden absolute top-full left-0 w-full bg-white border-b border-gray-200 shadow-lg max-h-[90vh] overflow-y-auto">
        
        <div class="p-4 space-y-2">
            
            {{-- Mobile User Info --}}
            <a href="{{ route('user.profile') }}" @click="mobileOpen=false">
            <div class="flex items-center gap-3 px-4 py-3 mb-4 border border-gray-100 bg-gray-50 rounded-xl">
                <div class="w-10 h-10 overflow-hidden bg-white border border-gray-200 rounded-full">
                    @if(($user->foto_profil ?? Auth::user()->foto_profil ?? null))
                        <img src="{{ asset('uploads/profile_photos/' . ($user->foto_profil ?? Auth::user()->foto_profil)) }}" class="object-cover w-full h-full">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? Auth::user()->name ?? 'User Name') }}&background=random" class="object-cover w-full h-full">
                    @endif
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Hi, {{ $user->name ?? Auth::user()->name ?? 'Username' }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email ?? Auth::user()->email ?? 'user@example.com' }}</p>
                </div>
            </div>
            </a>    

            @php
                $mobileActive = 'text-primary font-bold bg-primary/10';
                $mobileHover = 'text-gray-600 hover:text-primary hover:bg-primary/5';
            @endphp
    
            <a href="{{ route('user.dashboard') }}" @click="mobileOpen=false"
                class="block py-3 px-4 rounded-xl {{ request()->routeIs('user.dashboard') ? $mobileActive : $mobileHover }}">
                Dashboard
            </a>
    
            <a href="{{ route('user.pesanan') }}" @click="mobileOpen=false"
                class="block py-3 px-4 rounded-xl {{ request()->routeIs('user.pesanan') ? $mobileActive : $mobileHover }}">
                Pesanan Saya
            </a>    
    
            <a href="{{ route('user.keranjang') }}" @click="mobileOpen=false"
                class="block py-3 px-4 rounded-xl {{ request()->routeIs('user.keranjang') ? $mobileActive : $mobileHover }}">
                Keranjang Saya
            </a>
    
            <a href="{{ route('user.profile') }}" @click="mobileOpen=false"
                class="block py-3 px-4 rounded-xl {{ request()->routeIs('user.profile') ? $mobileActive : $mobileHover }}">
                Profil
            </a>

            <div class="h-px my-2 bg-gray-100"></div>
    
            <a href="#" class="block px-4 py-3 font-medium text-gray-700 rounded-xl hover:bg-primary/10 hover:text-primary">
                Logout
            </a>
        </div>
    </div>
</nav>
