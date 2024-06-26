<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/dde6cacc9b.js" crossorigin="anonymous"></script>

        <!-- this is going to be used by the livewire charts component to include the chart.js library -->
        @yield('custom-css')

        @livewireStyles

        <!-- Scripts -->
        @vite('resources/css/app.css')

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{--make a container with max width of 7xl and padding of 6--}}
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScripts
        @vite('resources/js/app.js')
    </body>
</html>
