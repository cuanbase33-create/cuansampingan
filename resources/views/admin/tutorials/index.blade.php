@extends('layouts.admin')

@section('title', 'Daftar Tutorial')
@section('page_title', 'Kelola Tutorial')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.tutorials.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
            <select name="category" class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul tutorial..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-teal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </form>
        
        <a href="{{ route('admin.tutorials.create') }}" class="bg-teal hover:bg-teal-dark text-white px-4 py-2 rounded shadow transition shrink-0">
            + Tulis Tutorial
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-success/10 border-l-4 border-success text-success-dark p-4 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul & Thumbnail</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tutorials as $tutorial)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-20">
                                    @if($tutorial->thumbnail)
                                        <img class="h-12 w-20 rounded object-cover border border-gray-200 bg-gray-50" src="{{ (Str::startsWith($tutorial->thumbnail, 'http://') || Str::startsWith($tutorial->thumbnail, 'https://')) ? $tutorial->thumbnail : Storage::url($tutorial->thumbnail) }}" alt="{{ $tutorial->title }}">
                                    @else
                                        <div class="h-12 w-20 rounded bg-gray-200 flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 truncate max-w-xs" title="{{ $tutorial->title }}">{{ $tutorial->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $tutorial->created_at->format('d M Y, H:i') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $tutorial->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($tutorial->is_published)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-success/10 text-success">Tayang</span>
                                <div class="text-xs text-gray-500 mt-1">{{ $tutorial->published_at ? $tutorial->published_at->format('d M Y') : '-' }}</div>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($tutorial->view_count) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.tutorials.edit', $tutorial) }}" class="text-teal hover:text-teal-dark mr-3">Edit</a>
                            <form action="{{ route('admin.tutorials.destroy', $tutorial) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tutorial ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada tutorial yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $tutorials->withQueryString()->links() }}
    </div>
@endsection
