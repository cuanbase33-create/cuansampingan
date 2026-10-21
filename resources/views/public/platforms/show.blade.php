@extends('layouts.public')

@section('meta_title', $category->name . ' - Platform cuansampingan')
@section('meta_description', 'Daftar platform ' . $category->name . ' terbaik untuk menghasilkan uang online.')

@section('content')
<!-- Header Kategori -->
<div class="bg-navy-light border-b border-gray-border pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navigasi Kategori (Tabs) -->
        <div class="flex overflow-x-auto pb-4 mb-8 hide-scrollbar space-x-2">
            @foreach($allCategories as $cat)
                <a href="{{ route('platform.show', $cat->slug) }}" 
                   class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request()->segment(2) == $cat->slug ? 'bg-gold border-gold text-navy' : 'bg-transparent border-gray-border text-gray-300 hover:border-gold hover:text-white' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
        
        <h1 class="text-3xl md:text-4xl font-bold font-display text-white mb-4">{{ $category->name }}</h1>
        <p class="text-gray-soft max-w-3xl">Temukan platform-platform terbaik di kategori {{ $category->name }} yang bisa Anda gunakan untuk mulai menghasilkan pendapatan dari internet.</p>
    </div>
</div>

<!-- Daftar Platform -->
<div class="bg-navy py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($platforms as $platform)
                <x-public.platform-card :platform="$platform" />
            @empty
                <div class="col-span-full text-center py-20 bg-navy-light rounded-xl border border-gray-border">
                    <svg class="mx-auto h-12 w-12 text-gray-soft mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-xl font-medium text-white mb-2">Belum Ada Platform</h3>
                    <p class="text-gray-soft">Kami sedang menyiapkan data platform untuk kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
