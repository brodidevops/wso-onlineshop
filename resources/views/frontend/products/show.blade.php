@extends('frontend.layouts.app')

@section('title', $product->name . ' - Toko Online')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumb -->
        <nav class="text-sm text-slate-500 mb-4">
            <a href="{{ route('frontend.index') }}" class="hover:text-navy-800 transition-colors">Beranda</a>
            <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('frontend.products.index') }}" class="hover:text-navy-800 transition-colors">Produk</a>
            <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-navy-800 font-medium">{{ Str::limit($product->name, 30) }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Product Image -->
            <div>
                <div class="card p-4 aspect-square overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full bg-slate-50 flex items-center justify-center">
                            <svg class="w-24 h-24 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div>
                @if($product->category)
                    <a href="{{ route('frontend.categories.show', $product->category) }}" class="text-xs font-semibold text-brand-600 uppercase tracking-widest hover:text-brand-700">
                        {{ $product->category->name }}
                    </a>
                @endif

                <h1 class="font-display text-2xl md:text-3xl font-bold text-navy-900 mt-2 leading-tight">{{ $product->name }}</h1>

                <!-- Rating -->
                <div class="flex items-center gap-2 mt-3">
                    <div class="flex items-center">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm text-slate-500">(4.8 / 5)</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-sm text-slate-500">Stok: <span class="font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}</span></span>
                </div>

                <!-- Price -->
                <div class="mt-5 pb-5 border-b border-slate-100">
                    <div class="font-display text-3xl font-bold text-navy-900">{{ $product->price_formatted }}</div>
                    @if($product->stock > 0)
                        <p class="text-xs text-slate-500 mt-1">Sisa {{ $product->stock }} produk tersedia</p>
                    @endif
                </div>

                <!-- Description -->
                <div class="mt-5">
                    <h3 class="text-sm font-semibold text-navy-900 mb-2">Deskripsi Produk</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $product->description ?: 'Tidak ada deskripsi untuk produk ini.' }}</p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    @if($product->stock > 0)
                        <form action="{{ route('frontend.cart.add', $product) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-brand !py-3.5 rounded-pill w-full inline-flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Tambah ke Keranjang
                            </button>
                        </form>
                        <button class="btn !bg-white !text-navy-900 !border !border-slate-200 hover:!bg-slate-50 !py-3.5 rounded-pill inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                    @else
                        <button disabled class="btn !bg-slate-200 !text-slate-500 cursor-not-allowed !py-3.5 rounded-pill w-full">
                            Stok Habis
                        </button>
                    @endif
                </div>

                <!-- Trust Info -->
                <div class="mt-6 space-y-2.5">
                    <div class="flex items-center gap-2.5 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Produk Original & Bergaransi</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Pembayaran Aman & Terpercaya</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Pengiriman Cepat ke Seluruh Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
            <section class="mt-12 pt-10 border-t border-slate-200">
                <div class="mb-6">
                    <span class="text-xs font-semibold text-brand-600 uppercase tracking-widest">Anda Mungkin Suka</span>
                    <h2 class="font-display text-2xl font-bold text-navy-900 mt-2">Produk Terkait</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($relatedProducts as $related)
                        @include('frontend.components.product-card', ['product' => $related])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
