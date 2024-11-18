@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('pictures/app_icon.png') }}" type="image/png">

        <title>
            @if(isset($title))
                {{ $title . " - FoodIngre" }}
            @else
                {{ config('app.name', 'Laravel') }}
            @endif
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        {{-- Icons --}}
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased flex flex-col min-h-screen h-full">
        <nav class="sticky top-0" style="z-index: 20">
            <x-original-layout.navigation-bar />
        </nav>
        <x-status-message />
        <main>
            {{ $slot }}
        </main>
        <footer class="mt-auto">
            <x-original-layout.footer />
        </footer>
    </body>
</html>