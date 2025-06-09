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

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-2/3 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="mb-10 text-center">
                    <img src="{{ asset('/images/contents/bumirealty.png') }}" 
                         alt="BumiRealty Logo" 
                         class="h-12 mx-auto">
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" 
                                     class="block mt-1 w-full" 
                                     type="email" 
                                     name="email" 
                                     :value="old('email')" 
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
                                     autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me and Forgot Password -->
                    <div class="mt-4 flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" 
                                   name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-teal-600 hover:text-teal-500" 
                               href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center py-3 bg-teal-600 hover:bg-teal-700">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
