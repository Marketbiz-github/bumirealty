@extends('layouts.app')

@section('title', 'Create Testimonial')

@section('content')
<div class="">
    <x-breadcrumb :items="[
        ['label' => 'Testimonials', 'url' => route('testimonial.index')],
        ['label' => 'Create']
    ]" />

    <div class="mt-8">
        <form action="{{ route('testimonial.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white rounded-lg shadow p-6 space-y-5">
                <h2 class="text-lg font-medium text-gray-900">Testimonial Information</h2>
                
                <!-- Name -->
                <div>
                    <x-input-label for="name" value="Name *" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Rating -->
                <div>
                    <x-input-label for="rating" value="Rating *" />
                    <select id="rating" name="rating" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                        required>
                        <option value="">Select Rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
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
                        >{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
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