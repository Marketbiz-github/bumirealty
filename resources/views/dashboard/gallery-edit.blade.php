@extends('layouts.app')

@section('title', 'Edit Galeri')

@section('content')
<div class="">
    <x-breadcrumb :items="[
        ['label' => 'Galeri', 'url' => route('gallery.index')],
        ['label' => 'Edit']
    ]" />

    <div class="mt-8">
        <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Galeri Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Nama *" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                            :value="old('name', $gallery->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="flex items-center space-x-2">
                        <x-input-label for="status" value="Status" class="mb-0" />
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="inactive">
                            <input type="checkbox" id="status" name="status" value="active" 
                                {{ old('status', $gallery->status) === 'active' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500 rounded-full peer peer-checked:bg-teal-600"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform duration-300 peer-checked:translate-x-full"></div>
                        </label>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="image" value="Image" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="image-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Change Image</span></p>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                </div>
                            </label>
                            <input id="image-upload" type="file" name="image" 
                                accept="image/png, image/jpeg"
                                class="hidden" />
                        </div>
                        <div id="image-preview" class="{{ $gallery->url ? '' : 'hidden' }}">
                            <div class="relative w-40 h-40 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ $gallery->url }}" class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition-all flex items-center justify-center">
                                    <button type="button" id="remove-image" class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <x-secondary-button onclick="history.back()">Cancel</x-secondary-button>
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');
    const removeImageBtn = document.getElementById('remove-image');
    let originalImageUrl = '{{ $gallery->url }}';

    imageUpload?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size should not exceed 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn?.addEventListener('click', function() {
        if (imageUpload.value) {
            imageUpload.value = '';
            imagePreview.querySelector('img').src = originalImageUrl;
        }
    });
});
</script>
@endsection