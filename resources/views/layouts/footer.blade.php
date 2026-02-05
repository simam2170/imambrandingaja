<!-- ================= FOOTER ================= -->
<footer class="bg-white text-dark pt-16 pb-8 border-t border-gray-100 font-sans">
    
    <div class="px-6 mx-auto max-w-7xl lg:px-8">
        
        <div class="grid grid-cols-1 gap-12 mb-16 md:grid-cols-2 lg:grid-cols-4">

            <!-- COL 1: BRANDING AJA (LINKS) -->
            <div>
                <h3 class="mb-6 text-lg font-bold tracking-wider uppercase text-primary">BRANDING AJA</h3>
                <ul class="space-y-4 text-sm font-bold tracking-wide text-gray-600 uppercase">
                    <li><a href="{{ route('tentangkami') }}" class="transition-colors hover:text-primary">TENTANG KAMI</a></li>
                    <li><a href="#client" class="transition-colors hover:text-primary">CLIENT</a></li>
                    <li><a href="#user" class="transition-colors hover:text-primary">USER</a></li>
                    <li><a href="#bergabung" class="transition-colors hover:text-primary">BERGABUNG</a></li>
                </ul>
            </div>

            <!-- COL 2: IKUTI KAMI (SOCIALS) -->
            <div>
                <h3 class="mb-6 text-lg font-bold tracking-wider uppercase text-primary">IKUTI KAMI</h3>
                <ul class="space-y-4 text-sm font-bold tracking-wide text-gray-600 uppercase">
                    <li><a href="#" class="transition-colors hover:text-primary">INSTAGRAM</a></li>
                    <li><a href="#" class="transition-colors hover:text-primary">YOUTUBE</a></li>
                    <li><a href="#" class="transition-colors hover:text-primary">TIK TOK</a></li>
                    <li><a href="#" class="transition-colors hover:text-primary">X</a></li>
                </ul>
            </div>

            <!-- COL 3: INFORMASI (ADDRESS & MAP) -->
            <div>
                <h3 class="mb-6 text-lg font-bold tracking-wider uppercase text-primary">INFORMASI</h3>
                <p class="mb-4 text-sm font-bold leading-relaxed text-gray-800">
                    Jalan Gajah Mungkur no xx<br>
                    Semarang - Jawa Tengah<br>
                    Indonesia
                </p>
                <!-- MAP PLACEHOLDER (GRAY BOX) -->
                <div class="w-full h-32 bg-gray-300 rounded-lg"></div>
            </div>

            <!-- COL 4: PEMBAYARAN -->
            <div>
                <h3 class="mb-6 text-lg font-bold tracking-wider uppercase text-primary">PEMBAYARAN</h3>
                <div class="grid grid-cols-2 gap-4">
                    <!-- LOGOS (Using placeholders or assets if they exist, trying to match layout) -->
                    <!-- Row 1 -->
                    <div class="flex items-center h-8 bg-transparent">
                        <img src="{{ asset('img/bca.png') }}" class="object-contain h-full" alt="BCA">
                    </div>
                    <div class="flex items-center h-8 bg-transparent">
                        <img src="{{ asset('img/bni.png') }}" class="object-contain h-full" alt="BNI">
                    </div>
                    <!-- Row 2 -->
                    <div class="flex items-center h-10 bg-transparent">
                        <img src="{{ asset('img/bank-jateng.png') }}" class="object-contain h-full" alt="Bank Jateng">
                    </div>
                    <div class="flex items-center h-10 bg-transparent">
                        <img src="{{ asset('img/qris.png') }}" class="object-contain h-full" alt="QRIS">
                    </div>
                </div>
            </div>

        </div>

        <!-- FOOTER BOTTOM -->
        <div class="flex flex-col items-center justify-between pt-8 border-t border-gray-300 md:flex-row">
            <!-- LOGO LEFT -->
            <div class="flex items-center gap-1 mb-4 md:mb-0">
                <span class="text-2xl font-bold tracking-tight text-gray-900">
                    Branding<span class="text-primary italic">Aja</span><span class="text-secondary">.</span>
                </span>
                <!-- Or use IMG if preferred: <img src="{{ asset('img/logo.png') }}" class="h-8"> -->
            </div>

            <!-- COPYRIGHT CENTER/RIGHT -->
            <div class="text-sm font-bold text-gray-500">
                © Copyright by 2026
            </div>
            
            <!-- Empty div for flex balance if needed, or just let them space out -->
             <div class="hidden md:block w-[100px]"></div>
        </div>

    </div>
</footer>