<div class="card card-hover overflow-hidden flex flex-col">
    <!-- Image -->
    <a href="{{ route('frontend.products.show', $product) }}" class="relative block bg-slate-50">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-52 object-cover transition-transform duration-300 hover:scale-105">
        @else
            <div class="w-full h-52 bg-gradient-to-br from-slate-100 to-slate-50 flex items-center justify-center">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
        <!-- Stock badge -->
        @if($product->stock < 5 && $product->stock > 0)
            <span class="absolute top-3 left-3 badge bg-amber-100 text-amber-700 text-xs font-semibold">Stok Terbatas</span>
        @endif
        @if($product->stock === 0)
            <span class="absolute top-3 left-3 badge bg-red-100 text-red-700 text-xs font-semibold">Habis</span>
            <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                <span class="text-sm font-semibold text-slate-500">Stok Habis</span>
            </div>
        @endif
    </a>

    <!-- Content -->
    <div class="p-4 flex flex-col flex-1">
        <!-- Category -->
        @if($product->category)
            <span class="text-xs text-slate-500 font-medium mb-1">{{ $product->category->name }}</span>
        @endif

        <!-- Product name -->
        <a href="{{ route('frontend.products.show', $product) }}" class="font-medium text-slate-800 text-sm leading-snug line-clamp-2 hover:text-navy-800 transition-colors duration-150 flex-1">
            {{ $product->name }}
        </a>

        <!-- Price + Button -->
        <div class="mt-3 flex items-end justify-between gap-2">
            <div>
                <span class="text-lg font-bold text-navy-900">{{ $product->price_formatted }}</span>
            </div>
            @if($product->stock > 0)
                <form action="{{ route('frontend.cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-brand text-xs !px-3 !py-2 rounded-pill flex-shrink-0" title="Tambah ke Keranjang">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </button>
                </form>
            @else
                <button disabled class="btn bg-slate-200 text-slate-400 text-xs !px-3 !py-2 rounded-pill flex-shrink-0 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>
</div>
