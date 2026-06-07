@extends('frontend.layouts.app')

@section('title', $product->name . ' - Toko Online')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-mist hover:text-ink transition-colors">Beranda</a>
                </li>
                <li class="text-pearl">/</li>
                <li>
                    <a href="{{ route('products.index') }}" class="text-mist hover:text-ink transition-colors">Shop</a>
                </li>
                <li class="text-pearl">/</li>
                @if($product->category)
                    <li>
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-mist hover:text-ink transition-colors">
                            {{ $product->category->name }}
                        </a>
                    </li>
                    <li class="text-pearl">/</li>
                @endif
                <li class="text-ink font-medium truncate max-w-[200px]">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="bg-white rounded-xl border border-stone-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 lg:p-10">
                <!-- Product Image -->
                <div class="relative">
                    <div class="aspect-square rounded-xl overflow-hidden bg-stone-100 border border-stone-200">
                        @if($product->image_url)
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-stone-100">
                                <svg class="w-20 h-20 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    @if($product->discount_percent > 0)
                        <span class="absolute top-4 left-4 bg-ink text-white font-medium px-3 py-1.5 rounded-lg text-sm">
                            -{{ $product->discount_percent }}%
                        </span>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex flex-col">
                    @if($product->category)
                        <span class="inline-block text-xs font-medium uppercase tracking-wider text-mist mb-3">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    <h1 class="text-2xl lg:text-3xl font-bold text-ink mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- SKU -->
                    @if($product->sku)
                        <p class="text-sm text-mist mb-6">
                            SKU: {{ $product->sku }}
                   </p>
                    @endif

                    <!-- Price -->
                    <div class="mb-6 pb-6 border-b border-stone-200">
                        <span class="text-3xl font-bold text-ink">
                            {{ $product->formatted_price }}
                        </span>
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="text-lg text-mist line-through ml-3">
                                Rp {{ number_format($product->original_price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($product->description)
                        <div class="mb-6">
                            <h3 class="font-semibold text-ink text-sm uppercase tracking-wider mb-3">Deskripsi</h3>
                            <p class="text-silver leading-relaxed">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Stock -->
                    <div class="mb-6">
                        @if($product->stock > 0)
                            <div class="flex items-center text-accent-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Stok Tersedia: {{ $product->stock }}</span>
                            </div>
                        @else
                            <div class="flex items-center text-red-600">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Stok Habis</span>
                            </div>
                        @endif
                    </div>

                    <!-- Add to Cart Form -->
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4 mb-6">
                            @csrf
                            <div class="flex items-center">
                                <label class="text-sm font-medium text-ink mr-4">Jumlah:</label>
                                <div class="flex items-center border border-stone-300 rounded-lg">
                                    <button type="button" onclick="decreaseQty()" class="px-3 py-2 text-silver hover:text-ink hover:bg-stone-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input
                                        type="number"
                                        name="qty"
                                        id="qty"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="w-14 text-center border-0 focus:ring-0 text-sm font-medium text-ink"
                                    >
                                    <button type="button" onclick="increaseQty()" class="px-3 py-2 text-silver hover:text-ink hover:bg-stone-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="flex-1 bg-ink text-white py-3 px-6 rounded-lg font-medium hover:bg-graphite transition-colors flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        </form>
                    @endif

                    <!-- Min Order -->
                    @if($product->min_order > 1)
                        <p class="text-sm text-mist">
                            Minimal pemesanan: {{ $product->min_order }} item
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <section class="mt-12">
                <h2 class="text-xl font-bold text-ink mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($relatedProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    @push('scripts')
        <script>
            function increaseQty() {
                const input = document.getElementById('qty');
                const max = parseInt(input.max);
                const current = parseInt(input.value);
                if (current < max) {
                    input.value = current + 1;
                }
            }

            function decreaseQty() {
                const input = document.getElementById('qty');
                const min = parseInt(input.min);
                const current = parseInt(input.value);
                if (current > min) {
                    input.value = current - 1;
                }
            }
        </script>
    @endpush
@endsection