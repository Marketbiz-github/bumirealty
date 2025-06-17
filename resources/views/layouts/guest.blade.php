<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'BumiRealty')</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/font.css') }}">
        <link rel="icon" type="image/png" href="{{ asset($settings['favicon'] ?? '/images/contents/favicon.ico') }}">
        <style>
            body {
                font-family: 'Poppins', Arial, sans-serif;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased">
        {{ $slot }}
    </body>
</html>
