<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'BrandingAja')</title>

    {{-- GOOGLE FONTS: INTER --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-[#f8fafc]">

    {{-- NAVBAR --}}
    @include('layouts.admin-navbar')

    {{-- WRAPPER (OFFSET NAVBAR) --}}
    <div class="pt-[88px] flex w-full min-h-[calc(100vh-88px)]">

        {{-- MAIN CONTENT --}}
        <main
            class="
                flex-1
                px-4 py-6 md:px-10 md:py-8
                w-full max-w-7xl mx-auto
                transition-all duration-300 ease-in-out
                min-h-[calc(100vh-88px)]
            "
        >
            @yield('content')
        </main>

    </div>

    {{-- FOOTER --}}
    @include('layouts.footer')

    {{-- SCRIPT --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
