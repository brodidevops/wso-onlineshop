@extends('frontend.layouts.app')

@section('title', 'Shop - Toko Online')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-mist hover:text-ink transition-colors">Beranda</a>
                </li>
                <li class="text-pearl">/</li>
                <li class="text-ink font-medium">Shop</li>
                @if($selectedCategory)
                    <li class="text-pearl">/</li>
                    <li class="text-ink font-medium">{{ $selectedCategory->name }}</li>
                @endif
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <!-- Search -->
                <form action="{{ route('products.index') }}" method="GET" class="mb-6">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari produk..."
                            class="w-full pl-10 pr-4 py-2.5 border border-stone-200 rounded-lg bg-white text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors"
                        >
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>

                <!-- Categories -->
                <div class="bg-white rounded-xl border border-stone-200 p-5 mb-6">
                    <h3 class="font-semibold text-ink text-sm uppercase tracking-wider mb-4">Kategori</h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('products.index', array_filter([
                                'search' => request('search'),
                                'sort' => request('sort')
                            ])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ !request('category') ? 'bg-stone-100 text-ink font-medium' : 'text-silver hover:bg-stone-50 hover:text-ink' }}">
                                <span>Semua</span>
                                <span class="text-xs text-mist">{{ $categories->sum('active_products_count') }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('products.index', array_filter([
                                    'category' => $category->slug,
                                    'search' => request('search'),
                                    'sort' => request('sort')
                                ])) }}"
                                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ request('category') == $category->slug ? 'bg-stone-100 text-ink font-medium' : 'text-silver hover:bg-stone-50 hover:text-ink' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-xs text-mist">{{ $category->active_products_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <!-- Header & Sort -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 bg-white rounded-xl border border-stone-200 p-4">
                    <div>
                        <h1 class="text-lg font-semibold text-ink">
                            @if($selectedCategory)
                                {{ $selectedCategory->name }}
                            @elseif(request('search'))
                                Hasil Pencarian: "{{ request('search') }}"
                            @else
                                Semua Produk
                            @endif
                        </h1>
                        <p class="text-sm text-mist mt-1">{{ $products->total() }} produk ditemukan</p>
                    </div>

                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2 mt-4 sm:mt-0">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="border border-stone-200 rounded-lg px-4 py-2 text-sm bg-white text-ink focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors"
                        >
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                    </form>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl border border-stone-200 p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-stone-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-ink mb-2">Tidak ada produk</h3>
                        <p class="text-mist mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-ink text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-graphite transition-colors">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection