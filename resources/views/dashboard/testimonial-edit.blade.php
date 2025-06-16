@extends('layouts.app')

@section('title', 'Edit Testimoni')

@section('content')
<div class="">
    <x-breadcrumb :items="[
        ['label' => 'Testimoni', 'url' => route('testimonial.index')],
        ['label' => 'Edit']
    ]" />

    <div class="mt-8">
        <form action="{{ route('testimonial.update', $testimonial->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Testimoni Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 space-y-2 gap-4">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Name *" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $testimonial->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="flex items-center space-x-2">
                        <label for="status" class="text-sm text-gray-700">Active</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="inactive">
                            <input type="checkbox" id="status" name="status" value="active"
                                {{ old('status', $testimonial->status) === 'active' ? 'checked' : '' }}
                                class="sr-only peer" />
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-teal-500 rounded-full peer peer-checked:bg-teal-600 transition-all duration-300"></div>
                            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border border-gray-300 rounded-full transition-transform duration-300 transform peer-checked:translate-x-full">
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Rating -->
                <div>
                    <x-input-label for="rating" value="Rating *" />
                    <select id="rating" name="rating" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                        required>
                        <option value="">Select Rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} {{ Str::plural('Star', $i) }}
                            </option>
                        @endfor
                    </select>
                    <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                </div>
                
                <!-- Message -->
                <div>
                    <x-input-label for="message" value="Message" />
                    <textarea id="message" name="message" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                        >{{ old('message', $testimonial->message) }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
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