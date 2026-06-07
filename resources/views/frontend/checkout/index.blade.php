@extends('frontend.layouts.app')

@section('title', 'Checkout - Toko Online')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <nav class="text-sm text-slate-500 mb-2">
                <a href="{{ route('frontend.index') }}" class="hover:text-navy-800 transition-colors">Beranda</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('frontend.cart.index') }}" class="hover:text-navy-800 transition-colors">Keranjang</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-navy-800 font-medium">Checkout</span>
            </nav>
            <h1 class="font-display text-3xl font-bold text-navy-900">Checkout</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-card text-green-800 text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-card text-red-800 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('frontend.checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Information -->
                    <div class="card p-6">
                        <h2 class="font-semibold text-navy-900 mb-5 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-sm font-bold">1</span>
                            Informasi Pengiriman
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="input @error('name') border-red-500 @enderror" required />
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="input @error('phone') border-red-500 @enderror" required />
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea id="address" name="address" rows="3" class="input @error('address') border-red-500 @enderror resize-none" required>{{ old('address') }}</textarea>
                                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="province_id" class="block text-sm font-medium text-slate-700 mb-1.5">Provinsi <span class="text-red-500">*</span></label>
                                <select id="province_id" name="province_id" class="input @error('province_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('province_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="city_id" class="block text-sm font-medium text-slate-700 mb-1.5">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                <select id="city_id" name="city_id" class="input @error('city_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Provinsi terlebih dahulu</option>
                                </select>
                                @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-slate-700 mb-1.5">Kode Pos</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" class="input" />
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="card p-6">
                        <h2 class="font-semibold text-navy-900 mb-5 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-sm font-bold">2</span>
                            Metode Pengiriman
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                            @foreach($couriers as $code => $name)
                                <label class="cursor-pointer">
                                    <input type="radio" name="shipping_courier" value="{{ $code }}" class="sr-only peer" @if($loop->first) checked @endif />
                                    <div class="border-2 border-slate-200 rounded-card p-3 text-center cursor-pointer transition-all peer-checked:!border-brand-600 peer-checked:!bg-brand-50 hover:border-slate-300">
                                        <span class="font-semibold text-navy-900">{{ $name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <select name="shipping_service" id="shipping_service" class="input w-full mb-3" required>
                            <option value="">Pilih layanan pengiriman</option>
                        </select>
                        <p id="shippingMsg" class="text-xs text-slate-500"></p>
                    </div>

                    <!-- Payment Method -->
                    <div class="card p-6">
                        <h2 class="font-semibold text-navy-900 mb-5 flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-sm font-bold">3</span>
                            Metode Pembayaran
                        </h2>
                        <div class="space-y-3">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="midtrans" class="sr-only peer" {{ \Config::get('midtrans.is_production') ? 'checked' : '' }} />
                                <div class="border-2 border-slate-200 rounded-card p-4 flex items-center justify-between cursor-pointer transition-all duration-200 peer-checked:!border-brand-600 peer-checked:!bg-brand-50 hover:border-slate-300 peer-hover:!border-slate-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-card bg-slate-100 flex items-center justify-center text-slate-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                        </div>
                                        <div>
                                            <span class="font-medium text-navy-900 block">Midtrans</span>
                                            <span class="text-sm text-slate-500">Kartu Kredit, E-Wallet, QRIS</span>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-brand-600 peer-checked:block hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer" {{ !\Config::get('midtrans.is_production') ? 'checked' : '' }} />
                                <div class="border-2 border-slate-200 rounded-card p-4 flex items-center justify-between cursor-pointer transition-all duration-200 peer-checked:!border-brand-600 peer-checked:!bg-brand-50 hover:border-slate-300 peer-hover:!border-slate-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-card bg-slate-100 flex items-center justify-center text-slate-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                                        </div>
                                        <div>
                                            <span class="font-medium text-navy-900 block">Transfer Bank Manual</span>
                                            <span class="text-sm text-slate-500">{{ $paymentSettings->bank_name ?? 'BCA' }}</span>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-brand-600 peer-checked:block hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="card p-5 sticky top-20">
                        <h3 class="font-semibold text-navy-900 mb-4">Ringkasan Pesanan</h3>

                        <!-- Cart Items -->
                        <div class="space-y-3 mb-4 max-h-56 overflow-y-auto">
                            @forelse($cartItems as $item)
                                <div class="flex gap-3">
                                    <div class="w-12 h-12 bg-slate-50 rounded-card overflow-hidden flex-shrink-0 flex items-center justify-center flex-none">
                                        @if($item['product']->image ?? null)
                                            <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['name'] }}" class="w-full h-full object-contain">
                                        @else
                                            <svg class="w-5 h-5 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-navy-800 truncate">{{ Str::limit($item['name'], 25) }}</p>
                                        <p class="text-xs text-slate-500">{{ $item['qty'] }} x {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 text-center py-3">Keranjang kosong</p>
                            @endforelse
                        </div>

                        <div class="space-y-3 mb-4 pt-4 border-t border-slate-100">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Subtotal</span>
                                <span class="font-medium text-navy-900">{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm" id="shippingCostRow" style="display: none;">
                                <span class="text-slate-600">Pengiriman</span>
                                <span class="font-medium text-navy-900" id="shippingCostValue">-</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                                <span class="font-semibold text-navy-900">Total</span>
                                <span class="font-display text-xl font-bold text-navy-900" id="grandTotal">{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brand !w-full !py-3.5 rounded-pill text-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-calculate shipping when province/city/courier changes
    function calculateShipping() {
        const cityId = document.getElementById('city_id').value;
        const weight = '{{ $totalWeight }}';
        const courier = document.querySelector('input[name="shipping_courier"]:checked')?.value || 'jne';
        const serviceEl = document.getElementById('shipping_service');
        const msg = document.getElementById('shippingMsg');

        if (!cityId) return;

        fetch(`/checkout/shipping-cost?destination=${cityId}&weight=${weight}&courier=${courier}`)
            .then(res => res.json())
            .then(data => {
                serviceEl.innerHTML = '';
                if (data.results && data.results.length > 0) {
                    data.results.forEach(result => {
                        result.costs.forEach(cost => {
                            const opt = document.createElement('option');
                            opt.value = cost.value;
                            opt.dataset.service = cost.service;
                            opt.dataset.courier = result.code;
                            opt.textContent = `${cost.service} — ${cost.etd} hari — Rp${cost.value.toLocaleString('id-ID')}`;
                            serviceEl.appendChild(opt);
                        });
                    });
                }
                msg.textContent = data.message || '';
                msg.className = 'text-xs text-slate-500 mt-2';
            })
            .catch(() => {
                msg.textContent = 'Gagal memuat ongkir.';
                msg.className = 'text-xs text-red-500 mt-2';
            });
    }

    // Update grand total
    function updateTotal() {
        const costOpt = document.getElementById('shipping_service');
        if (costOpt.options.length === 0) return;
        const cost = parseFloat(costOpt.value) || 0;
        const shippingRow = document.getElementById('shippingCostRow');
        const subtotal = {{ $subtotal }};
        const total = subtotal + cost;

        document.getElementById('shippingCostValue').textContent = 'Rp' + cost.toLocaleString('id-ID');
        document.getElementById('grandTotal').textContent = 'Rp' + total.toLocaleString('id-ID');
        shippingRow.style.display = cost > 0 ? 'flex' : 'none';

        // Set hidden shipping cost fields
        const hiddenCourier = document.getElementById('hidden_courier');
        const hiddenService = document.getElementById('hidden_service');
        if (hiddenCourier) hiddenCourier.value = costOpt.options[costOpt.selectedIndex]?.dataset?.courier || '';
        if (hiddenService) hiddenService.value = costOpt.options[costOpt.selectedIndex]?.dataset?.service || '';
    }

    document.getElementById('city_id').addEventListener('change', function () {
        document.getElementById('shipping_service').innerHTML = '<option value="">Pilih layanan pengiriman</option>';
        document.getElementById('shippingMsg').textContent = '';
        calculateShipping();
    });

    document.querySelectorAll('input[name="shipping_courier"]').forEach(radio => {
        radio.addEventListener('change', calculateShipping);
    });

    document.getElementById('shipping_service').addEventListener('change', updateTotal);
</script>
@endpush
