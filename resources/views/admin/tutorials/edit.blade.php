@extends('layouts.admin')

@section('title', 'Edit Tutorial')
@section('page_title', 'Edit Tutorial: ' . Str::limit($tutorial->title, 40))

@section('content')
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 p-6">
        <form action="{{ route('admin.tutorials.update', $tutorial) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tutorial <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $tutorial->title) }}" required class="w-full text-lg rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 font-semibold font-display text-gray-900">
                        @error('title')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Isi Tutorial <span class="text-danger">*</span></label>
                        <textarea id="body" name="body" class="w-full">{{ old('body', $tutorial->body) }}</textarea>
                        @error('body')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan (Excerpt)</label>
                        <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 text-sm">{{ old('excerpt', $tutorial->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sidebar Area -->
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3 border-b pb-2">Pengaturan Publikasi</h3>
                        
                        <div class="mb-4">
                            <label for="content_category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-danger">*</span></label>
                            <select id="content_category_id" name="content_category_id" required class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('content_category_id', $tutorial->content_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('content_category_id')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center mb-2">
                            <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $tutorial->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-teal shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 h-5 w-5">
                            <label for="is_published" class="ml-2 block text-sm font-medium text-gray-900">Tayangkan Tutorial</label>
                        </div>
                        
                        @if($tutorial->is_published && $tutorial->published_at)
                            <p class="text-xs text-gray-500 mb-4">Tayang sejak: {{ $tutorial->published_at->format('d M Y H:i') }}</p>
                        @else
                            <p class="text-xs text-gray-500 mb-4">Status saat ini: Draft</p>
                        @endif

                        <button type="submit" class="w-full px-4 py-2 bg-teal text-white rounded hover:bg-teal-dark transition font-medium">
                            Update Tutorial
                        </button>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3 border-b pb-2">Media</h3>
                        
                        <div>
                            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail URL</label>
                            
                            <div class="flex flex-col gap-2 mt-1">
                                @if($tutorial->thumbnail)
                                    <div class="mb-1">
                                        <img src="{{ (Str::startsWith($tutorial->thumbnail, 'http://') || Str::startsWith($tutorial->thumbnail, 'https://')) ? $tutorial->thumbnail : Storage::url($tutorial->thumbnail) }}" alt="Current Thumbnail" class="w-full h-auto rounded border border-gray-200">
                                    </div>
                                @endif
                                <input type="url" id="thumbnail" name="thumbnail" value="{{ old('thumbnail', $tutorial->thumbnail) }}" placeholder="https://..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50 text-sm">
                            </div>
                            @error('thumbnail')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3 border-b pb-2">SEO (Meta Tags)</h3>
                        
                        <div class="mb-3">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $tutorial->meta_title) }}" placeholder="Maks. 60 karakter" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" placeholder="Maks. 160 karakter" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-teal focus:ring focus:ring-teal focus:ring-opacity-50">{{ old('meta_description', $tutorial->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<style>
    .ck-editor__editable_inline {
        min-height: 400px;
        color: #1e293b;
    }
</style>
<script>
    ClassicEditor
        .create(document.querySelector('#body'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
