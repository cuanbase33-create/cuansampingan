<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - cuansampingan</title>
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
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 font-sans antialiased text-navy">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-navy text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col">
            <div class="flex items-center justify-center gap-3 h-16 bg-navy-light shadow-md border-b border-gray-border px-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo cuansampingan" class="h-8 w-auto object-contain">
                <span class="text-xl font-display font-bold text-gold tracking-tight">cuansampingan</span>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Dashboard
                </a>
                <!-- Kategori Dropdown / Accordion -->
                @php
                    $isCategoryActive = request()->routeIs('admin.categories.*') || request()->routeIs('admin.platform-categories.*');
                @endphp
                <div x-data="{ open: {{ $isCategoryActive ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                            type="button" 
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded transition duration-200 {{ $isCategoryActive ? 'bg-navy-light text-white font-medium border border-gray-border' : 'text-gray-300 hover:bg-navy-light hover:text-white' }}">
                        <span class="flex items-center">
                            Kategori
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-gold' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-cloak class="pl-4 space-y-1 pt-1">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="block px-4 py-2 text-sm rounded transition duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-teal text-white font-medium' : 'text-gray-400 hover:text-white hover:bg-navy-light' }}">
                            • Konten
                        </a>
                        <a href="{{ route('admin.platform-categories.index') }}" 
                           class="block px-4 py-2 text-sm rounded transition duration-200 {{ request()->routeIs('admin.platform-categories.*') ? 'bg-teal text-white font-medium' : 'text-gray-400 hover:text-white hover:bg-navy-light' }}">
                            • Platform
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.platforms.index') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.platforms.*') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Platform
                </a>
                <a href="{{ route('admin.articles.index') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Artikel Blog
                </a>
                <a href="{{ route('admin.tutorials.index') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.tutorials.*') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Tutorial
                </a>
                <a href="{{ route('admin.books.index') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.books.*') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Bacaan Rekomendasi
                </a>
                <a href="{{ route('admin.free-resources.index') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.free-resources.*') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Free Resources
                </a>
                <a href="{{ route('admin.digital-products.index') }}" class="block px-4 py-2.5 rounded transition duration-200 {{ request()->routeIs('admin.digital-products.*') ? 'bg-teal text-white' : 'text-gray-300 hover:bg-teal hover:text-white' }}">
                    Digital Products
                </a>
                <!-- Future CRUD menu items -->
            </nav>
            
            <div class="p-4 border-t border-gray-border">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-danger hover:bg-danger hover:text-white rounded transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden hover:text-teal transition">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="ml-4 text-xl font-display font-semibold text-gray-800 lg:ml-0">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-teal flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 hidden md:block">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
        
        <!-- Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-40 bg-navy opacity-50 lg:hidden"></div>
    </div>
    @yield('scripts')
</body>
</html>
