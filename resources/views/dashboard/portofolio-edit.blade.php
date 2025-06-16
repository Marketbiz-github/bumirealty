@extends('layouts.app')

@section('title', 'Edit Portofolio')

@section('content')
<div class="">
    <x-breadcrumb :items=" [
        ['label' => 'Portofolio', 'url' => route('portofolio.index')],
        ['label' => 'Edit']
    ]" />

    <div class="mt-8">
        <form action="{{ route('portofolio.update', $portofolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="deleted_images" id="deleted-images">

            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Portofolio Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 space-y-2 gap-4">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Name *" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                            :value="old('name', $portofolio->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="flex items-center space-x-2">
                        <x-input-label for="status" value="Status" class="mb-0" />
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="inactive">
                            <input type="checkbox" id="status" name="status" value="active" 
                                {{ old('status', $portofolio->status) === 'active' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500 rounded-full peer peer-checked:bg-teal-600"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform duration-300 peer-checked:translate-x-full"></div>
                        </label>
                    </div>
                 </div>

                <!-- Description -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="description" value="Description *" />
                    <textarea id="description" name="description" class="hidden">{{ old('description', $portofolio->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Thumbnail -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="thumbnail" value="Thumbnail Image" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="thumbnail-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Change Thumbnail</span></p>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 1MB</p>
                                </div>
                            </label>
                            <input id="thumbnail-upload" type="file" name="thumbnail" 
                                accept="image/png, image/jpeg"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload thumbnail image" />
                        </div>
                        <div id="thumbnail-preview" class="{{ $portofolio->thumbnail ? '' : 'hidden' }}">
                            <div class="relative w-40 h-40 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ $portofolio->thumbnail ? asset($portofolio->thumbnail->url) : '' }}" 
                                    class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition-all flex items-center justify-center">
                                    <button type="button" id="remove-thumbnail" class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>
                </div>

                <!-- Additional Images -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="image" value="Additional Images" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="image-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Add More Images</span></p>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB each (Max 5 images total)</p>
                                </div>
                            </label>
                            <input id="image-upload" type="file" name="images[]" multiple 
                                accept="image/png, image/jpeg"
                                style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0;"
                                aria-label="Upload additional images" />
                        </div>
                        <div id="image-preview" class="grid grid-cols-2 gap-4 md:grid-cols-5">
                            @foreach($portofolio->images as $image)
                                <div class="relative group aspect-square rounded-lg overflow-hidden bg-gray-100" data-media-id="{{ $image->id }}">
                                    <img src="{{ asset($image->url) }}" class="w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                                        <button type="button" class="delete-image p-2 bg-red-500 rounded-full text-white hover:bg-red-600 focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
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
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // TinyMCE Init
    tinymce.init({
        selector: '#description',
        height: 300,
        plugins: ['lists', 'link'],
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist'
    });

    let deletedImages = [];
    let currentImages = {{ count($portofolio->images) }};
    const maxImages = 5;
    let uploadedFiles = new Set(); // Track unique files

    // Handle existing image deletion
    document.querySelectorAll('.delete-image').forEach(btn => {
        btn.addEventListener('click', function() {
            const wrapper = this.closest('[data-media-id]');
            const mediaId = wrapper.dataset.mediaId;
            deletedImages.push(mediaId);
            
            // Update the hidden input with JSON string of deleted image IDs
            document.getElementById('deleted-images').value = JSON.stringify(deletedImages);

            wrapper.remove();
            currentImages--;
        });
    });

    // Image Upload Handler
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');

    imageUpload?.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        if (files.length + currentImages > maxImages) {
            alert(`Maximum ${maxImages} images allowed`);
            return;
        }

        files.forEach((file, index) => {
            // Check if file is already uploaded
            const fileId = `${file.name}-${file.size}`;
            if (uploadedFiles.has(fileId)) {
                return; // Skip duplicate file
            }
            uploadedFiles.add(fileId);

            if (file.size > 2 * 1024 * 1024) {
                alert(`File "${file.name}" exceeds 2MB size limit`);
                return;
            }

            // Create new file input for each image
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = `images[]`;
            newInput.style.display = 'none';
            
            // Create a new File object from the original file
            const container = new DataTransfer();
            container.items.add(file);
            newInput.files = container.files;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group aspect-square rounded-lg overflow-hidden bg-gray-100';
                wrapper.dataset.fileId = fileId; // Add file identifier to wrapper
                wrapper.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                        <button type="button" class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" name="image_order[]" value="${currentImages}">
                `;
                
                wrapper.appendChild(newInput);
                
                wrapper.querySelector('button').onclick = () => {
                    uploadedFiles.delete(fileId); // Remove from tracking Set
                    wrapper.remove();
                    currentImages--;
                    updateImageOrder();
                };

                imagePreview.appendChild(wrapper);
                currentImages++;
            };
            reader.readAsDataURL(file);
        });

        // Clear input to allow selecting same files again
        this.value = '';
    });

    // Update image order function
    function updateImageOrder() {
        const inputs = imagePreview.querySelectorAll('input[name="image_order[]"]');
        inputs.forEach((input, index) => {
            input.value = index;
        });
    }

    // Thumbnail handlers
    const thumbnailUpload = document.getElementById('thumbnail-upload');
    const thumbnailPreview = document.getElementById('thumbnail-preview');
    const removeThumbnailBtn = document.getElementById('remove-thumbnail');

    thumbnailUpload?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file.size > 1024 * 1024) {
            alert('Thumbnail size should not exceed 1MB');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            thumbnailPreview.querySelector('img').src = e.target.result;
            thumbnailPreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    removeThumbnailBtn?.addEventListener('click', function() {
        thumbnailPreview.classList.add('hidden');
        thumbnailUpload.value = '';
        if (document.querySelector('input[name="delete_thumbnail"]')) {
            document.querySelector('input[name="delete_thumbnail"]').value = "1";
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!tinymce.get('description').getContent()) {
            e.preventDefault();
            alert('Please enter a description');
        }
    });
});
</script>
@endsection