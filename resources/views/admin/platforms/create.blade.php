@extends('layouts.admin')

@section('title', 'Tambah Platform')
@section('page_title', 'Tambah Platform Baru')

@section('content')
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 p-6 max-w-3xl">
        <form action="{{ route('admin.platforms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Platform <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Toluna, Fiverr" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    @error('name')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Platform <span class="text-danger">*</span> (Bisa pilih lebih dari 1)</label>
                    <div class="border border-gray-300 rounded-md p-3 max-h-48 overflow-y-auto space-y-2 bg-gray-50/50">
                        @foreach($categories as $category)
                            <label class="flex items-center space-x-2 text-sm text-gray-700 hover:text-navy cursor-pointer">
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-teal focus:ring-teal h-4 w-4">
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('category_ids')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="access_url" class="block text-sm font-medium text-gray-700 mb-1">URL / Link Akses <span class="text-danger">*</span></label>
                <input type="url" id="access_url" name="access_url" value="{{ old('access_url') }}" required placeholder="https://..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                @error('access_url')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat <span class="text-danger">*</span></label>
                <textarea id="short_description" name="short_description" rows="3" required maxlength="200" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">{{ old('short_description') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Maksimal 200 karakter.</p>
                @error('short_description')
                    <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo URL <span class="text-danger">*</span></label>
                    <input type="url" id="logo" name="logo" value="{{ old('logo') }}" required placeholder="https://..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    <p class="text-xs text-gray-500 mt-1">Masukkan link URL gambar logo platform.</p>
                    @error('logo')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Urutan (Sort Order)</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                    </div>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-teal shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 h-5 w-5">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif (Tampil di website)</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.platforms.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded hover:bg-teal-dark transition">Simpan Platform</button>
            </div>
        </form>
    </div>
@endsection
