@extends('layouts.public')

@section('meta_title', $article->meta_title ?: $article->title . ' - cuansampingan')
@section('meta_description', $article->meta_description ?: $article->excerpt)
@section('og_title', $article->title)
@section('og_description', $article->excerpt)
@if($article->thumbnail)
@section('og_image', (Str::startsWith($article->thumbnail, 'http://') || Str::startsWith($article->thumbnail, 'https://')) ? $article->thumbnail : asset(Storage::url($article->thumbnail)))
@endif

@section('content')
<div class="bg-navy py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Main Content (2/3) -->
            <article class="w-full lg:w-2/3">
                <header class="mb-10">
                    <div class="flex items-center space-x-2 mb-4">
                        @if($article->category)
                            <a href="{{ route('artikel.index', ['kategori' => $article->category->slug]) }}" class="px-3 py-1 text-xs font-medium rounded-full bg-teal bg-opacity-20 text-teal hover:bg-opacity-30 transition-colors">
                                {{ $article->category->name }}
                            </a>
                        @endif
                        <span class="text-sm text-gray-soft">{{ $article->published_at ? $article->published_at->format('d M Y') : '' }}</span>
                        <span class="text-sm text-gray-soft px-2">•</span>
                        <span class="text-sm text-gray-soft flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ number_format($article->view_count) }}
                        </span>
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl font-bold font-display text-white mb-8 leading-tight">{{ $article->title }}</h1>
                    
                    @if($article->thumbnail)
                        <div class="w-full rounded-2xl overflow-hidden aspect-w-16 aspect-h-9 bg-navy-light mb-10">
                            <img src="{{ (Str::startsWith($article->thumbnail, 'http://') || Str::startsWith($article->thumbnail, 'https://')) ? $article->thumbnail : Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                </header>

                <div class="prose prose-invert prose-lg max-w-none prose-a:text-teal hover:prose-a:text-gold prose-headings:font-display prose-headings:text-white prose-p:text-gray-300">
                    {!! $article->body !!}
                </div>
                
                <!-- Share / CTA (Optional) -->
                <div class="mt-12 pt-8 border-t border-gray-border">
                    <p class="text-lg font-medium text-white mb-4">Bagikan Artikel Ini</p>
                    <div class="flex space-x-4">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 bg-navy-light border border-gray-border hover:border-gold rounded-lg text-gray-300 hover:text-white transition-colors">Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 bg-navy-light border border-gray-border hover:border-gold rounded-lg text-gray-300 hover:text-white transition-colors">Facebook</a>
                    </div>
                </div>
                
                <!-- Related Articles -->
                @if($relatedArticles->count() > 0)
                <div class="mt-16">
                    <h3 class="text-2xl font-bold font-display text-white mb-6">Artikel Terkait</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($relatedArticles as $related)
                            <x-public.article-card :article="$related" />
                        @endforeach
                    </div>
                </div>
                @endif
            </article>
            
            <!-- Sidebar (1/3) -->
            <aside class="w-full lg:w-1/3">
                <div class="sticky top-24 space-y-8">
                    <!-- Artikel Terpopuler -->
                    <div class="bg-navy-light rounded-xl border border-gray-border p-6">
                        <h3 class="text-lg font-bold font-display text-white mb-6 flex items-center border-b border-gray-border pb-4">
                            <svg class="w-5 h-5 text-gold mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Terpopuler
                        </h3>
                        <div class="space-y-4">
                            @foreach($popularArticles as $pop)
                                <a href="{{ route('artikel.show', $pop->slug) }}" class="flex items-start group">
                                    <div class="w-16 h-16 rounded flex-shrink-0 bg-navy overflow-hidden">
                                        @if($pop->thumbnail)
                                            <img src="{{ (Str::startsWith($pop->thumbnail, 'http://') || Str::startsWith($pop->thumbnail, 'https://')) ? $pop->thumbnail : Storage::url($pop->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h4 class="text-sm font-medium text-white group-hover:text-gold transition-colors line-clamp-2 leading-snug">{{ $pop->title }}</h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Artikel Terbaru Sidebar -->
                    <div class="bg-navy-light rounded-xl border border-gray-border p-6">
                        <h3 class="text-lg font-bold font-display text-white mb-6 flex items-center border-b border-gray-border pb-4">
                            <svg class="w-5 h-5 text-teal mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Terbaru
                        </h3>
                        <div class="space-y-4">
                            @foreach($latestSidebarArticles as $latest)
                                <a href="{{ route('artikel.show', $latest->slug) }}" class="flex items-start group">
                                    <div class="w-16 h-16 rounded flex-shrink-0 bg-navy overflow-hidden">
                                        @if($latest->thumbnail)
                                            <img src="{{ (Str::startsWith($latest->thumbnail, 'http://') || Str::startsWith($latest->thumbnail, 'https://')) ? $latest->thumbnail : Storage::url($latest->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <h4 class="text-sm font-medium text-white group-hover:text-teal transition-colors line-clamp-2 leading-snug">{{ $latest->title }}</h4>
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
