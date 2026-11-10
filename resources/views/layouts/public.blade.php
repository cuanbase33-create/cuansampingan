<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtm.js?id=GTM-5G2H7VV7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', 'cuansampingan — Panduan Menghasilkan Uang Online')</title>
    <meta name="description" content="@yield('meta_description', 'Platform informasi terlengkap tentang cara menghasilkan uang online di Indonesia.')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'cuansampingan')">
    <meta property="og:description" content="@yield('meta_description', 'Platform informasi terlengkap tentang cara menghasilkan uang online di Indonesia.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=JetBrains+Mono&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0D1B2A',
                        'navy-light': '#162436',
                        gold: '#F5C518',
                        'gold-dark': '#D4A90E',
                        teal: '#1DB89A',
                        'teal-dark': '#17967E',
                        'gray-soft': '#A8B8C8',
                        'gray-border': '#1E2F42',
                        danger: '#E05252',
                        success: '#2ECC71',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; background-color: #0D1B2A; color: #FFFFFF; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-navy text-white min-h-screen flex flex-col antialiased">
    <!-- Navbar -->
    <header class="bg-navy border-b border-gray-border sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo cuansampingan" class="h-9 w-auto object-contain">
                        <span class="text-2xl font-bold font-display text-gold">cuansampingan</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8" x-data="{ dropdownOpen: false }">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gold' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium transition">Home</a>
                    
                    <div class="relative" @click.away="dropdownOpen = false">
                        <button @click="dropdownOpen = !dropdownOpen" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium transition flex items-center">
                            Platform
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="dropdownOpen" x-cloak class="absolute left-0 mt-2 w-48 bg-navy-light rounded-md shadow-lg border border-gray-border overflow-hidden z-20">
                            @foreach($navPlatformCategories ?? [] as $navCat)
                                <a href="{{ route('platform.show', $navCat->slug) }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-navy hover:text-gold transition">
                                    {{ $navCat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel.*') ? 'text-gold' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium transition">Artikel</a>
                    <a href="{{ route('bacaan.index') }}" class="{{ request()->routeIs('bacaan.*') ? 'text-gold' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium transition">Bacaan Rekomendasi</a>
                    <a href="{{ route('free-resources.index') }}" class="{{ request()->routeIs('free-resources.*') ? 'text-gold' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium transition">Free Resources</a>
                    <a href="{{ route('digital-product.index') }}" class="{{ request()->routeIs('digital-product.*') ? 'text-gold' : 'text-gray-300 hover:text-white' }} px-3 py-2 text-sm font-medium transition">Digital Product</a>
                </nav>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden" x-data="{ mobileMenuOpen: false }">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <!-- Mobile Menu Panel -->
                    <div x-show="mobileMenuOpen" x-cloak class="absolute top-16 left-0 w-full bg-navy border-b border-gray-border z-50">
                        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-navy-light">Home</a>
                            <div class="px-3 py-1 text-xs font-semibold uppercase tracking-wider text-teal">Platform</div>
                            @foreach($navPlatformCategories ?? [] as $navCat)
                                <a href="{{ route('platform.show', $navCat->slug) }}" class="block px-4 py-1.5 rounded-md text-sm font-medium text-gray-300 hover:bg-navy-light hover:text-gold pl-6">
                                    {{ $navCat->name }}
                                </a>
                            @endforeach
                            <a href="{{ route('artikel.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-navy-light hover:text-white">Artikel</a>
                            <a href="{{ route('bacaan.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-navy-light hover:text-white">Bacaan Rekomendasi</a>
                            <a href="{{ route('free-resources.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-navy-light hover:text-white">Free Resources</a>
                            <a href="{{ route('digital-product.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-navy-light hover:text-white">Digital Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-navy border-t border-gray-border pt-12 pb-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo cuansampingan" class="h-9 w-auto object-contain">
                        <span class="text-2xl font-bold font-display text-gold">cuansampingan</span>
                    </div>
                    <p class="mt-4 text-gray-soft max-w-md">Panduan lengkap untuk menemukan peluang, platform, dan cara menghasilkan uang secara online.</p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Navigasi</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="{{ route('home') }}" class="text-base text-gray-soft hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('artikel.index') }}" class="text-base text-gray-soft hover:text-white transition">Artikel</a></li>
                        <li><a href="{{ route('bacaan.index') }}" class="text-base text-gray-soft hover:text-white transition">Rekomendasi</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Platform</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach($navPlatformCategories ?? [] as $navCat)
                            <li>
                                <a href="{{ route('platform.show', $navCat->slug) }}" class="text-base text-gray-soft hover:text-white transition">
                                    {{ $navCat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-border pt-8 flex items-center justify-between">
                <p class="text-base text-gray-soft">&copy; {{ date('Y') }} cuansampingan. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
