@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center gap-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600">Beranda</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-indigo-600">Keranjang</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 font-medium">Pesanan #{{ $order->order_number }}</li>
            </ol>
        </nav>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Guest Notice -->
        @guest
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium"> checkout tanpa login</p>
                        <p class="text-sm mt-1">Simpan nomor pesanan <strong>#{{ $order->order_number }}</strong> untuk melacak pesanan Anda.</p>
                        <a href="{{ route('register') }}" class="inline-block mt-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Daftar / Login →
                        </a>
                    </div>
                </div>
            </div>
        @endguest

        <!-- Order Header -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pesanan #{{ $order->order_number }}</h1>
                    <p class="text-gray-500 text-sm mt-1">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Status Badge -->
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                        @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-amber-100 text-amber-800 @endif">
                        @if($order->status === 'pending') Menunggu
                        @elseif($order->status === 'paid') Dibayar
                        @elseif($order->status === 'processing') Diproses
                        @elseif($order->status === 'shipped') Dikirim
                        @elseif($order->status === 'completed') Selesai
                        @elseif($order->status === 'cancelled') Dibatalkan
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Order Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                                    @if(isset($item->product) && $item->product->getFirstMediaUrl('product_images'))
                                        <img src="{{ $item->product->getFirstMediaUrl('product_images', 'thumb') }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-medium text-gray-900 truncate">{{ $item->product_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->qty }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-6 pt-6 border-t border-gray-100 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim ({{ $order->shipping_courier }} {{ $order->shipping_service }})</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-2">
                            <span>Total</span>
                            <span class="text-indigo-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Alamat Tujuan</p>
                            <p class="text-gray-900">{{ $order->name }}</p>
                            <p class="text-gray-700">{{ $order->address }}</p>
                            <p class="text-gray-700">{{ $order->city?->full_name ?? '' }}, {{ $order->province?->name ?? '' }} {{ $order->postal_code }}</p>
                            <p class="text-gray-700 mt-1">{{ $order->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Metode Pengiriman</p>
                            <p class="text-gray-900 font-medium">{{ strtoupper($order->shipping_courier) }} {{ $order->shipping_service }}</p>
                            @if($order->tracking_number)
                                <p class="text-sm text-gray-600 mt-2">
                                    No. Resi: <span class="font-mono font-medium">{{ $order->tracking_number }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Payment Info -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Pembayaran</h2>

                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                            {{ $order->payment_method === 'midtrans' ? 'Midtrans' : 'Transfer Manual' }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($order->payment_status === 'confirmed' || $order->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'cancelled') bg-red-100 text-red-800
                            @else bg-amber-100 text-amber-800 @endif">
                            @if($order->payment_status === 'pending') Menunggu
                            @elseif($order->payment_status === 'paid' || $order->payment_status === 'confirmed') Lunas
                            @elseif($order->payment_status === 'cancelled') Batal
                            @elseif($order->payment_status === 'refunded') Refund
                            @endif
                        </span>
                    </div>

                    <!-- Midtrans Payment Button -->
                    @if($order->payment_method === 'midtrans' && $order->payment_status === 'pending')
                        <a href="{{ route('midtrans.pay', $order) }}"
                           class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Bayar Sekarang
                        </a>
                    @endif

                    <!-- Manual Transfer Instructions -->
                    @if($order->payment_method === 'manual_transfer' && $order->payment_status === 'pending')
                        <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm font-medium text-gray-700 mb-2">Transfer ke:</p>
                            <p class="text-gray-900 font-semibold">{{ $order->paymentSetting->bank_name ?? 'Bank BCA' }}</p>
                            <p class="text-gray-700">No. Rek: {{ $order->paymentSetting->bank_account_number ?? '1234567890' }}</p>
                            <p class="text-gray-700">a/n {{ $order->paymentSetting->bank_account_holder ?? 'Toko Online' }}</p>
                            <p class="text-lg font-bold text-indigo-600 mt-2">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>

                        @if(!$order->transfer_receipt)
                            <a href="{{ route('orders.confirm-payment', $order) }}"
                               class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Upload Bukti Transfer
                            </a>
                        @else
                            <div class="mt-4 p-4 bg-green-50 rounded-xl text-green-800 text-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Bukti transfer sudah diupload
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Butuh Bantuan?</h2>
                    <p class="text-gray-600 text-sm mb-4">Jika ada pertanyaan tentang pesanan Anda, silakan hubungi kami.</p>
                    <a href="#" class="text-indigo-600 font-medium hover:text-indigo-800 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
