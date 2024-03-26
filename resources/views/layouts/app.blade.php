<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css']) <!-- 'resources/js/app.js'  -->

    @stack('css')
</head>
<body>
<div class="min-h-full">
    <nav class="bg-indigo-600">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img
                            class="h-32 w-32 rounded-lg"
                            src="/logo.png"
                            alt="WINGIE - ENUYGUN" />
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</div>

    @stack('js')
</body>
</html>
