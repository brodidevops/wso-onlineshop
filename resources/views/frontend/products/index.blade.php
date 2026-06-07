@extends('frontend.layouts.app')

@section('title', isset($category) ? "Produk - {$category->name}" : 'Produk - Toko Online')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="text-sm text-slate-300 mb-2">
                <a href="{{ route('frontend.index') }}" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white font-medium">{{ isset($category) ? $category->name : 'Semua Produk' }}</span>
            </nav>
            <h1 class="font-display text-3xl md:text-4xl font-bold">
                {{ isset($category) ? $category->name : 'Semua Produk' }}
            </h1>
            <p class="text-slate-300 mt-1 text-sm">{{ $products->total() }} produk ditemukan</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <aside class="lg:w-64 flex-shrink-0">
                <!-- Search -->
                <div class="card p-4 mb-4">
                    <h3 class="text-sm font-semibold text-navy-900 mb-3">Cari Produk</h3>
                    <form action="{{ isset($category) ? route('frontend.categories.show', $category) : route('frontend.products.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..." class="input w-full !pr-10" />
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                <!-- Categories -->
                <div class="card p-4">
                    <h3 class="text-sm font-semibold text-navy-900 mb-3">Kategori</h3>
                    <div class="space-y-1">
                        <a href="{{ route('frontend.products.index', array_filter(array_merge(request()->all(), ['category_id' => null]))) }}"
                           class="flex items-center justify-between px-3 py-2 text-sm rounded-card transition-colors duration-150 {{ !request('category_id') ? 'bg-brand-50 text-brand-700 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-navy-800' }}">
                            Semua Kategori
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('frontend.products.index', array_filter(array_merge(request()->all(), ['category_id' => $cat->id]))) }}"
                               class="flex items-center justify-between px-3 py-2 text-sm rounded-card transition-colors duration-150 {{ request('category_id') == $cat->id ? 'bg-brand-50 text-brand-700 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-navy-800' }}">
                                {{ Str::limit($cat->name, 20) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- Main Product Area -->
            <div class="flex-1">
                @if($products->isEmpty())
                    <div class="card p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <h3 class="font-display text-lg font-semibold text-slate-800 mb-1">Produk tidak ditemukan</h3>
                        <p class="text-sm text-slate-500 mb-4">Coba ubah kata kunci atau filter pencarian Anda</p>
                        <a href="{{ route('frontend.products.index') }}" class="btn btn-brand rounded-pill !px-4 !py-2 text-sm">Reset Filter</a>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            @include('frontend.components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links('frontend.components.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
