<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/3 relative border-r-8 border-gray-200">
            <img src="{{ asset('/images/contents/bg.png') }}" 
                 alt="Login Background" 
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50 p-8 flex items-end">
                {{-- empty --}}
            </div>
        </div>

        <!-- Right Side - Confirm Password Form -->
        <div class="w-full lg:w-2/3 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="mb-10 text-center">
                    <img src="{{ asset('/images/contents/bumirealty.png') }}" 
                         alt="BumiRealty Logo" 
                         class="h-12 mx-auto">
                </div>

                <div class="mb-6 text-gray-600">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" 
                                     class="block mt-1 w-full"
                                     type="password"
                                     name="password"
                                     required 
                                     autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center py-3 bg-teal-600 hover:bg-teal-700">
                            {{ __('Confirm') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
