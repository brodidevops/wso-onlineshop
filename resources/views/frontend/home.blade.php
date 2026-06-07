@extends('frontend.layouts.app')

@section('title', 'Beranda - ' . config('app.name'))

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-navy-900 via-navy-800 to-navy-700 text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Text -->
                <div>
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-pill text-xs font-medium text-white mb-5">
                        <span class="w-1.5 h-1.5 bg-brand-400 rounded-full animate-pulse"></span>
                        Koleksi Terbaru 2026
                    </span>
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight tracking-tight mb-5">
                        Belanja Online<br>
                        <span class="text-brand-400">Tanpa Ribet,</span><br>
                        Kapan Saja.
                    </h1>
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-md mb-7">
                        Temukan ribuan produk pilihan dengan harga terbaik. Pengiriman cepat, transaksi aman, dan layanan pelanggan 24/7.
                    </p>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <a href="{{ route('frontend.products.index') }}" class="btn btn-brand text-base !px-6 !py-3.5 rounded-pill inline-flex items-center justify-center gap-2">
                            Mulai Belanja
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('frontend.categories.index') }}" class="btn !bg-white/10 backdrop-blur-sm !text-white !border !border-white/20 hover:!bg-white/20 text-base !px-6 !py-3.5 rounded-pill inline-flex items-center justify-center gap-2">
                            Lihat Kategori
                        </a>
                    </div>
                    <!-- Trust Badges -->
                    <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Pembayaran Aman</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Produk Original</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Pengiriman Cepat</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Visual -->
                <div class="relative hidden lg:block">
                    <div class="absolute -top-8 -right-8 w-72 h-72 bg-brand-500/30 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-8 -left-8 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
                    <div class="relative grid grid-cols-2 gap-4">
                        @forelse($featuredProducts->take(4) as $index => $product)
                            <div class="card overflow-hidden {{ $index % 2 == 0 ? 'translate-y-8' : '' }}">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-slate-100 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="p-3 bg-white">
                                    <p class="text-xs font-medium text-slate-800 line-clamp-1">{{ $product->name }}</p>
                                    <p class="text-sm font-bold text-navy-900 mt-0.5">{{ $product->price_formatted }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="card p-6 col-span-2 bg-white/10 backdrop-blur-sm border-white/20">
                                <p class="text-white/80 text-center text-sm">Belum ada produk</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div>
                    <div class="text-3xl md:text-4xl font-display font-bold text-navy-900">{{ $stats['products'] ?? '0' }}+</div>
                    <div class="text-sm text-slate-500 mt-1">Produk Tersedia</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-display font-bold text-navy-900">{{ $stats['categories'] ?? '0' }}+</div>
                    <div class="text-sm text-slate-500 mt-1">Kategori Pilihan</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-display font-bold text-navy-900">{{ $stats['customers'] ?? '0' }}+</div>
                    <div class="text-sm text-slate-500 mt-1">Pelanggan Puas</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-display font-bold text-navy-900">24/7</div>
                    <div class="text-sm text-slate-500 mt-1">Layanan Pelanggan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 md:py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-8">
                <div>
                    <span class="text-xs font-semibold text-brand-600 uppercase tracking-widest">Kategori</span>
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-navy-900 mt-2">Jelajahi Kategori</h2>
                    <p class="text-sm text-slate-500 mt-2">Temukan produk berdasarkan kategori favorit Anda</p>
                </div>
                <a href="{{ route('frontend.categories.index') }}" class="mt-3 sm:mt-0 text-sm font-semibold text-navy-800 hover:text-brand-600 inline-flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($categories->take(5) as $category)
                    <a href="{{ route('frontend.categories.show', $category) }}" class="card card-hover p-5 text-center group">
                        <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-br from-navy-50 to-brand-50 rounded-pill flex items-center justify-center group-hover:from-navy-800 group-hover:to-brand-600 transition-colors duration-300">
                            <svg class="w-5 h-5 text-navy-800 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-800 group-hover:text-navy-900 transition-colors duration-150">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $category->products_count ?? 0 }} produk</p>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8 text-slate-500 text-sm">Belum ada kategori</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-8">
                <div>
                    <span class="text-xs font-semibold text-brand-600 uppercase tracking-widest">Pilihan Terbaik</span>
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-navy-900 mt-2">Produk Unggulan</h2>
                    <p class="text-sm text-slate-500 mt-2">Koleksi produk pilihan yang paling banyak dicari</p>
                </div>
                <a href="{{ route('frontend.products.index') }}" class="mt-3 sm:mt-0 text-sm font-semibold text-navy-800 hover:text-brand-600 inline-flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
                @forelse($featuredProducts->take(8) as $product)
                    @include('frontend.components.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <p class="text-slate-500 text-sm">Belum ada produk unggulan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 md:py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-semibold text-brand-600 uppercase tracking-widest">Mengapa Kami</span>
                <h2 class="font-display text-2xl md:text-3xl font-bold text-navy-900 mt-2">Pengalaman Belanja Terbaik</h2>
                <p class="text-sm text-slate-500 mt-3">Komitmen kami adalah memberikan layanan terbaik untuk setiap pelanggan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Feature 1 -->
                <div class="card p-6">
                    <div class="w-11 h-11 bg-brand-50 rounded-card flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-display font-semibold text-navy-900 text-base mb-1.5">Pengiriman Express</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Pesanan Anda diproses dalam hitungan jam, sampai tujuan dengan aman dan cepat.</p>
                </div>
                <!-- Feature 2 -->
                <div class="card p-6">
                    <div class="w-11 h-11 bg-brand-50 rounded-card flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-display font-semibold text-navy-900 text-base mb-1.5">Transaksi Aman</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Didukung oleh payment gateway terpercaya dengan enkripsi standar industri.</p>
                </div>
                <!-- Feature 3 -->
                <div class="card p-6">
                    <div class="w-11 h-11 bg-brand-50 rounded-card flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <h3 class="font-display font-semibold text-navy-900 text-base mb-1.5">Support 24/7</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Tim customer service profesional siap membantu Anda kapan pun dibutuhkan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-card bg-gradient-to-r from-navy-900 to-navy-700 p-8 md:p-12">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-brand-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="max-w-2xl">
                        <h2 class="font-display text-2xl md:text-3xl font-bold text-white">Siap Memulai Belanja?</h2>
                        <p class="text-slate-300 mt-2 text-sm md:text-base">Daftar sekarang dan dapatkan penawaran eksklusif untuk member baru.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register') }}" class="btn btn-brand !px-6 !py-3 rounded-pill inline-flex items-center justify-center gap-2">
                            Daftar Gratis
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('frontend.products.index') }}" class="btn !bg-white/10 !text-white !border !border-white/20 hover:!bg-white/20 !px-6 !py-3 rounded-pill inline-flex items-center justify-center">
                            Jelajahi Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
