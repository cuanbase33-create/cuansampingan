@extends('layouts.admin')

@section('title', 'Tambah Free Resource')
@section('page_title', 'Tambah Free Resource Baru')

@section('content')
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 p-6 max-w-3xl">
        <form action="{{ route('admin.free-resources.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Resource <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    @error('title')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-danger">*</span></label>
                    <select id="content_category_id" name="content_category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('content_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('content_category_id')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="access_url" class="block text-sm font-medium text-gray-700 mb-1">URL / Link File <span class="text-danger">*</span></label>
                <input type="url" id="access_url" name="access_url" value="{{ old('access_url') }}" required placeholder="https://..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">Masukkan link Google Drive, Dropbox, MediaFire, dsb.</p>
                @error('access_url')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-danger">*</span></label>
                <textarea id="short_description" name="short_description" rows="4" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">{{ old('short_description') }}</textarea>
                @error('short_description')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail URL</label>
                    <input type="url" id="cover_image" name="cover_image" value="{{ old('cover_image') }}" placeholder="https://..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    <p class="text-xs text-gray-500 mt-1">Masukkan link URL gambar thumbnail.</p>
                    @error('cover_image')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center mt-2 md:mt-8">
                    <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded border-gray-300 text-teal shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 h-5 w-5">
                    <label for="is_published" class="ml-2 block text-sm text-gray-900">Tayangkan (Aktif)</label>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.free-resources.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded hover:bg-teal-dark transition">Simpan Resource</button>
            </div>
        </form>
    </div>
@endsection
