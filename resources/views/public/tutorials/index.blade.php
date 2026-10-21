@extends('layouts.public')

@section('meta_title', 'Tutorial & Panduan Langkah demi Langkah - cuansampingan')
@section('meta_description', 'Kumpulan tutorial interaktif dan panduan mendalam untuk belajar menghasilkan uang secara online.')

@section('content')
<div class="bg-navy py-12 border-b border-gray-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold font-display text-white mb-4">Tutorial & Panduan</h1>
        <p class="text-gray-soft max-w-3xl mb-8">Pelajari cara kerja berbagai platform dan teknik menghasilkan pendapatan dari internet langkah demi langkah.</p>
        
        <!-- Filter Kategori -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('tutorial.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ !request()->has('kategori') ? 'bg-teal border-teal text-white' : 'bg-transparent border-gray-border text-gray-300 hover:border-teal hover:text-white' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('tutorial.index', ['kategori' => $cat->slug]) }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('kategori') == $cat->slug ? 'bg-teal border-teal text-white' : 'bg-transparent border-gray-border text-gray-300 hover:border-teal hover:text-white' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-navy py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Grid Tutorial Utama (2/3) -->
            <div class="w-full lg:w-2/3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @forelse($tutorials as $tutorial)
                        <x-public.tutorial-card :tutorial="$tutorial" />
                    @empty
                        <div class="col-span-full text-center py-20 bg-navy-light rounded-xl border border-gray-border">
                            <p class="text-gray-soft">Tidak ada tutorial ditemukan.</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-12">
                    {{ $tutorials->links() }}
                </div>
            </div>
            
            <!-- Sidebar (1/3) -->
            <aside class="w-full lg:w-1/3">
                <div class="sticky top-24 space-y-8">
                    <!-- Tutorial Terpopuler -->
                    <div class="bg-navy-light rounded-xl border border-gray-border p-6">
                        <h3 class="text-lg font-bold font-display text-white mb-6 flex items-center border-b border-gray-border pb-4">
                            <svg class="w-5 h-5 text-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Terpopuler
                        </h3>
                        <div class="space-y-4">
                            @foreach($popularTutorials as $pop)
                                <a href="{{ route('tutorial.show', $pop->slug) }}" class="flex items-start group">
                                    <div class="w-16 h-16 rounded flex-shrink-0 bg-navy overflow-hidden">
                                        @if($pop->thumbnail)
                                            <img src="{{ (Str::startsWith($pop->thumbnail, 'http://') || Str::startsWith($pop->thumbnail, 'https://')) ? $pop->thumbnail : Storage::url($pop->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h4 class="text-sm font-medium text-white group-hover:text-gold transition-colors line-clamp-2 leading-snug">{{ $pop->title }}</h4>
                                        <span class="text-xs text-gray-soft mt-1 block">{{ $pop->published_at ? $pop->published_at->format('d M Y') : '' }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Tutorial Terbaru Sidebar -->
                    <div class="bg-navy-light rounded-xl border border-gray-border p-6">
                        <h3 class="text-lg font-bold font-display text-white mb-6 flex items-center border-b border-gray-border pb-4">
                            <svg class="w-5 h-5 text-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Terbaru
                        </h3>
                        <div class="space-y-4">
                            @foreach($latestSidebarTutorials as $latest)
                                <a href="{{ route('tutorial.show', $latest->slug) }}" class="flex items-start group">
                                    <div class="w-16 h-16 rounded flex-shrink-0 bg-navy overflow-hidden">
                                        @if($latest->thumbnail)
                                            <img src="{{ (Str::startsWith($latest->thumbnail, 'http://') || Str::startsWith($latest->thumbnail, 'https://')) ? $latest->thumbnail : Storage::url($latest->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h4 class="text-sm font-medium text-white group-hover:text-teal transition-colors line-clamp-2 leading-snug">{{ $latest->title }}</h4>
                                        <span class="text-xs text-gray-soft mt-1 block">{{ $latest->published_at ? $latest->published_at->format('d M Y') : '' }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
