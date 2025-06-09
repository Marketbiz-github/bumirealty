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

        <!-- Right Side - Forgot Password Form -->
        <div class="w-full lg:w-2/3 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="mb-10 text-center">
                    <img src="{{ asset('/images/contents/bumirealty.png') }}" 
                         alt="BumiRealty Logo" 
                         class="h-12 mx-auto">
                </div>

                <div class="mb-6 text-gray-600">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
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
                                     autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('login') }}" 
                           class="text-sm text-teal-600 hover:text-teal-500">
                            {{ __('Back to login') }}
                        </a>
                        <x-primary-button class="bg-teal-600 hover:bg-teal-700">
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
