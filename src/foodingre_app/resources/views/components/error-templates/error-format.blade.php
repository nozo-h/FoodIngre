@props(['statusMessage', 'statusCode'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $statusMessage ?? "ページが表示できません" }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-green-200 font-sans text-gray-700 antialiased flex flex-col min-h-screen h-full">
        <main>
            <div class="flex justify-center mt-60 mb-60 xl:mt-72">
                <div class="flex flex-col items-center">
                    <div class="flex">
                        <h1 class="text-3xl md:text-5xl">FoodIngre</h1>
                        <p class="ml-4 text-3xl md:text-5xl">|</p>
                        <p class="ml-4 text-3xl md:text-5xl">{{ $statusCode }}</p>
                    </div>
                    <p class="mt-4 text-xl md:text-2xl text-center">{{ $statusMessage }}</p>
                </div>
            </div>
        </main>
        <footer class="mt-auto">
            <x-error-templates.footer />
        </footer>
    </body>
</html>