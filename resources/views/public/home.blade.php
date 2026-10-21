@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="bg-navy border-b border-gray-border py-20 lg:py-32 relative overflow-hidden">
    <!-- Ambient Radial Glows (Teal & Gold accents) -->
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-teal/20 via-teal/5 to-transparent blur-3xl pointer-events-none rounded-full"></div>
    <div class="absolute top-1/3 -left-32 w-80 h-80 bg-gold/10 blur-3xl pointer-events-none rounded-full"></div>
    <div class="absolute top-1/4 -right-32 w-80 h-80 bg-teal/15 blur-3xl pointer-events-none rounded-full"></div>

    <!-- Tech Grid Pattern Overlay -->
    <div class="absolute inset-0 opacity-[0.12] pointer-events-none" style="background-image: linear-gradient(to right, #1DB89A 1px, transparent 1px), linear-gradient(to bottom, #1DB89A 1px, transparent 1px); background-size: 40px 40px;"></div>

    <!-- Radial Mask to soften the grid on edges -->
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_at_center,transparent_20%,#0D1B2A_75%)]"></div>

    <!-- Subtle Dot Matrix Layer -->
    <div class="absolute inset-0 opacity-20 pointer-events-none bg-[radial-gradient(#F5C518_1px,transparent_1px)] [background-size:24px_24px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-display text-white mb-6 leading-tight max-w-4xl mx-auto">
            Panduan Lengkap Menghasilkan Uang <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold via-yellow-300 to-amber-400">Secara Online</span>
        </h1>
        <p class="text-lg md:text-xl text-gray-soft mb-10 max-w-2xl mx-auto leading-relaxed">
            Temukan berbagai platform, strategi, dan resources untuk mulai menghasilkan pendapatan dari internet.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('platform.show', 'survei-berbayar') }}" class="px-8 py-4 bg-gradient-to-r from-gold to-gold-dark hover:from-gold-dark hover:to-gold text-navy font-bold rounded-lg transition-all shadow-lg shadow-gold/20 hover:shadow-gold/30 hover:-translate-y-0.5 text-lg">
                Lihat Platform
            </a>
            <a href="{{ route('artikel.index') }}" class="px-8 py-4 bg-navy-light/60 hover:bg-navy-light border border-teal/50 hover:border-teal text-teal hover:text-teal font-bold rounded-lg transition-all backdrop-blur-sm hover:-translate-y-0.5 text-lg">
                Baca Artikel
            </a>
        </div>
    </div>
</section>

<!-- Kategori Platform Section -->
<section class="py-16 bg-navy">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold font-display text-white">Kategori Platform</h2>
            <p class="mt-4 text-gray-soft">Pilih cara yang paling cocok dengan skill dan waktu luang Anda.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($platformCategories as $category)
                <a href="{{ route('platform.show', $category->slug) }}" class="bg-navy-light border border-gray-border hover:border-gold p-6 rounded-xl flex items-center transition-colors duration-300 group">
                    <div class="w-12 h-12 rounded-lg bg-navy flex items-center justify-center text-teal group-hover:text-gold transition-colors mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold font-display text-white group-hover:text-gold transition-colors">{{ $category->name }}</h3>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center text-gray-soft">Belum ada kategori platform.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Artikel Terbaru -->
<section class="py-16 bg-navy-light border-y border-gray-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold font-display text-white">Artikel Terbaru</h2>
                <p class="mt-2 text-gray-soft">Panduan, tips, dan strategi terbaru.</p>
            </div>
            <a href="{{ route('artikel.index') }}" class="hidden md:inline-flex text-teal hover:text-white font-medium items-center transition-colors">
                Lihat Semua Artikel
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($latestArticles as $article)
                <x-public.article-card :article="$article" />
            @empty
                <div class="col-span-full text-center text-gray-soft py-10">Belum ada artikel.</div>
            @endforelse
        </div>
        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('artikel.index') }}" class="inline-flex text-teal hover:text-white font-medium items-center transition-colors">
                Lihat Semua Artikel
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- Bacaan Rekomendasi -->
<section class="py-16 bg-navy">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold font-display text-white">Bacaan Rekomendasi</h2>
                <p class="mt-2 text-gray-soft">Buku-buku pilihan untuk meningkatkan mindset dan skill.</p>
            </div>
            <a href="{{ route('bacaan.index') }}" class="hidden md:inline-flex text-teal hover:text-white font-medium items-center transition-colors">
                Lihat Semua Buku
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($latestBooks as $book)
                <x-public.book-card :book="$book" />
            @empty
                <div class="col-span-full text-center text-gray-soft py-10">Belum ada bacaan rekomendasi.</div>
            @endforelse
        </div>
        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('bacaan.index') }}" class="inline-flex text-teal hover:text-white font-medium items-center transition-colors">
                Lihat Semua Buku
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- Tutorial Terbaru -->
<section class="py-16 bg-navy-light border-y border-gray-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold font-display text-white">Tutorial Terbaru</h2>
                <p class="mt-2 text-gray-soft">Panduan langkah demi langkah menghasilkan uang online.</p>
            </div>
            <a href="{{ route('tutorial.index') }}" class="hidden md:inline-flex text-teal hover:text-white font-medium items-center transition-colors">
                Lihat Semua Tutorial
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($latestTutorials as $tutorial)
                <x-public.tutorial-card :tutorial="$tutorial" />
            @empty
                <div class="col-span-full text-center text-gray-soft py-10">Belum ada tutorial.</div>
            @endforelse
        </div>
        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('tutorial.index') }}" class="inline-flex text-teal hover:text-white font-medium items-center transition-colors">
                Lihat Semua Tutorial
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- Free Resources & Digital Products -->
<section class="py-16 bg-navy">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16">
        <!-- Free Resources -->
        <div>
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-2xl font-bold font-display text-white">Free Resources</h2>
                <a href="{{ route('free-resources.index') }}" class="text-sm text-teal hover:text-white transition-colors">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($latestResources as $resource)
                    <x-public.resource-card :resource="$resource" />
                @empty
                    <div class="col-span-full text-center text-gray-soft py-4">Belum ada free resource.</div>
                @endforelse
            </div>
        </div>
        
        <!-- Digital Products -->
        <div>
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-2xl font-bold font-display text-white">Produk Digital</h2>
                <a href="{{ route('digital-product.index') }}" class="text-sm text-teal hover:text-white transition-colors">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($latestProducts as $product)
                    <x-public.product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center text-gray-soft py-4">Belum ada produk digital.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection
