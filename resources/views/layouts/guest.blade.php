<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Toko Online') }} - @yield('title', 'Authentication')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAFAF9;
            min-height: 100vh;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::selection {
            background-color: #1A1A1A;
            color: #FFFFFF;
        }

        /* Subtle scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F5F5F4;
        }
        ::-webkit-scrollbar-thumb {
            background: #D6D3D1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #A8A29E;
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
        <!-- Logo -->
        <div class="mb-10">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-ink flex items-center justify-center rounded-lg group-hover:scale-105 transition-transform duration-200">
                    <span class="text-white font-semibold text-sm">TO</span>
                </div>
                <span class="text-xl font-semibold text-ink tracking-tight">Toko Online</span>
            </a>
        </div>

        <!-- Form Container -->
        <div class="w-full sm:max-w-md bg-white rounded-xl border border-stone-200 p-8 shadow-minimal">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-mist">{{ date('Y') }} Toko Online</p>
        </div>
    </div>

    @stack('scripts')
</body>
</html>