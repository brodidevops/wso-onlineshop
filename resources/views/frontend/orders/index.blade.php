@extends('frontend.layouts.app')

@section('title', 'Pesanan Saya - Toko Online')

@section('content')
<div class="min-h-screen bg-stone-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-ink">Pesanan Saya</h1>
            <p class="text-silver mt-1">Kelola dan lacak pesanan Anda</p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-xl border border-stone-200 p-4 mb-6">
            <form method="GET" action="{{ route('orders.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1 relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nomor pesanan..."
                           class="w-full pl-10 pr-4 py-2.5 border border-stone-200 rounded-lg text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Status Filter -->
                <select name="status" class="border border-stone-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Dibayar</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>

                <!-- Payment Status Filter -->
                <select name="payment_status" class="border border-stone-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink">
                    <option value="">Semua Pembayaran</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    <option value="confirmed" {{ request('payment_status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>

                <!-- Search Button -->
                <button type="submit" class="px-5 py-2.5 bg-ink text-white text-sm font-medium rounded-lg hover:bg-graphite transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>

                @if(request('search') || request('status') || request('payment_status'))
                    <a href="{{ route('orders.index') }}" class="px-5 py-2.5 border border-stone-200 text-stone-600 text-sm font-medium rounded-lg hover:bg-stone-50 transition-colors flex items-center gap-2">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        <div class="mb-4">
            <p class="text-sm text-silver">
                Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan
            </p>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl border border-stone-200 overflow-hidden hover:border-stone-300 transition-colors">
                        <!-- Order Header -->
                        <div class="bg-stone-50 px-6 py-4 border-b border-stone-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <p class="text-xs text-silver uppercase tracking-wider">Nomor Pesanan</p>
                                        <p class="text-sm font-semibold text-ink">{{ $order->order_number }}</p>
                                    </div>
                                    <div class="h-8 w-px bg-stone-200"></div>
                                    <div>
                                        <p class="text-xs text-silver uppercase tracking-wider">Tanggal</p>
                                        <p class="text-sm text-ink">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-right">
                                        <p class="text-xs text-silver">Total</p>
                                        <p class="text-lg font-bold text-ink">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-6 py-4">
                            <div class="space-y-3">
                                @foreach($order->items->take(3) as $item)
                                    <div class="flex items-center gap-4">
                                        @if($item->product && $item->product->image_url)
                                            <img src="{{ $item->product->image_url }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="w-16 h-16 object-cover rounded-lg bg-stone-100">
                                        @else
                                            <div class="w-16 h-16 bg-stone-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-ink truncate">{{ $item->product_name }}</p>
                                            <p class="text-xs text-silver">{{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="text-sm font-semibold text-ink">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach

                                @if($order->items->count() > 3)
                                    <p class="text-xs text-silver text-center pt-2">
                                        +{{ $order->items->count() - 3 }} produk lainnya
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bg-stone-50 px-6 py-4 border-t border-stone-200">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="text-xs text-silver mb-1">Status Pesanan</p>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-100 text-amber-800',
                                                'paid' => 'bg-blue-100 text-blue-800',
                                                'processing' => 'bg-purple-100 text-purple-800',
                                                'shipped' => 'bg-cyan-100 text-cyan-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Menunggu',
                                                'paid' => 'Dibayar',
                                                'processing' => 'Diproses',
                                                'shipped' => 'Dikirim',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-stone-100 text-stone-800' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </div>
                                    <div class="h-8 w-px bg-stone-200"></div>
                                    <div>
                                        <p class="text-xs text-silver mb-1">Status Pembayaran</p>
                                        @php
                                            $paymentColors = [
                                                'pending' => 'bg-amber-100 text-amber-800',
                                                'paid' => 'bg-green-100 text-green-800',
                                                'confirmed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                'refunded' => 'bg-stone-100 text-stone-800',
                                            ];
                                            $paymentLabels = [
                                                'pending' => 'Menunggu',
                                                'paid' => 'Lunas',
                                                'confirmed' => 'Dikonfirmasi',
                                                'cancelled' => 'Dibatalkan',
                                                'refunded' => 'Dikembalikan',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $paymentColors[$order->payment_status] ?? 'bg-stone-100 text-stone-800' }}">
                                            {{ $paymentLabels[$order->payment_status] ?? $order->payment_status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="inline-flex items-center px-4 py-2 bg-ink text-white text-sm font-medium rounded-lg hover:bg-graphite transition-colors">
                                        Lihat Detail
                                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <nav class="flex items-center justify-between">
                    <div class="text-sm text-silver">
                        Menampilkan {{ $orders->firstItem() ?? 0 }} - {{ $orders->lastItem() ?? 0 }} dari {{ $orders->total() }} pesanan
                    </div>
                    <div class="flex items-center gap-1">
                        {{-- Previous Page --}}
                        @if ($orders->onFirstPage())
                            <span class="px-3 py-2 text-stone-400 cursor-not-allowed rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-2 text-stone-600 hover:bg-stone-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="px-4 py-2 bg-ink text-white rounded-lg font-medium">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 text-stone-600 hover:bg-stone-100 rounded-lg transition-colors">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page --}}
                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-2 text-stone-600 hover:bg-stone-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-2 text-stone-400 cursor-not-allowed rounded-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </div>
                </nav>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl border border-stone-200 p-12 text-center">
                <div class="w-20 h-20 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-ink mb-2">Belum Ada Pesanan</h3>
                <p class="text-silver mb-6">Anda belum memiliki pesanan. Mulai belanja sekarang!</p>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-ink text-white font-medium rounded-lg hover:bg-graphite transition-colors">
                    Mulai Belanja
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
