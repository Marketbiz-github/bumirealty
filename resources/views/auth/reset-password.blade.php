<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Image -->
        <div class="hidden lg:block lg:w-1/3 relative border-r-8 border-gray-200">
            <img src="{{ asset('/images/contents/bg.png') }}" 
                 alt="Reset Password Background" 
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50 p-8 flex items-end">
                {{-- empty --}}
            </div>
        </div>

        <!-- Right Side - Reset Password Form -->
        <div class="w-full lg:w-2/3 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="mb-10 text-center">
                    <img src="{{ asset('/images/contents/bumirealty.png') }}" 
                         alt="BumiRealty Logo" 
                         class="h-12 mx-auto">
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" 
                                     class="block mt-1 w-full" 
                                     type="email" 
                                     name="email" 
                                     :value="old('email', $request->email)" 
                                     required 
                                     autofocus 
                                     autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" 
                                     class="block mt-1 w-full" 
                                     type="password" 
                                     name="password" 
                                     required 
                                     autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" 
                                     class="block mt-1 w-full"
                                     type="password"
                                     name="password_confirmation" 
                                     required 
                                     autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('login') }}" 
                           class="text-sm text-teal-600 hover:text-teal-500">
                            {{ __('Back to login') }}
                        </a>
                        <x-primary-button class="bg-teal-600 hover:bg-teal-700">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
