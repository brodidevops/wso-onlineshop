@extends('frontend.layouts.app')

@section('title', 'Checkout - Toko Online')

@push('styles')
<style>
    .step-indicator {
        position: relative;
    }
    .step-indicator::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e5e7eb;
        z-index: 0;
    }
    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        z-index: 10;
        position: relative;
        background: white;
        border: 2px solid #d1d5db;
        color: #78716c;
        transition: all 0.2s ease;
    }
    .step-circle.active {
        border-color: #1A1A1A;
        background: #1A1A1A;
        color: white;
    }
    .step-circle.completed {
        border-color: #1A1A1A;
        background: #1A1A1A;
        color: white;
    }
    .step-label {
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.5rem;
        color: #78716c;
    }
    .step-label.active {
        color: #1A1A1A;
    }
    .courier-card {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid #e5e7eb;
    }
    .courier-card:hover {
        border-color: #a8a29e;
    }
    .courier-card.selected {
        border-color: #1A1A1A;
        background: #fafaf9;
    }
    .courier-card input[type="radio"] {
        display: none;
    }
    .service-option {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .service-option:hover {
        background: #fafaf9;
    }
    .service-option.selected {
        background: #fafaf9;
        border-color: #1A1A1A;
    }
    .payment-card {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid #e5e7eb;
    }
    .payment-card:hover {
        border-color: #a8a29e;
    }
    .payment-card.selected {
        border-color: #1A1A1A;
        background: #fafaf9;
    }
    .payment-card input[type="radio"] {
        display: none;
    }
    .order-summary-sticky {
        position: sticky;
        top: 100px;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        <p class="mt-1 text-gray-600">Lengkapi data pesanan dan pembayaran Anda</p>
    </div>

    <!-- Step Indicator -->
    <div class="mb-10 step-indicator">
        <div class="flex items-start justify-between max-w-3xl mx-auto">
            <!-- Step 1: Alamat -->
            <div class="step-item flex-1 flex flex-col items-center {{ $errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('address') || $errors->has('province_id') || $errors->has('city_id') || $errors->has('postal_code') ? '' : 'active' }}">
                <div class="step-circle active">1</div>
                <span class="step-label active text-center">Alamat</span>
            </div>
            <!-- Step 2: Pengiriman -->
            <div class="step-item flex-1 flex flex-col items-center {{ $errors->has('shipping_courier') || $errors->has('shipping_service') || $errors->has('shipping_cost') ? '' : 'active' }}">
                <div class="step-circle {{ $errors->has('shipping_courier') || $errors->has('shipping_service') || $errors->has('shipping_cost') ? '' : 'active' }}">2</div>
                <span class="step-label {{ $errors->has('shipping_courier') || $errors->has('shipping_service') || $errors->has('shipping_cost') ? '' : 'active' }} text-center">Pengiriman</span>
            </div>
            <!-- Step 3: Pembayaran -->
            <div class="step-item flex-1 flex flex-col items-center {{ $errors->has('payment_method') ? '' : 'active' }}">
                <div class="step-circle {{ $errors->has('payment_method') ? '' : 'active' }}">3</div>
                <span class="step-label {{ $errors->has('payment_method') ? '' : 'active' }} text-center">Pembayaran</span>
            </div>
            <!-- Step 4: Konfirmasi -->
            <div class="step-item flex-1 flex flex-col items-center">
                <div class="step-circle">4</div>
                <span class="step-label text-center">Konfirmasi</span>
            </div>
        </div>
    </div>

    <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Forms -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Step 1: Alamat Pengiriman -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-white">Alamat Pengiriman</h2>
                    </div>

                    <div class="p-6 space-y-5">
                        <!-- Name & Email Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('email') border-red-500 @enderror"
                                    placeholder="email@contoh.com" required>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                No. WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('phone') border-red-500 @enderror"
                                placeholder="08xxxxxxxxxx" required>
                            @error('phone')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="3"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow resize-none @error('address') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap (jalan, nomor rumah, RT/RW, kelurahan, kecamatan)" required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Province & City Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <select id="province-select" name="province_id"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('province_id') border-red-500 @enderror"
                                    required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                <select id="city-select" name="city_id"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('city_id') border-red-500 @enderror"
                                    required {{ old('city_id') ? '' : 'disabled' }}>
                                    <option value="">-- Pilih Kota/Kabupaten --</option>
                                    @if(old('city_id') && old('province_id'))
                                        @php
                                            $cities = \App\Models\City::where('province_id', old('province_id'))->orderBy('type')->orderBy('name')->get();
                                        @endphp
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->type }} {{ $city->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('city_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Kode Pos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('postal_code') border-red-500 @enderror"
                                placeholder="12345" maxlength="10" required>
                            @error('postal_code')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: Metode Pengiriman -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-white">Metode Pengiriman</h2>
                    </div>

                    <div class="p-6">
                        <!-- Courier Selection -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Kurir</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach($couriers as $code => $name)
                                    <label class="courier-card rounded-xl p-4 flex flex-col items-center gap-2" data-courier="{{ $code }}">
                                        <input type="radio" name="shipping_courier" value="{{ $code }}"
                                            {{ old('shipping_courier') == $code ? 'checked' : '' }}
                                            class="courier-radio" required>
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            @if($code === 'jne')
                                                <span class="text-xs font-bold text-blue-600">JNE</span>
                                            @elseif($code === 'pos')
                                                <span class="text-xs font-bold text-red-600">POS</span>
                                            @else
                                                <span class="text-xs font-bold text-orange-600">TIKI</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ $name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('shipping_courier')
                                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City ID Hidden Field -->
                        <input type="hidden" id="destination-city-id" value="{{ old('city_id') }}">

                        <!-- Shipping Cost Loading State -->
                        <div id="shipping-loading" class="hidden py-8 text-center">
                            <div class="inline-flex items-center gap-2 text-sm text-gray-500">
                                <svg class="animate-spin w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Menghitung ongkir...
                            </div>
                        </div>

                        <!-- Shipping Services -->
                        <div id="shipping-services" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Layanan Pengiriman</label>
                            <div id="service-list" class="space-y-2">
                                <!-- Services will be loaded dynamically -->
                            </div>
                            @error('shipping_service')
                                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Courier Selected -->
                        <div id="shipping-placeholder" class="py-8 text-center">
                            <div class="inline-flex items-center gap-2 text-sm text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pilih kurir terlebih dahulu untuk melihat layanan pengiriman
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Metode Pembayaran -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-white">Metode Pembayaran</h2>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($paymentSettings->midtrans_enabled)
                                <label class="payment-card rounded-xl p-5 flex flex-col gap-3" data-payment="midtrans">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="payment_method" value="midtrans"
                                                {{ old('payment_method') == 'midtrans' || (!$paymentSettings->manual_transfer_enabled && $paymentSettings->midtrans_enabled) ? 'checked' : '' }}>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-800">Midtrans</span>
                                                <p class="text-xs text-gray-500 mt-0.5">Pembayaran online aman via bank/e-wallet</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @endif

                            @if($paymentSettings->manual_transfer_enabled)
                                <label class="payment-card rounded-xl p-5 flex flex-col gap-3" data-payment="manual_transfer">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="payment_method" value="manual_transfer"
                                                {{ old('payment_method') == 'manual_transfer' || (!$paymentSettings->midtrans_enabled && $paymentSettings->manual_transfer_enabled) ? 'checked' : '' }}>
                                            <div>
                                                <span class="text-sm font-semibold text-gray-800">Transfer Manual</span>
                                                <p class="text-xs text-gray-500 mt-0.5">Transfer ke rekening {{ $paymentSettings->bank_name }}</p>
                                            </div>
                                        </div>
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>
                        @error('payment_method')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Manual Transfer Info Box -->
                        @if($paymentSettings->manual_transfer_enabled)
                            <div id="manual-transfer-info" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl hidden">
                                <h4 class="text-sm font-semibold text-green-800 mb-2">Informasi Transfer</h4>
                                <div class="text-sm text-green-700 space-y-1">
                                    <p><strong>Bank:</strong> {{ $paymentSettings->bank_name }}</p>
                                    <p><strong>No. Rekening:</strong> {{ $paymentSettings->bank_account_number }}</p>
                                    <p><strong>Atas Nama:</strong> {{ $paymentSettings->bank_account_holder }}</p>
                                </div>
                                <p class="mt-2 text-xs text-green-600"> Setelah berhasil membuat pesanan, harap upload bukti transfer di halaman detail pesanan.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Catatan Pesanan (Opsional)</h2>
                    </div>
                    <div class="p-6">
                        <textarea name="notes" rows="3"
                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow resize-none"
                            placeholder="Tambahkan catatan untuk pesanan ini (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1">
                <div class="order-summary-sticky">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="font-semibold text-gray-800">Ringkasan Pesanan</h3>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Cart Items -->
                            <div class="space-y-3 max-h-72 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-3">
                                        @if(!empty($item['image']))
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                class="w-14 h-14 rounded-lg object-cover flex-shrink-0 bg-gray-100">
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $item['qty'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 pt-4 space-y-2">
                                <!-- Weight Info -->
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Berat Total</span>
                                    <span class="text-gray-700 font-medium">{{ number_format($totalWeight, 0, ',', '.') }} gram</span>
                                </div>

                                <!-- Subtotal -->
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Subtotal</span>
                                    <span class="text-gray-700 font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>

                                <!-- Shipping Cost -->
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Ongkos Kirim</span>
                                    <span id="shipping-cost-display" class="text-gray-700 font-medium">--
                                        @error('shipping_cost')
                                            <span class="text-xs text-red-500">({{ $message }})</span>
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span id="total-display" class="text-base font-bold text-blue-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Hidden Inputs -->
                            <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="{{ old('shipping_cost') }}">
                            <input type="hidden" name="shipping_service" id="shipping-service-input" value="{{ old('shipping_service') }}">

                            <!-- Submit Button -->
                            <button type="submit" id="submit-btn"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ !old('shipping_cost') ? 'disabled' : '' }}>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Buat Pesanan
                            </button>

                            <p class="text-xs text-gray-400 text-center">
                                Dengan membuat pesanan, Anda menyetujui
                                <a href="#" class="underline hover:text-gray-600">Syarat & Ketentuan</a> kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province-select');
    const citySelect = document.getElementById('city-select');
    const destinationCityId = document.getElementById('destination-city-id');
    const courierRadios = document.querySelectorAll('.courier-radio');
    const shippingPlaceholder = document.getElementById('shipping-placeholder');
    const shippingLoading = document.getElementById('shipping-loading');
    const shippingServices = document.getElementById('shipping-services');
    const serviceList = document.getElementById('service-list');
    const shippingCostDisplay = document.getElementById('shipping-cost-display');
    const totalDisplay = document.getElementById('total-display');
    const shippingCostInput = document.getElementById('shipping-cost-input');
    const shippingServiceInput = document.getElementById('shipping-service-input');
    const submitBtn = document.getElementById('submit-btn');
    const paymentCards = document.querySelectorAll('.payment-card');
    const manualTransferInfo = document.getElementById('manual-transfer-info');
    const courierCards = document.querySelectorAll('.courier-card');

    const subtotal = {{ $subtotal }};

    // Province change - load cities
    provinceSelect.addEventListener('change', function () {
        const provinceId = this.value;
        citySelect.innerHTML = '<option value="">-- Memuat kota... --</option>';
        citySelect.disabled = true;

        if (!provinceId) {
            citySelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
            return;
        }

        fetch(`/checkout/get-cities/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                citySelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = `${city.type} ${city.name}`;
                    citySelect.appendChild(option);
                });
                citySelect.disabled = false;
            })
            .catch(error => {
                citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                console.error('Error loading cities:', error);
            });
    });

    // Courier card selection
    courierCards.forEach(card => {
        card.addEventListener('click', function () {
            const radio = this.querySelector('input[type="radio"]');
            courierRadios.forEach(r => r.checked = false);
            radio.checked = true;
            courierCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            loadShippingCost();
        });
    });

    // Auto-select courier if pre-selected
    const selectedCourier = document.querySelector('input[name="shipping_courier"]:checked');
    if (selectedCourier) {
        selectedCourier.closest('.courier-card').classList.add('selected');
    }

    // City change - trigger shipping cost calculation
    citySelect.addEventListener('change', function () {
        destinationCityId.value = this.value;
        loadShippingCost();
    });

    function loadShippingCost() {
        const cityId = citySelect.value;
        const courier = document.querySelector('input[name="shipping_courier"]:checked')?.value;

        if (!cityId || !courier) {
            return;
        }

        shippingPlaceholder.classList.add('hidden');
        shippingServices.classList.add('hidden');
        shippingLoading.classList.remove('hidden');
        serviceList.innerHTML = '';

        fetch('/checkout/get-shipping-cost', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                destination: cityId,
                weight: {{ $totalWeight }},
                courier: courier,
            }),
        })
        .then(response => response.json())
        .then(data => {
            shippingLoading.classList.add('hidden');

            if (data.success && data.results && data.results.length > 0) {
                const result = data.results[0];
                displayServices(result.costs);

                // Show estimated warning if using fallback calculation
                if (data.estimated) {
                    shippingServices.insertAdjacentHTML('beforebegin',
                        '<div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-700">' +
                        '<strong>Catatan:</strong> ' + data.message +
                        '</div>'
                    );
                }
            } else if (data.message) {
                serviceList.innerHTML = '<p class="text-sm text-red-500 py-4 text-center">' + data.message + '</p>';
                shippingServices.classList.remove('hidden');
            } else if (data.error) {
                serviceList.innerHTML = '<p class="text-sm text-red-500 py-4 text-center">' + data.error + '</p>';
                shippingServices.classList.remove('hidden');
            } else {
                serviceList.innerHTML = '<p class="text-sm text-red-500 py-4 text-center">Gagal memuat layanan. Pastikan semua data sudah diisi dengan benar.</p>';
                shippingServices.classList.remove('hidden');
            }
        })
        .catch(error => {
            shippingLoading.classList.add('hidden');
            let errorMsg = 'Terjadi kesalahan koneksi.';
            if (error.message) {
                errorMsg += ' Detail: ' + error.message;
            }
            serviceList.innerHTML = '<p class="text-sm text-red-500 py-4 text-center">' + errorMsg + '</p>';
            shippingServices.classList.remove('hidden');
            console.error('Error loading shipping cost:', error);
        });
    }

    function displayServices(costs) {
        if (!costs || costs.length === 0) {
            shippingPlaceholder.classList.remove('hidden');
            return;
        }

        shippingServices.classList.remove('hidden');
        serviceList.innerHTML = '';

        costs.forEach((cost, index) => {
            const serviceName = cost.service;
            const description = cost.description;
            const etd = cost.cost[0]?.etd || '-';
            const value = cost.cost[0]?.value || 0;
            const isSelected = shippingServiceInput.value === serviceName;

            const div = document.createElement('div');
            div.className = `service-option border rounded-xl p-4 flex items-center justify-between ${isSelected ? 'selected border-blue-500' : 'border-gray-200'}`;
            div.dataset.service = serviceName;
            div.dataset.cost = value;

            div.innerHTML = `
                <label class="flex items-center gap-3 cursor-pointer flex-1">
                    <input type="radio" name="shipping_service_option" value="${serviceName}"
                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                        ${isSelected ? 'checked' : ''}>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-semibold text-gray-800">${description}</span>
                            <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">${serviceName}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Estimasi: ${etd} hari</p>
                    </div>
                </label>
                <span class="text-sm font-bold text-gray-900">Rp ${value.toLocaleString('id-ID')}</span>
            `;

            div.addEventListener('click', function () {
                document.querySelectorAll('.service-option').forEach(el => {
                    el.classList.remove('selected', 'border-blue-500');
                    el.classList.add('border-gray-200');
                });
                this.classList.add('selected', 'border-blue-500');
                this.classList.remove('border-gray-200');
                this.querySelector('input[type="radio"]').checked = true;

                const service = this.dataset.service;
                const cost = parseInt(this.dataset.cost);

                shippingServiceInput.value = service;
                shippingCostInput.value = cost;
                shippingCostDisplay.textContent = `Rp ${cost.toLocaleString('id-ID')}`;

                const total = subtotal + cost;
                totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;

                submitBtn.disabled = false;
            });

            serviceList.appendChild(div);
        });
    }

    // Payment card selection
    paymentCards.forEach(card => {
        card.addEventListener('click', function () {
            const radio = this.querySelector('input[type="radio"]');
            document.querySelectorAll('input[name="payment_method"]').forEach(r => r.checked = false);
            radio.checked = true;
            paymentCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');

            const payment = this.dataset.payment;
            if (payment === 'manual_transfer' && manualTransferInfo) {
                manualTransferInfo.classList.remove('hidden');
            } else if (manualTransferInfo) {
                manualTransferInfo.classList.add('hidden');
            }
        });
    });

    // Initialize payment card selection
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (selectedPayment) {
        selectedPayment.closest('.payment-card').classList.add('selected');
        if (selectedPayment.value === 'manual_transfer' && manualTransferInfo) {
            manualTransferInfo.classList.remove('hidden');
        }
    }

    // Restore selected shipping from old input
    if (shippingServiceInput.value && shippingCostInput.value) {
        shippingCostDisplay.textContent = `Rp ${parseInt(shippingCostInput.value).toLocaleString('id-ID')}`;
        const total = subtotal + parseInt(shippingCostInput.value);
        totalDisplay.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        submitBtn.disabled = false;
    }
});
</script>
@endpush