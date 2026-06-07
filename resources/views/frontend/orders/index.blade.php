@extends('frontend.layouts.app')

@section('title', 'Pesanan Saya - Toko Online')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <nav class="text-sm text-slate-500 mb-2">
                <a href="{{ route('frontend.index') }}" class="hover:text-navy-800 transition-colors">Beranda</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-navy-800 font-medium">Pesanan Saya</span>
            </nav>
            <h1 class="font-display text-3xl font-bold text-navy-900">Pesanan Saya</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-card text-green-800 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-card text-red-800 text-sm">{{ session('error') }}</div>
        @endif

        @if($orders->isEmpty())
            <div class="card p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <p class="text-slate-600 mb-6">Belum ada pesanan. Yuk, mulai belanja!</p>
                <a href="{{ route('frontend.index') }}" class="btn btn-brand inline-flex items-center gap-2 rounded-pill">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="card p-5 hover:shadow-card transition-shadow duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <!-- Order Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <span class="font-semibold text-navy-900">#{{ $order->order_number }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($order->status === 'pending' || $order->status === 'processing') bg-blue-100 text-blue-800
                                    @else bg-amber-100 text-amber-800
                                    @endif">{{ ucfirst($order->status) }}</span>
                            </div>
                            <p class="text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <!-- Products Preview -->
                        <div class="flex gap-2">
                            @foreach($order->items->take(3) as $item)
                                <div class="w-12 h-12 bg-slate-50 rounded-card overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($item['product']->image ?? null)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product_name'] }}" class="w-full h-full object-contain">
                                    @else
                                        <svg class="w-5 h-5 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <div class="w-12 h-12 bg-slate-100 rounded-card flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-medium text-slate-600">+{{ $order->items->count() - 3 }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Total & Action -->
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <p class="text-xs text-slate-500">Total</p>
                                <p class="font-semibold text-navy-900">{{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('frontend.orders.show', $order->id) }}" class="btn !bg-white !text-navy-900 !border !border-slate-200 hover:!bg-slate-50 rounded-pill">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="flex justify-center mt-8">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        @endif
    </div>
@endsection
