@extends('frontend.layouts.app')

@section('title', 'Beranda - Toko Online')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block text-xs font-medium uppercase tracking-widest text-mist mb-4">
                        New Collection
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-ink leading-tight mb-6">
                        Belanja
                        <span class="block text-graphite">dengan Gaya</span>
                    </h1>
                    <p class="text-silver text-lg mb-8 max-w-md leading-relaxed">
                        Discover premium products crafted with quality and elegance. Shop the latest arrivals with exclusive offers.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-ink text-white font-medium hover:bg-graphite transition-colors duration-200 rounded-lg">
                            Shop Now
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#categories" class="inline-flex items-center px-6 py-3 border border-stone-300 text-ink font-medium hover:bg-stone-50 transition-colors duration-200 rounded-lg">
                            Explore Categories
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="flex gap-10 mt-12 pt-8 border-t border-stone-200">
                        <div>
                            <p class="text-2xl font-bold text-ink">15+</p>
                            <p class="text-sm text-mist">Products</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-ink">6</p>
                            <p class="text-sm text-mist">Categories</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-ink">24/7</p>
                            <p class="text-sm text-mist">Support</p>
                        </div>
                    </div>
                </div>

                <div class="relative hidden md:block">
                    <div class="bg-stone-100 rounded-2xl p-8 aspect-square flex items-center justify-center">
                        <div class="w-full h-full bg-gradient-to-br from-stone-200 to-stone-100 rounded-xl flex items-center justify-center">
                            <svg class="w-32 h-32 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="bg-stone-50 border-y border-stone-200 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-8 text-sm text-silver">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Free Shipping
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Secure Payment
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    24/7 Support
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Easy Returns
                </span>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    @if($categories->count() > 0)
        <section id="categories" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-xs font-medium uppercase tracking-widest text-mist mb-4 block">Browse By</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-ink">Categories</h2>
                    <div class="w-12 h-0.5 bg-ink mx-auto mt-4"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                           class="group bg-stone-50 hover:bg-stone-100 border border-stone-200 hover:border-stone-300 rounded-xl p-6 text-center transition-all duration-200">
                            <span class="text-3xl mb-3 block">{{ $category->icon ?? '📦' }}</span>
                            <h3 class="text-sm font-medium text-ink mb-1">{{ $category->name }}</h3>
                            <p class="text-xs text-mist">{{ $category->products_count ?? 0 }} items</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Featured Products Section -->
    @if($featuredProducts->count() > 0)
        <section class="py-16 bg-stone-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                    <div>
                        <span class="text-xs font-medium uppercase tracking-widest text-mist mb-4 block">Featured</span>
                        <h2 class="text-2xl md:text-3xl font-bold text-ink">Featured Products</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-medium text-ink hover:text-graphite transition-colors mt-4 md:mt-0">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($featuredProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Promo Banner -->
    <section class="py-16 bg-ink text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="text-xs font-medium uppercase tracking-widest text-stone-400 mb-4 block">Limited Time Offer</span>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        Get <span class="text-stone-400">20% Off</span><br>
                        On First Order
                    </h2>
                    <p class="text-stone-400 mb-8 max-w-md leading-relaxed">
                        Sign up today and receive an exclusive 20% discount on your first purchase. Limited time offer.
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-white text-ink font-medium hover:bg-stone-100 transition-colors duration-200 rounded-lg">
                        Create Account
                    </a>
                </div>
                <div class="relative">
                    <div class="bg-stone-800 rounded-2xl p-10 text-center border border-stone-700">
                        <p class="text-6xl md:text-7xl font-bold">20%</p>
                        <p class="text-xl font-light text-stone-400 mt-2">OFF</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Products Section -->
    @if($latestProducts->count() > 0)
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-10">
                    <span class="text-xs font-medium uppercase tracking-widest text-mist mb-4 block">Just Arrived</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-ink">New Arrivals</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($latestProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Features Section -->
    <section class="py-16 bg-stone-50 border-t border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-8 bg-white rounded-xl border border-stone-200">
                    <div class="w-12 h-12 mx-auto mb-5 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-ink mb-2">Quality Products</h3>
                    <p class="text-sm text-mist">Only the finest products from trusted suppliers</p>
                </div>

                <div class="text-center p-8 bg-white rounded-xl border border-stone-200">
                    <div class="w-12 h-12 mx-auto mb-5 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-ink mb-2">Fast Delivery</h3>
                    <p class="text-sm text-mist">Quick shipping to your doorstep nationwide</p>
                </div>

                <div class="text-center p-8 bg-white rounded-xl border border-stone-200">
                    <div class="w-12 h-12 mx-auto mb-5 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-ink mb-2">Secure Payment</h3>
                    <p class="text-sm text-mist">Your transactions are protected and secure</p>
                </div>

                <div class="text-center p-8 bg-white rounded-xl border border-stone-200">
                    <div class="w-12 h-12 mx-auto mb-5 bg-stone-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-ink mb-2">24/7 Support</h3>
                    <p class="text-sm text-mist">Our team is always here to help you</p>
                </div>
            </div>
        </div>
    </section>
@endsection