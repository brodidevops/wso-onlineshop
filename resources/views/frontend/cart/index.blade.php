@extends('frontend.layouts.app')

@section('title', 'Keranjang - Toko Online')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-mist hover:text-ink transition-colors">Beranda</a>
                </li>
                <li class="text-pearl">/</li>
                <li class="text-ink font-medium">Keranjang</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-ink">Keranjang Belanja</h1>
            <p class="text-silver mt-1">{{ $cartItems->count() }} item di keranjang Anda</p>
        </div>

        <!-- Login Required Alert -->
        @if(session('login_required'))
            <div class="mb-6 p-4 bg-stone-50 border border-stone-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-silver flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-medium text-ink">Silakan login untuk menambahkan produk ke keranjang</p>
                        <p class="text-sm text-silver mt-1">Login atau daftar akun untuk melanjutkan belanja</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-ink hover:bg-graphite text-white text-sm font-medium rounded-lg transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-white hover:bg-stone-50 text-ink text-sm font-medium rounded-lg border border-stone-200 transition-colors">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $productId => $item)
                        <div class="bg-white rounded-xl border border-stone-200 p-4 md:p-6">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Product Image -->
                                <div class="w-full sm:w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden bg-stone-100 border border-stone-200">
                                    @if($item['image'])
                                        <img
                                            src="{{ $item['image'] }}"
                                            alt="{{ $item['name'] }}"
                                            class="w-full h-full object-cover"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="font-medium text-ink">
                                                <a href="{{ route('products.show', $productId) }}" class="hover:text-graphite transition-colors">
                                                    {{ $item['name'] }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-mist mt-1">
                                                {{ $item['weight'] ?? 1000 }}g
                                            </p>
                                        </div>
                                        <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-mist hover:text-ink transition-colors p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                                        <!-- Quantity -->
                                        <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center border border-stone-200 rounded-lg">
                                                <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" class="px-3 py-1.5 text-silver hover:text-ink hover:bg-stone-50 transition-colors {{ $item['qty'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                <input
                                                    type="number"
                                                    name="qty"
                                                    value="{{ $item['qty'] }}"
                                                    min="1"
                                                    max="{{ $item['stock'] ?? 99 }}"
                                                    class="w-12 text-center border-0 focus:ring-0 text-sm font-medium text-ink"
                                                    onchange="this.form.submit()"
                                                >
                                                <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" class="px-3 py-1.5 text-silver hover:text-ink hover:bg-stone-50 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <p class="text-base font-semibold text-ink">
                                                Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm text-mist">
                                                {{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Clear Cart -->
                    <div class="flex justify-end">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="text-mist hover:text-ink font-medium flex items-center gap-2 transition-colors"
                                onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Kosongkan Keranjang</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl border border-stone-200 p-6 sticky top-24">
                        <h3 class="text-base font-semibold text-ink mb-5">Ringkasan Belanja</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-silver">Subtotal ({{ $cartItems->sum('qty') }} item)</span>
                                <span class="font-medium text-ink">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-silver">Berat Total</span>
                                <span class="font-medium text-ink">{{ number_format($totalWeight / 1000, 2) }} kg</span>
                            </div>
                        </div>

                        <hr class="my-5 border-stone-200">

                        <div class="flex justify-between text-base font-semibold">
                            <span>Total</span>
                            <span class="text-ink">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        @auth
                            <a
                                href="{{ route('checkout.index') }}"
                                class="mt-6 w-full inline-block bg-ink text-white text-center py-3 rounded-lg font-medium hover:bg-graphite transition-colors"
                            >
                                Lanjutkan ke Pembayaran
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="mt-6 w-full inline-block bg-ink text-white text-center py-3 rounded-lg font-medium hover:bg-graphite transition-colors"
                            >
                                Login untuk Checkout
                            </a>
                        @endauth

                        <a
                            href="{{ route('products.index') }}"
                            class="mt-3 w-full inline-block text-center py-3 text-ink font-medium hover:text-graphite transition-colors"
                        >
                            Lanjutkan Belanja
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-xl border border-stone-200 p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-stone-200 mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-ink mb-2">Keranjang Kosong</h3>
                <p class="text-mist mb-6">Belum ada produk di keranjang belanja Anda</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-ink text-white px-6 py-3 rounded-lg font-medium hover:bg-graphite transition-colors">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
@endsection