<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $settings['meta_title'] ?? $settings['site_title'] ?? 'BumiRealty' }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '' }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $settings['og_title'] ?? $settings['meta_title'] ?? $settings['site_title'] ?? 'BumiRealty' }}">
    <meta property="og:description" content="{{ $settings['og_description'] ?? $settings['meta_description'] ?? '' }}">
    <meta property="og:image" content="{{ asset($settings['og_image'] ?? '/images/contents/bumirealty.png') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $settings['site_title'] ?? 'BumiRealty' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings['twitter_title'] ?? $settings['meta_title'] ?? $settings['site_title'] ?? 'BumiRealty' }}">
    <meta name="twitter:description" content="{{ $settings['twitter_description'] ?? $settings['meta_description'] ?? '' }}">
    <meta name="twitter:image" content="{{ asset($settings['twitter_image'] ?? $settings['og_image'] ?? '/images/contents/bumirealty.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon'] ?? '/images/contents/favicon.ico') }}">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    @include('components.navbar')

    @yield('content')
    
    <!-- CTA Section -->
    @include('components.cta')
    <!-- Footer -->
    @include('components.footer')

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890" target="_blank"
    class="fixed bottom-20 right-4 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition z-40 flex items-center justify-center"
    title="Chat via WhatsApp">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.52 3.48A12 12 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.17 1.6 6.01L0 24l6.18-1.62A11.94 11.94 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22c-1.85 0-3.68-.5-5.26-1.44l-.38-.22-3.67.96.98-3.58-.25-.37A9.94 9.94 0 0 1 2 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.2-7.8c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.41-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.12-.12.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.83-2.01-.22-.54-.44-.47-.61-.48-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.32s.99 2.69 1.13 2.88c.14.18 1.95 2.98 4.73 4.06.66.23 1.18.37 1.58.47.66.17 1.26.15 1.73.09.53-.08 1.65-.67 1.89-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.18-.53-.32z"/>
        </svg>
    </a>

    <!-- Scroll to Top Button -->
    <button 
        x-data="{ show: false }" 
        x-show="show"
        x-transition
        @scroll.window="show = window.pageYOffset > 500"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-4 right-4 bg-teal-600 text-white p-3 rounded-full shadow-lg hover:bg-teal-700 transition z-40"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    @yield('scripts')
</body>
</html>