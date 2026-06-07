<nav class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-md border-b border-stone-200 transition-all duration-300"
    x-data="{ mobileMenuOpen: false, scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'shadow-minimal': scrolled }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-ink flex items-center justify-center rounded-lg group-hover:scale-105 transition-transform duration-200">
                        <span class="text-white font-semibold text-sm">TO</span>
                    </div>
                    <span class="text-lg font-semibold text-ink tracking-tight">Toko Online</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('home') ? 'text-ink bg-stone-100' : 'text-silver hover:text-ink hover:bg-stone-50' }}">
                    Beranda
                </a>

                <!-- Category Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @mouseenter="open = true" @mouseleave="open = false" @click="open = !open"
                        class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg text-silver hover:text-ink hover:bg-stone-50 flex items-center gap-1.5">
                        Kategori
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @mouseenter="open = true" @mouseleave="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-minimal-lg border border-stone-100 overflow-hidden z-50">
                        <div class="p-2">
                            @php
                                $categories = \App\Models\Category::where('is_active', true)->withCount('products')->orderBy('name')->get();
                            @endphp
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                   class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-150">
                                    <div class="flex items-center gap-3">
                                        <span class="text-base">{{ $category->icon ?? '📦' }}</span>
                                        <span class="font-medium">{{ $category->name }}</span>
                                    </div>
                                    <span class="text-xs text-mist">{{ $category->products_count }}</span>
                                </a>
                            @endforeach
                            @if($categories->isEmpty())
                                <p class="px-4 py-6 text-center text-mist text-sm">Tidak ada kategori</p>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('products.*') ? 'text-ink bg-stone-100' : 'text-silver hover:text-ink hover:bg-stone-50' }}">
                    Produk
                </a>
                <a href="{{ route('about') }}"
                    class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('about') ? 'text-ink bg-stone-100' : 'text-silver hover:text-ink hover:bg-stone-50' }}">
                    Tentang
                </a>
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-2">
                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}"
                    class="relative p-2.5 text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <x-cart-count />
                </a>

                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2.5 px-3 py-2 text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg">
                            <div class="w-7 h-7 bg-ink flex items-center justify-center rounded-full">
                                <span class="text-white font-medium text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-minimal-lg border border-stone-100 overflow-hidden z-50">
                            <div class="p-2">
                                <a href="{{ route('orders.index') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Pesanan Saya
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil
                                </a>
                                <div class="h-px bg-stone-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg text-sm text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Auth Links -->
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-medium text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg border border-stone-200 {{ request()->routeIs('login') ? 'text-ink border-ink bg-stone-50' : '' }}">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-ink hover:bg-graphite transition-colors duration-200 rounded-lg {{ request()->routeIs('register') ? 'bg-graphite' : '' }}">
                            Register
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden p-2.5 text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white border-t border-stone-200">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('home') ? 'text-ink bg-stone-100' : 'text-silver hover:text-ink hover:bg-stone-50' }}">
                Beranda
            </a>

            <!-- Mobile Category Accordion -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg text-silver hover:text-ink hover:bg-stone-50">
                    Kategori
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="bg-stone-50 rounded-lg mt-1.5">
                    @foreach($categories ?? [] as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="flex items-center gap-3 px-5 py-2.5 text-sm text-silver hover:text-ink transition-colors">
                            <span>{{ $category->icon ?? '📦' }}</span>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('products.index') }}"
                class="block px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('products.*') ? 'text-ink bg-stone-100' : 'text-silver hover:text-ink hover:bg-stone-50' }}">
                Produk
            </a>
            <a href="{{ route('about') }}"
                class="block px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('about') ? 'text-ink bg-stone-100' : 'text-silver hover:text-ink hover:bg-stone-50' }}">
                Tentang
            </a>

            @auth
                <div class="h-px bg-stone-100 my-2"></div>
                <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm font-medium text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg">
                    Pesanan Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm font-medium text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg">
                        Logout
                    </button>
                </form>
            @else
                <div class="h-px bg-stone-100 my-2"></div>
                <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm font-medium text-silver hover:text-ink hover:bg-stone-50 transition-colors duration-200 rounded-lg">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block mx-4 my-2 py-2.5 text-center text-sm font-medium text-white bg-ink rounded-lg transition-colors duration-200 hover:bg-graphite">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>