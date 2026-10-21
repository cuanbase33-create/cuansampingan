@props(['platform'])
<div class="bg-navy-light rounded-xl overflow-hidden shadow-lg border border-gray-border hover:border-gold transition-colors duration-300 flex flex-col h-full p-6">
    <!-- 1. Nama Website -->
    <h3 class="text-xl font-bold font-display text-white mb-4">
        <a href="{{ $platform->access_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-gold transition-colors">{{ $platform->name }}</a>
    </h3>

    <!-- 2. Logo Full Satu Row -->
    <div class="w-full h-40 rounded-lg bg-white flex items-center justify-center overflow-hidden border border-gray-border mb-4 p-4">
        @if($platform->logo)
            <img src="{{ (Str::startsWith($platform->logo, 'http://') || Str::startsWith($platform->logo, 'https://')) ? $platform->logo : Storage::url($platform->logo) }}" alt="{{ $platform->name }}" class="max-h-full max-w-full object-contain">
        @else
            <span class="text-4xl font-bold text-navy">{{ substr($platform->name, 0, 1) }}</span>
        @endif
    </div>

    <!-- 3. Kategori (Bisa lebih dari 1) -->
    <div class="mb-3 flex flex-wrap gap-1.5">
        @if($platform->categories->count() > 0)
            @foreach($platform->categories as $category)
                <a href="{{ route('platform.show', $category->slug) }}" class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full bg-teal/20 text-teal border border-teal/30 hover:border-gold hover:text-gold transition">
                    {{ $category->name }}
                </a>
            @endforeach
        @elseif($platform->category)
            <a href="{{ route('platform.show', $platform->category->slug) }}" class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full bg-teal/20 text-teal border border-teal/30 hover:border-gold hover:text-gold transition">
                {{ $platform->category->name }}
            </a>
        @else
            <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full bg-teal/20 text-teal border border-teal/30">Platform</span>
        @endif
    </div>

    <!-- 4. Deskripsi maksimal 200 karakter -->
    <p class="text-gray-soft text-sm mb-6 flex-grow leading-relaxed">{{ Str::limit($platform->short_description, 200) }}</p>

    <!-- 5. Link (Kunjungi Platform) -->
    <div class="mt-auto">
        <a href="{{ $platform->access_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center py-2.5 px-4 bg-gold hover:bg-gold-dark text-navy font-bold rounded-lg transition-colors shadow-md">
            Kunjungi Platform
        </a>
    </div>
</div>
