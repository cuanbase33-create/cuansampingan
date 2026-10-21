@props(['resource'])
<div class="bg-navy-light rounded-xl overflow-hidden shadow-lg border border-gray-border hover:border-teal transition-colors duration-300 flex flex-col h-full">
    <div class="h-40 bg-navy overflow-hidden relative">
        @if($resource->cover_image)
            <img src="{{ (Str::startsWith($resource->cover_image, 'http://') || Str::startsWith($resource->cover_image, 'https://')) ? $resource->cover_image : Storage::url($resource->cover_image) }}" alt="{{ $resource->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-500">No Image</div>
        @endif
        @if($resource->category)
            <div class="absolute top-2 left-2">
                <span class="px-2 py-1 text-xs font-medium rounded-md bg-navy bg-opacity-80 text-white backdrop-blur-sm">{{ $resource->category->name }}</span>
            </div>
        @endif
    </div>
    <div class="p-5 flex-grow flex flex-col">
        <h3 class="text-lg font-bold font-display text-white mb-2 leading-tight">{{ $resource->title }}</h3>
        <p class="text-gray-soft text-sm line-clamp-3 mb-4">{{ $resource->short_description }}</p>
        <div class="mt-auto">
            <a href="{{ $resource->access_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-2 px-4 bg-transparent border border-teal text-teal hover:bg-teal hover:text-white font-semibold rounded-lg transition-colors">
                Akses Gratis
            </a>
        </div>
    </div>
</div>
