@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-teal/10 text-teal">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Platform</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_platforms']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gold/10 text-gold-dark">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Artikel</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_articles']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-navy/10 text-navy">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Bacaan Rekomendasi</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_books']) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-success/10 text-success">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">Total Article Views</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($stats['total_article_views']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('admin.platforms.create') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:border-teal hover:shadow-md transition group">
            <div class="p-3 rounded-full bg-teal/10 text-teal group-hover:bg-teal group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800 group-hover:text-teal transition">Tambah Platform</p>
                <p class="text-xs text-gray-500">Daftarkan platform baru</p>
            </div>
        </a>
        <a href="{{ route('admin.articles.create') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:border-teal hover:shadow-md transition group">
            <div class="p-3 rounded-full bg-teal/10 text-teal group-hover:bg-teal group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800 group-hover:text-teal transition">Tulis Artikel</p>
                <p class="text-xs text-gray-500">Buat konten artikel baru</p>
            </div>
        </a>
        <a href="{{ route('admin.categories.create') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex items-center gap-4 hover:border-teal hover:shadow-md transition group">
            <div class="p-3 rounded-full bg-teal/10 text-teal group-hover:bg-teal group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800 group-hover:text-teal transition">Tambah Kategori</p>
                <p class="text-xs text-gray-500">Buat kategori konten baru</p>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Selamat Datang di cuansampingan Admin Panel</h3>
        <p class="text-gray-600">
            Gunakan menu di sebelah kiri untuk mengelola konten, platform, dan sumber daya lainnya. Gunakan shortcut di atas untuk akses cepat.
        </p>
    </div>
@endsection
