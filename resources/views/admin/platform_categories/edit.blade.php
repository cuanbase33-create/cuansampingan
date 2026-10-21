@extends('layouts.admin')

@section('title', 'Edit Kategori Platform')
@section('page_title', 'Edit Kategori Platform')

@section('content')
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 p-6 max-w-xl">
        <form action="{{ route('admin.platform-categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori Platform <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                @error('name')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug URL</label>
                <input type="text" value="{{ $category->slug }}" disabled class="w-full rounded-md border-gray-200 bg-gray-50 text-gray-500 font-mono shadow-sm">
                <p class="text-xs text-gray-400 mt-1">Slug otomatis disesuaikan dari nama kategori.</p>
            </div>

            <div class="mb-6">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil (Sort Order)</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">Angka lebih kecil akan tampil lebih dulu di navigasi dan halaman.</p>
                @error('sort_order')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.platform-categories.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded hover:bg-teal-dark transition">Perbarui Kategori</button>
            </div>
        </form>
    </div>
@endsection
