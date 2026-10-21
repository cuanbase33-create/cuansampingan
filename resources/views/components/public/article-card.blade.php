@props(['article'])
<article class="bg-navy-light rounded-xl overflow-hidden shadow-lg border border-gray-border hover:border-teal transition-colors duration-300 flex flex-col h-full">
    <a href="{{ route('artikel.show', $article->slug) }}" class="block aspect-w-16 aspect-h-9 overflow-hidden bg-navy">
        @if($article->thumbnail)
            <img src="{{ (Str::startsWith($article->thumbnail, 'http://') || Str::startsWith($article->thumbnail, 'https://')) ? $article->thumbnail : Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-48 flex items-center justify-center bg-navy border-b border-gray-border text-gray-500 text-sm">No Image</div>
        @endif
    </a>
    <div class="p-6 flex-grow flex flex-col">
        <div class="flex items-center space-x-2 mb-3">
            @if($article->category)
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-teal bg-opacity-20 text-teal">{{ $article->category->name }}</span>
            @endif
            <span class="text-xs text-gray-soft">{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
        </div>
        <h3 class="text-xl font-bold font-display text-white mb-2 leading-tight">
            <a href="{{ route('artikel.show', $article->slug) }}" class="hover:text-gold transition-colors">{{ $article->title }}</a>
        </h3>
        <p class="text-gray-soft text-sm line-clamp-2 mb-4">{{ $article->excerpt }}</p>
        <div class="mt-auto flex items-center text-xs text-gray-soft">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            {{ number_format($article->view_count) }} views
        </div>
    </div>
</article>
