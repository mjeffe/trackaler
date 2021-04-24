<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        @auth
        <!-- script src="https://code.highcharts.com/highcharts.src.js"></script -->
        <script src="{{ asset('js/highcharts-9.0.1.js') }}"></script>
        @endauth
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-primary-400">
            @if (Auth::check())
                @include('layouts.navigation')
            @else
                @include('layouts.guest-navigation')
            @endif

            <!-- Page Content -->
            <main>
                <x-app-content>
                    <x-success-notice />
                    <x-error-notice />
                    {{ $slot }}
                </x-app-content>
            </main>

            @include('layouts.footer')
        </div>
    </body>
</html>
