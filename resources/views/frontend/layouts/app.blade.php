<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Toko Online') }} - @yield('title', 'Belanja Online Terpercaya')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAFAF9;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::selection {
            background-color: #1A1A1A;
            color: #FFFFFF;
        }

        /* Minimal scrollbar */
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
    <!-- Navbar -->
    <x-frontend-navbar />

    <!-- Main Content -->
    <main class="min-h-screen pt-16 bg-stone-50">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-ink flex items-center justify-center rounded-lg">
                            <span class="text-white font-bold text-lg">T</span>
                        </div>
                        <span class="text-xl font-semibold text-ink tracking-tight">Toko Online</span>
                    </div>
                    <p class="text-silver text-sm leading-relaxed mb-6">
                        Platform belanja online terpercaya dengan berbagai pilihan produk berkualitas untuk kebutuhan Anda.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 bg-stone-100 hover:bg-stone-200 flex items-center justify-center rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-silver" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-stone-100 hover:bg-stone-200 flex items-center justify-center rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-silver" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-stone-100 hover:bg-stone-200 flex items-center justify-center rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-silver" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-ink font-semibold text-sm uppercase tracking-wider mb-6">Navigasi</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('home') }}" class="text-silver hover:text-ink text-sm transition-colors">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-silver hover:text-ink text-sm transition-colors">Produk</a></li>
                        <li><a href="{{ route('about') }}" class="text-silver hover:text-ink text-sm transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-ink font-semibold text-sm uppercase tracking-wider mb-6">Kategori</h4>
                    <ul class="space-y-4">
                        @php
                            $footerCategories = \App\Models\Category::where('is_active', true)->take(5)->get();
                        @endphp
                        @foreach($footerCategories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="text-silver hover:text-ink text-sm transition-colors">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-ink font-semibold text-sm uppercase tracking-wider mb-6">Kontak</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-mist mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-silver text-sm">Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-mist mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-silver text-sm">info@tokoonline.com</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-mist mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-silver text-sm">+62 123 4567 890</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-stone-200 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-silver text-sm">{{ date('Y') }} Toko Online. All rights reserved.</p>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('privacy') }}" class="text-silver hover:text-ink text-sm transition-colors">Kebijakan Privasi</a>
                        <a href="{{ route('terms') }}" class="text-silver hover:text-ink text-sm transition-colors">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>