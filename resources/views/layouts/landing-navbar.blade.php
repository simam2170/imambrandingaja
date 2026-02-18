<nav x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    class="fixed top-0 z-50 w-full transition-all duration-300 border-b border-transparent"
    :class="scrolled ? 'bg-white shadow-sm py-3 border-gray-200' : 'bg-primary py-4'">

    <div class="flex items-center justify-between px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Logo -->
        <a href="{{ route('beranda') }}" class="flex items-center gap-2 group">
            <div class="h-10 w-auto">
                <img src="{{ asset('assets/logo/brandingaja_logo.png') }}" alt="BrandingAja"
                    class="h-full w-auto object-contain transition-transform group-hover:scale-105"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span class="text-2xl font-bold tracking-tight hidden"
                    :class="scrolled ? 'text-gray-900' : 'text-white'">
                    Branding<span class="italic"
                        :class="scrolled ? 'text-accent-500' : 'text-accent-400'">Aja</span><span
                        :class="scrolled ? 'text-primary' : 'text-white/90'">.</span>
                </span>
            </div>
        </a>

        <!-- Desktop Menu -->
        <div class="items-center hidden gap-8 lg:flex">
            <ul class="flex items-center gap-6 font-medium" :class="scrolled ? 'text-gray-500' : 'text-white/90'">
                <li>
                    <a href="{{ route('beranda') }}" class="transition-colors hover:text-accent-400 font-bold">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('tentangkami') }}" class="transition-colors hover:text-accent-400">
                        Tentang Kami
                    </a>
                </li>
            </ul>

            <!-- Separator -->
            <div class="hidden lg:block w-px h-6 transition-colors" :class="scrolled ? 'bg-gray-200' : 'bg-white/30'">
            </div>

            <!-- Login / Direct Access Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('bypass.user') }}"
                    class="px-4 py-2 text-sm font-bold text-primary bg-white rounded-full hover:bg-gray-100 transition shadow-sm">
                    Masuk User
                </a>
                <a href="{{ route('bypass.mitra') }}"
                    class="px-4 py-2 text-sm font-bold text-white border border-white rounded-full hover:bg-white/10 transition">
                    Masuk Mitra
                </a>
                <a href="{{ route('bypass.admin') }}"
                    class="px-4 py-2 text-sm font-bold text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                    Admin
                </a>
            </div>
        </div>

        <!-- Hamburger (Mobile) placeholder -->
        <div class="lg:hidden text-white">☰</div>

    </div>
</nav>

<!-- Push content down because navbar is fixed -->
<div class="h-16"></div>