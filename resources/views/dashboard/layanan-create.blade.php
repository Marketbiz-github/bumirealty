@extends('layouts.app')

@section('title', 'Create Layanan')

@section('content')
<div class="">
    <x-breadcrumb :items="[
        ['label' => 'Layanan', 'url' => route('service.index')],
        ['label' => 'Create']
    ]" />

    <div class="mt-8">
        <form id="create-layanan-form" action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Layanan Information -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Layanan Information</h2>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <x-input-label for="title" value="Judul" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="sort_order" value="Urutan" />
                        <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                            :value="old('sort_order', 1)" required min="1" />
                        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                    </div>
                </div>

                <!-- Add hidden input for status -->
                <input type="hidden" name="status" value="active">

                <!-- Description with TinyMCE -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="description" value="Deskripsi" />
                    <textarea id="description" name="description" class="hidden">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Icon Upload with Preview -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="icon" value="Icon" />
                    <div class="space-y-4">
                        <div class="flex items-center justify-center w-full">
                            <label for="icon-upload" class="flex flex-col w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 1MB</p>
                                </div>
                            </label>
                            <input id="icon-upload" type="file" name="icon" accept="image/png, image/jpeg"
                                class="hidden" aria-label="Upload icon image" required />
                        </div>

                        <!-- Preview dibawah input -->
                        <div id="icon-preview" class="hidden w-32 h-32">
                            <img src="" class="w-full h-full object-cover rounded-lg border border-gray-200" />
                        </div>
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <x-secondary-button onclick="history.back()">Cancel</x-secondary-button>
                <x-primary-button>Save</x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
<script>
    // TinyMCE Init
    tinymce.init({
        selector: '#description',
        height: 300,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    });

    // Icon Preview
    const iconUpload = document.getElementById('icon-upload');
    const iconPreview = document.getElementById('icon-preview');

    iconUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate size
            if (file.size > 1024 * 1024) {
                alert('File size should not exceed 1MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                iconPreview.querySelector('img').src = e.target.result;
                iconPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Form Validation
    document.getElementById('create-layanan-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Check icon
        if (!iconUpload.files[0]) {
            alert('Please select an icon image');
            return;
        }

        // Check description
        const description = tinymce.get('description').getContent();
        if (!description) {
            alert('Please fill in the description');
            return;
        }

        this.submit();
    });
</script>
@endsection