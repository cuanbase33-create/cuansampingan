@extends('layouts.admin')

@section('title', 'Edit Bacaan')
@section('page_title', 'Edit Bacaan Rekomendasi')

@section('content')
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 p-6 max-w-3xl">
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku/Bacaan <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    @error('title')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-danger">*</span></label>
                    <select id="content_category_id" name="content_category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('content_category_id', $book->content_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('content_category_id')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="purchase_url" class="block text-sm font-medium text-gray-700 mb-1">URL / Link Pembelian <span class="text-danger">*</span></label>
                <input type="url" id="purchase_url" name="purchase_url" value="{{ old('purchase_url', $book->purchase_url) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                @error('purchase_url')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat <span class="text-danger">*</span></label>
                <textarea id="short_description" name="short_description" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">{{ old('short_description', $book->short_description) }}</textarea>
                @error('short_description')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Buku URL</label>
                    <div class="flex flex-col gap-2 mt-1">
                        @if($book->cover_image)
                            <img src="{{ (Str::startsWith($book->cover_image, 'http://') || Str::startsWith($book->cover_image, 'https://')) ? $book->cover_image : asset($book->cover_image) }}" alt="Current Cover" class="h-24 w-16 object-cover rounded-md border border-gray-200">
                        @endif
                        <input type="url" id="cover_image" name="cover_image" value="{{ old('cover_image', $book->cover_image) }}" placeholder="https://..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    </div>
                    @error('cover_image')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Urutan (Sort Order)</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $book->sort_order) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    </div>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $book->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-teal shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 h-5 w-5">
                        <label for="is_published" class="ml-2 block text-sm text-gray-900">Tayangkan (Aktif)</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded hover:bg-teal-dark transition">Update Bacaan</button>
            </div>
        </form>
    </div>
@endsection
