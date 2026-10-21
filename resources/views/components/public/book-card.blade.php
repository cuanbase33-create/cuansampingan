@props(['book'])
<div class="bg-navy-light rounded-xl overflow-hidden shadow-lg border border-gray-border hover:border-gold transition-colors duration-300 flex flex-col h-full">
    <div class="relative pt-[133%] bg-navy overflow-hidden">
        @if($book->cover_image)
            <img src="{{ (Str::startsWith($book->cover_image, 'http://') || Str::startsWith($book->cover_image, 'https://')) ? $book->cover_image : Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 w-full h-full object-cover">
        @else
            <div class="absolute inset-0 flex items-center justify-center text-gray-500">No Cover</div>
        @endif
        @if($book->category)
            <div class="absolute top-2 right-2">
                <span class="px-2 py-1 text-xs font-medium rounded-md bg-navy bg-opacity-80 text-gold border border-gold backdrop-blur-sm">{{ $book->category->name }}</span>
            </div>
        @endif
    </div>
    <div class="p-5 flex-grow flex flex-col">
        <h3 class="text-lg font-bold font-display text-white mb-2 leading-tight">{{ $book->title }}</h3>
        <p class="text-gray-soft text-sm line-clamp-3 mb-4">{{ $book->short_description }}</p>
        <div class="mt-auto">
            <a href="{{ $book->purchase_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-2 px-4 bg-teal hover:bg-teal-dark text-white font-semibold rounded-lg transition-colors">
                Beli Sekarang
            </a>
        </div>
    </div>
</div>
