@extends('layouts.app')

@section('title', 'Edit Layanan')

@section('content')
<div class="">
    <x-breadcrumb :items="[
        ['label' => 'Layanan', 'url' => route('service.index')],
        ['label' => 'Edit']
    ]" />

    <div class="mt-8">
        <form id="edit-layanan-form" action="{{ route('service.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Layanan Information -->
            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Layanan Information</h2>
                
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <x-input-label for="title" value="Judul *" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('title', $service->title ?? '')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="sort_order" value="Urutan *" />
                            <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full"
                                :value="old('sort_order', $service->sort_order ?? 1)" required min="1" />
                            <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                        </div>

                        <div class="flex items-center mt-6">
                            <label for="status" class="mr-2 text-sm text-gray-700">Active</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="status" value="inactive">
                                <input type="checkbox" id="status" name="status" value="active"
                                    {{ old('status', $service->status ?? 'active') === 'active' ? 'checked' : '' }}
                                    class="sr-only peer" />
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500 rounded-full peer peer-checked:bg-teal-600 transition-all duration-300"></div>
                                <div
                                    class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform duration-300 transform peer-checked:translate-x-full">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Description Textarea -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="description" value="Deskripsi *" />
                    <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="4" required>{{ old('description', $service->description ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Icon Upload with Preview -->
                <div class="grid grid-cols-1 space-y-2">
                    <x-input-label for="icon" value="Image *" />
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
                                class="hidden" aria-label="Upload icon image" />
                        </div>

                        <!-- Preview dibawah input -->
                        <div id="icon-preview" class="{{ $service->icon ? '' : 'hidden' }} w-32 h-32">
                            <img src="{{ $service->icon ? asset($service->icon) : '' }}" 
                                class="w-full h-full object-cover rounded-lg border border-gray-200" />
                        </div>
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
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
    // Icon Preview
    const iconUpload = document.getElementById('icon-upload');
    const iconPreview = document.getElementById('icon-preview');

    iconUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                iconPreview.querySelector('img').src = e.target.result;
                iconPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection