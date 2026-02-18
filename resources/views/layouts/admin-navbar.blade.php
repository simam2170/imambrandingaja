<nav x-data="{ mobileOpen: false, scrolled: false }" 
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     class="fixed top-0 z-50 w-full transition-all duration-300 border-b border-transparent"
     :class="scrolled ? 'bg-white shadow-sm py-3 border-gray-200' : 'bg-gray-900 py-4'"
>

    <div class="flex items-center justify-between px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Logo -->
        <a href="{{ route('admin.pesanan.index') }}" class="flex items-center gap-2">
            <span class="text-2xl font-bold tracking-tight" :class="scrolled ? 'text-gray-900' : 'text-white'">
                Branding<span class="italic" :class="scrolled ? 'text-primary-600' : 'text-white/90'">Aja</span><span class="text-xs ml-1 px-2 py-0.5 rounded-full" :class="scrolled ? 'bg-gray-900 text-white' : 'bg-white text-gray-900'">ADMIN</span>
            </span>
        </a>

        <!-- Desktop Menu -->
        <div class="items-center hidden gap-8 lg:flex">
            <ul class="flex items-center gap-6 font-medium" :class="scrolled ? 'text-gray-500' : 'text-white/90'">
                <li>
                    <a href="{{ route('admin.pesanan.index') }}"
                        class="transition-colors hover:text-primary-500 {{ request()->routeIs('admin.pesanan*') ? 'font-bold underline underline-offset-4 text-white' : '' }} "
                        :class="[scrolled ? ({{ request()->routeIs('admin.pesanan*') ? '\'text-primary-600\'' : '\'hover:text-primary-600\'' }}) : ({{ request()->routeIs('admin.pesanan*') ? '\'text-white\'' : '\'hover:text-white\'' }})]"
                    >
                        Pesanan Masuk
                    </a>
                </li>
            </ul>

            <!-- Separator -->
            <div class="hidden lg:block w-px h-6 transition-colors" :class="scrolled ? 'bg-gray-200' : 'bg-white/30'"></div>

            <!-- Admin Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 transition-opacity hover:opacity-80">
                    <div class="hidden text-right xl:block">
                        <p class="text-sm font-bold transition-colors" :class="scrolled ? 'text-gray-800' : 'text-white'">Admin</p>
                    </div>
                    <div class="w-10 h-10 overflow-hidden transition-all border rounded-full bg-white/20 border-white/30 ring-2 ring-transparent hover:ring-primary-500">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Avatar" class="object-cover w-full h-full">
                    </div>
                </button>

                <div x-show="open" x-transition.origin.top.right x-cloak @click.outside="open = false"
                    class="absolute right-0 w-48 mt-3 overflow-hidden bg-white border border-gray-100 shadow-xl rounded-xl ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <a href="/" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
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
            <a href="{{ route('admin.pesanan.index') }}" @click="mobileOpen=false"
                class="block py-3 px-4 rounded-xl hover:bg-gray-50 text-gray-800 font-bold">
                Pesanan Masuk
            </a>
            <div class="h-px my-2 bg-gray-100"></div>
            <a href="/" class="block px-4 py-3 font-medium text-red-600 rounded-xl hover:bg-red-50">
                Logout
            </a>
        </div>
    </div>
</nav>

