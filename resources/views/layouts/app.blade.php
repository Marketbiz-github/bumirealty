<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Dashboard - BumiRealty')</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/font.css') }}">
        <link rel="icon" type="image/png" href="{{ asset($settings['favicon'] ?? '/images/contents/favicon.ico') }}">
        <style>
            body {
                font-family: 'Poppins', Arial, sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Sidebar component - will be fixed on desktop, hidden on mobile -->
            <x-sidebar-dashboard />
            
            <!-- Main Content - will be pushed right on desktop, full width on mobile -->
            <div class="lg:pl-72">
                <main class="p-4 sm:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
