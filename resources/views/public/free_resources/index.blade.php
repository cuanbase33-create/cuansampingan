@extends('layouts.public')

@section('meta_title', 'Free Resources - cuansampingan')
@section('meta_description', 'Kumpulan sumber daya gratis yang dapat Anda manfaatkan untuk mendukung produktivitas dan bisnis.')

@section('content')
<div class="bg-navy-light border-b border-gray-border pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold font-display text-white mb-4">Free Resources</h1>
        <p class="text-gray-soft max-w-3xl mb-8">Kumpulan tools, template, dan sumber daya gratis yang siap Anda gunakan untuk memulai atau mengembangkan bisnis online.</p>
        
        <!-- Filter Kategori -->
        <div class="flex overflow-x-auto pb-4 hide-scrollbar space-x-2">
            <a href="{{ route('free-resources.index') }}" class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ !request()->has('kategori') ? 'bg-teal border-teal text-white' : 'bg-transparent border-gray-border text-gray-300 hover:border-teal hover:text-white' }}">
                Semua Resources
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('free-resources.index', ['kategori' => $cat->slug]) }}" class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition-colors border {{ request('kategori') == $cat->slug ? 'bg-teal border-teal text-white' : 'bg-transparent border-gray-border text-gray-300 hover:border-teal hover:text-white' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-navy py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($resources as $resource)
                <x-public.resource-card :resource="$resource" />
            @empty
                <div class="col-span-full text-center py-20 bg-navy-light rounded-xl border border-gray-border">
                    <p class="text-gray-soft">Tidak ada resource yang ditemukan.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $resources->links() }}
        </div>
    </div>
</div>
@endsection
