<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name') . ' | Toko Online')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-lg border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-gradient-to-br from-navy-800 to-brand-600 rounded-card flex items-center justify-center shadow-sm">
                        <span class="text-white font-bold text-sm">TO</span>
                    </div>
                    <span class="font-display font-bold text-lg text-navy-900">Toko Online</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ url('/') }}" class="navbar-item {{ request()->routeIs('frontend.home') ? 'navbar-item-active' : '' }}">Beranda</a>
                    <a href="{{ route('frontend.categories.index') }}" class="navbar-item {{ request()->routeIs('frontend.categories.*') ? 'navbar-item-active' : '' }}">Kategori</a>
                    <a href="{{ route('frontend.products.index') }}" class="navbar-item {{ request()->routeIs('frontend.products.*') ? 'navbar-item-active' : '' }}">Produk</a>
                    <a href="{{ route('frontend.static.about') }}" class="navbar-item {{ request()->routeIs('frontend.static.*') ? 'navbar-item-active' : '' }}">Tentang</a>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    <!-- Cart -->
                    <button onclick="toggleMobileMenu()" class="md:hidden relative p-2 text-slate-600 hover:text-navy-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <a href="{{ route('frontend.cart.index') }}" class="hidden sm:flex items-center gap-2 p-2 text-slate-600 hover:text-navy-800 transition-colors relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M9 18h6M10 9h4"/>
                        </svg>
                        @php $cartCount = 0; @endphp
                    </a>

                    @auth
                        <a href="{{ route('frontend.orders.index') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:text-navy-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Pesanan
                        </a>
                        <div class="hidden sm:flex items-center gap-2">
                            <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-slate-500 hover:text-red-600 font-medium transition-colors">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:flex btn btn-outline text-sm">Login</a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 hover:text-navy-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menuIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="md:hidden hidden pb-4 border-t border-slate-100 mt-2 pt-4">
                <div class="flex flex-col gap-1">
                    <a href="{{ url('/') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-navy-800 hover:bg-slate-50 rounded-card transition-colors {{ request()->routeIs('frontend.home') ? 'bg-navy-50/50 text-navy-800 font-semibold' : '' }}">Beranda</a>
                    <a href="{{ route('frontend.categories.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-navy-800 hover:bg-slate-50 rounded-card transition-colors {{ request()->routeIs('frontend.categories.*') ? 'bg-navy-50/50 text-navy-800 font-semibold' : '' }}">Kategori</a>
                    <a href="{{ route('frontend.products.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-navy-800 hover:bg-slate-50 rounded-card transition-colors {{ request()->routeIs('frontend.products.*') ? 'bg-navy-50/50 text-navy-800 font-semibold' : '' }}">Produk</a>
                    <a href="{{ route('frontend.static.about') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-navy-800 hover:bg-slate-50 rounded-card transition-colors {{ request()->routeIs('frontend.static.*') ? 'bg-navy-50/50 text-navy-800 font-semibold' : '' }}">Tentang</a>
                    <a href="{{ route('frontend.cart.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-navy-800 hover:bg-slate-50 rounded-card transition-colors">Keranjang</a>
                    @auth
                        <a href="{{ route('frontend.orders.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-navy-800 hover:bg-slate-50 rounded-card transition-colors">Pesanan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-card transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="mx-4 mt-2 btn btn-outline text-sm">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Spacer for fixed navbar -->
    <div class="h-16"></div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-navy-900 text-slate-300">
        <!-- Footer Top -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-10">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-white/10 rounded-card flex items-center justify-center">
                            <span class="text-white font-bold text-sm">TO</span>
                        </div>
                        <span class="font-display font-bold text-lg text-white">Toko Online</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Platform belanja online terpercaya dengan koleksi produk berkualitas dan layanan pelanggan terbaik.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wider">Menu</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ url('/') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Beranda</a></li>
                        <li><a href="{{ route('frontend.categories.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Kategori</a></li>
                        <li><a href="{{ route('frontend.products.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Produk</a></li>
                        <li><a href="{{ route('frontend.static.about') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h4 class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wider">Layanan</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('frontend.static.terms') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('frontend.static.privacy') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('frontend.static.about') }}" class="text-sm text-slate-400 hover:text-white transition-colors duration-150">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-display font-semibold text-white text-sm mb-4 uppercase tracking-wider">Kontak</h4>
                    <ul class="space-y-2.5">
                        <li class="flex items-center gap-2 text-sm text-slate-400">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            hello@tokoonline.com
                        </li>
                        <li class="flex items-center gap-2 text-sm text-slate-400">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +62 812 3456 7890
                        </li>
                        <li class="flex items-center gap-2 text-sm text-slate-400">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} Toko Online. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-slate-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const icon = document.getElementById('menuIcon');
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            } else {
                icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            }
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-soft');
            } else {
                navbar.classList.remove('shadow-soft');
            }
        });
    </script>
</body>
</html>
