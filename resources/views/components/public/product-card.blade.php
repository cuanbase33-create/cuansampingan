@props(['product'])
<div class="bg-navy-light rounded-xl overflow-hidden shadow-lg border border-gray-border hover:border-gold transition-colors duration-300 flex flex-col h-full">
    <div class="h-48 bg-navy overflow-hidden relative">
        @if($product->cover_image)
            <img src="{{ (Str::startsWith($product->cover_image, 'http://') || Str::startsWith($product->cover_image, 'https://')) ? $product->cover_image : Storage::url($product->cover_image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-500">No Image</div>
        @endif
        @if($product->category)
            <div class="absolute top-2 right-2">
                <span class="px-2 py-1 text-xs font-medium rounded-md bg-gold text-navy font-bold shadow-md">{{ $product->category->name }}</span>
            </div>
        @endif
    </div>
    <div class="p-5 flex-grow flex flex-col">
        <h3 class="text-lg font-bold font-display text-white mb-2 leading-tight">{{ $product->title }}</h3>
        <p class="text-gray-soft text-sm line-clamp-3 mb-4">{{ $product->short_description }}</p>
        <div class="mt-auto">
            <a href="{{ $product->purchase_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-2 px-4 bg-gold hover:bg-gold-dark text-navy font-bold rounded-lg transition-colors">
                Dapatkan Sekarang
            </a>
        </div>
    </div>
</div>
