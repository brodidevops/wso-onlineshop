@extends('frontend.layouts.app')

@section('title', 'Keranjang Belanja - Toko Online')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <nav class="text-sm text-slate-500 mb-2">
                <a href="{{ route('frontend.index') }}" class="hover:text-navy-800 transition-colors">Beranda</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-navy-800 font-medium">Keranjang Belanja</span>
            </nav>
            <h1 class="font-display text-3xl font-bold text-navy-900">Keranjang Belanja</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $cart->count() }} item dalam keranjang</p>
        </div>

        @if($cart->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-3">
                    @foreach($cart->toArray() as $cartItem)
                        @php $item = $cart->get($cartItem['id']); @endphp
                        <div class="card p-4 flex flex-col sm:flex-row gap-4">
                            <!-- Product Image -->
                            <div class="w-full sm:w-24 h-24 bg-slate-50 rounded-card overflow-hidden flex-shrink-0">
                                @if($item['product']->image)
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <a href="{{ route('frontend.products.show', $item['product']) }}" class="text-navy-800 font-medium hover:text-brand-600 transition-colors truncate block">
                                            {{ Str::limit($item['product']->name, 40) }}
                                        </a>
                                        <p class="text-xs text-slate-500 mt-0.5">Stok: {{ $item['product']->stock }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <div class="font-semibold text-navy-900">{{ $item['price_formatted'] }}</div>
                                    </div>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center justify-between mt-3">
                                    <div class="inline-flex items-center rounded-card overflow-hidden border border-slate-200">
                                        <form action="{{ route('frontend.cart.update', $cartItem['id']) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                            <button type="submit" class="px-3 py-1.5 text-slate-500 hover:bg-slate-50 transition-colors {{ $item['quantity'] <= 1 ? 'cursor-not-allowed opacity-40' : '' }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>&minus;</button>
                                        </form>
                                        <span class="px-4 py-1.5 text-sm font-medium text-navy-900 bg-white text-center min-w-[2.5rem]">{{ $item['quantity'] }}</span>
                                        <form action="{{ route('frontend.cart.update', $cartItem['id']) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                            <button type="submit" class="px-3 py-1.5 text-slate-500 hover:bg-slate-50 transition-colors" >&plus;</button>
                                        </form>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-slate-500">Subtotal:</span>
                                        <span class="font-semibold text-navy-900">{{ $item['subtotal_formatted'] }}</span>
                                    </div>
                                </div>

                                <form action="{{ route('frontend.cart.remove', $cartItem['id']) }}" method="POST" class="mt-3">
                                    @csrf
                                    <button type="submit" class="text-xs text-slate-500 hover:text-red-600 transition-colors inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Continue Shopping -->
                    <a href="{{ route('frontend.products.index') }}" class="inline-flex items-center gap-2 text-sm text-brand-600 hover:text-brand-700 font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Lanjut Belanja
                    </a>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="card p-5 sticky top-20">
                        <h3 class="font-semibold text-navy-900 mb-4">Ringkasan Pesanan</h3>

                        <div class="space-y-3 mb-4 pb-4 border-b border-slate-100">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Subtotal ({{ $cart->count() }} item)</span>
                                <span class="font-medium text-navy-900">{{ $cart->subtotal_formatted }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Pengiriman</span>
                                <span class="text-slate-500 text-xs italic">Dihitung saat checkout</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-5">
                            <span class="text-base font-semibold text-navy-900">Total</span>
                            <span class="font-display text-xl font-bold text-navy-900">{{ $cart->total_formatted }}</span>
                        </div>

                        <a href="{{ route('frontend.checkout.index') }}" class="btn btn-brand !w-full !py-3.5 rounded-pill text-center inline-block">
                            Proses Checkout
                        </a>

                        <!-- Trust Badges -->
                        <div class="mt-5 pt-5 border-t border-slate-100 space-y-2">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <svg class="w-4 h-4 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Pembayaran 100% aman</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <svg class="w-4 h-4 text-brand-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Garansi uang kembali</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <h3 class="font-display text-lg font-semibold text-slate-800 mb-1">Keranjang Anda Kosong</h3>
                <p class="text-sm text-slate-500 mb-4">Mulai belanja sekarang dan temukan produk favorit Anda</p>
                <a href="{{ route('frontend.products.index') }}" class="btn btn-brand rounded-pill !px-5 !py-2.5 inline-block">Mulai Belanja</a>
            </div>
        @endif
    </div>
@endsection
