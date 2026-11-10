@extends('layouts.public')

@section('meta_title', 'Bacaan Rekomendasi - cuansampingan')
@section('meta_description', 'Koleksi buku dan bacaan pilihan untuk meningkatkan mindset bisnis dan karir Anda.')

@section('content')
<div class="bg-navy-light border-b border-gray-border pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold font-display text-white mb-4">Bacaan Rekomendasi</h1>
        <p class="text-gray-soft max-w-3xl mb-8">Kumpulan buku terbaik yang kami rekomendasikan untuk membantu perjalanan finansial dan bisnis online Anda.</p>
        
        <!-- Filter Kategori -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('bacaan.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ !request()->has('kategori') ? 'bg-gold border-gold text-navy' : 'bg-transparent border-gray-border text-gray-300 hover:border-gold hover:text-white' }}">
                Semua Buku
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('bacaan.index', ['kategori' => $cat->slug]) }}" class="px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('kategori') == $cat->slug ? 'bg-gold border-gold text-navy' : 'bg-transparent border-gray-border text-gray-300 hover:border-gold hover:text-white' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-navy py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($books as $book)
                <x-public.book-card :book="$book" />
            @empty
                <div class="col-span-full text-center py-20 bg-navy-light rounded-xl border border-gray-border">
                    <svg class="mx-auto h-12 w-12 text-gray-soft mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <h3 class="text-xl font-medium text-white mb-2">Belum Ada Bacaan</h3>
                    <p class="text-gray-soft">Kami sedang menyiapkan rekomendasi bacaan terbaik.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
