@extends('layouts.admin')

@section('title', 'Daftar Platform')
@section('page_title', 'Kelola Platform')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.platforms.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
            <select name="category" class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama platform..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-teal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </form>
        
        <a href="{{ route('admin.platforms.create') }}" class="bg-teal hover:bg-teal-dark text-white px-4 py-2 rounded shadow transition shrink-0">
            + Tambah Platform
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-success/10 border-l-4 border-success text-success-dark p-4 rounded" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 bg-danger/10 border-l-4 border-danger text-danger-dark p-4 rounded" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo & Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sort</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($platforms as $platform)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200 bg-white p-1" src="{{ (Str::startsWith($platform->logo, 'http://') || Str::startsWith($platform->logo, 'https://')) ? $platform->logo : asset($platform->logo) }}" alt="{{ $platform->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><a href="{{ $platform->access_url }}" target="_blank" rel="noopener noreferrer" class="hover:text-teal">{{ $platform->name }}</a></div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($platform->short_description, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div class="flex flex-wrap gap-1">
                                @forelse($platform->categories as $cat)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-teal/10 text-teal-dark font-medium">
                                        {{ $cat->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($platform->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-success/10 text-success">Aktif</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-danger/10 text-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $platform->sort_order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.platforms.edit', $platform) }}" class="text-teal hover:text-teal-dark mr-3">Edit</a>
                            <form action="{{ route('admin.platforms.destroy', $platform) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus platform ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada platform yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $platforms->withQueryString()->links() }}
    </div>
@endsection
