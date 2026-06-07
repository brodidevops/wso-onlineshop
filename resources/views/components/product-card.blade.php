<div class="group relative bg-white rounded-card border border-stone-200 hover:border-stone-300 transition-all duration-300 overflow-hidden hover:shadow-card-hover">
    <!-- Image Container -->
    <div class="relative overflow-hidden aspect-[4/3] bg-stone-100">
        @if($product->image_url)
            <img
                src="{{ $product->image_url }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                loading="lazy"
            >
        @else
            <div class="w-full h-full flex items-center justify-center bg-stone-100">
                <svg class="w-12 h-12 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif

        <!-- Discount Badge -->
        @if($product->discount_percent > 0)
            <span class="absolute top-3 left-3 bg-ink text-white text-xs font-medium px-2.5 py-1 rounded-md">
                -{{ $product->discount_percent }}%
            </span>
        @endif

        <!-- Out of Stock Overlay -->
        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-white/90 backdrop-blur-sm flex items-center justify-center">
                <span class="bg-stone-800 text-white font-medium px-4 py-1.5 text-xs uppercase tracking-wider rounded-md">
                    Out of Stock
                </span>
            </div>
        @endif

        <!-- Quick View Button -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
            <a href="{{ route('products.show', $product->slug) }}"
               class="bg-white text-ink px-4 py-2 font-medium text-sm rounded-lg hover:bg-stone-100 transition-colors duration-200 transform translate-y-2 group-hover:translate-y-0">
                Quick View
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4">
        <!-- Category Badge -->
        @if($product->category)
            <span class="inline-block text-xs font-medium uppercase tracking-wider text-mist mb-2">
                {{ $product->category->name }}
            </span>
        @endif

        <!-- Product Name -->
        <h3 class="font-medium text-ink mb-2 min-h-[2.5rem] leading-tight line-clamp-2">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-graphite transition-colors">
                {{ $product->name }}
            </a>
        </h3>

        <!-- Price -->
        <div class="mb-3">
            <div class="flex items-baseline gap-2">
                <span class="text-lg font-semibold text-ink">
                    {{ $product->formatted_price }}
                </span>
                @if($product->original_price && $product->original_price > $product->price)
                    <span class="text-sm text-mist line-through">
                        Rp {{ number_format($product->original_price, 0, ',', '.') }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Add to Cart Button -->
        @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="qty" value="1">
                <button
                    type="submit"
                    class="w-full bg-ink text-white py-2.5 px-4 font-medium text-sm rounded-lg hover:bg-graphite transition-colors duration-200 flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Add to Cart
                </button>
            </form>
        @else
            <button
                disabled
                class="w-full bg-stone-100 text-mist py-2.5 px-4 font-medium text-sm rounded-lg cursor-not-allowed">
                Sold Out
            </button>
        @endif
    </div>
</div>