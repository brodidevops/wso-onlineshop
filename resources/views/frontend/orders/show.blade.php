@extends('frontend.layouts.app')

@section('title', 'Detail Pesanan - Toko Online')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Header -->
        <div class="mb-8">
            <nav class="text-sm text-slate-500 mb-2">
                <a href="{{ route('frontend.index') }}" class="hover:text-navy-800 transition-colors">Beranda</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('frontend.orders.index') }}" class="hover:text-navy-800 transition-colors">Pesanan</a>
                <svg class="w-4 h-4 inline-block mx-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-navy-800 font-medium">{{ $order->order_number }}</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="font-display text-3xl font-bold text-navy-900">Detail Pesanan</h1>
                    <p class="text-sm text-slate-500 mt-1">Pesanan #{{ $order->order_number }}</p>
                </div>
                <span class="self-start px-3 py-1 rounded-full text-xs font-medium
                    @if($order->status === 'completed') bg-green-100 text-green-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @elseif($order->status === 'pending' || $order->status === 'processing') bg-blue-100 text-blue-800
                    @else bg-amber-100 text-amber-800
                    @endif">{{ ucfirst($order->status) }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-card text-green-800 text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-card text-red-800 text-sm">{{ session('error') }}</div>
        @endif

        <!-- Midtrans Payment Button -->
        @if(session('snap_token') && \Config::get('midtrans.is_production'))
            <div class="mb-6 p-6 card">
                <h3 class="font-semibold text-navy-900 mb-3">Pembayaran Pesanan</h3>
                <button id="pay-button" class="btn btn-brand rounded-pill !w-full !py-3">
                    Bayar Sekarang
                </button>
                <p class="text-xs text-slate-500 mt-2 text-center">Anda akan diarahkan ke halaman pembayaran yang aman</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Info Card -->
                <div class="card p-6">
                    <h2 class="font-semibold text-navy-900 mb-4">Informasi Pesanan</h2>
                    <div class="grid grid-cols-2 gap-y-4">
                        <div>
                            <span class="text-sm text-slate-500">Order Number</span>
                            <p class="font-medium text-navy-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-500">Tanggal</span>
                            <p class="font-medium text-navy-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-500">Pembayaran</span>
                            <p class="font-medium text-navy-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-500">Status Pembayaran</span>
                            <p class="font-medium text-navy-900 capitalize">{{ str_replace('_', ' ', $order->payment_status) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="card p-6">
                    <h2 class="font-semibold text-navy-900 mb-4">Alamat Pengiriman</h2>
                    <div class="space-y-2 text-sm">
                        <p class="font-medium text-navy-900">{{ $order->name }}</p>
                        <p class="text-slate-600">{{ $order->address }}</p>
                        @if($order->city ?? null)
                            <p class="text-slate-600">{{ $order->city->name }}, {{ $order->province->name ?? '' }} {{ $order->postal_code }}</p>
                        @endif
                        <p class="text-slate-600">{{ $order->phone }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card p-6">
                    <h2 class="font-semibold text-navy-900 mb-4">Produk Dipesan</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex gap-4 pb-4 border-b border-slate-100 last:border-0">
                                <div class="w-16 h-16 bg-slate-50 rounded-card overflow-hidden flex-shrink-0 flex items-center justify-center flex-none">
                                    @if($item['product']->image ?? null)
                                        <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product_name'] }}" class="w-full h-full object-contain">
                                    @else
                                        <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-navy-900 truncate">{{ $item['product_name'] }}</p>
                                    <p class="text-sm text-slate-500">{{ $item['qty'] }} x {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <p class="font-medium text-navy-900 flex-shrink-0">{{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar: Payment Instructions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Payment Instructions -->
                @if($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
                    <div class="card p-6 bg-brand-50 border border-brand-100">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="font-semibold text-navy-900">Instruksi Pembayaran</h3>
                        </div>
                        <div class="space-y-3 text-sm">
                            <p class="text-slate-700">Transfer sesuai total ke rekening berikut:</p>
                            <div class="bg-white rounded-card p-4 border border-brand-200">
                                <p class="text-xs text-slate-500">Bank {{ $paymentSettings->bank_name ?? 'BCA' }}</p>
                                <p class="font-mono font-bold text-navy-900 text-lg mt-1">{{ $paymentSettings->bank_account_number ?? '1234567890' }}</p>
                                <p class="text-sm text-slate-600 mt-1">a.n. {{ $paymentSettings->bank_account_holder ?? 'Toko Online' }}</p>
                            </div>
                            <p class="text-xs text-slate-600">Sertakan order number <strong>#{{ $order->order_number }}</strong> pada keterangan transfer.</p>
                            <button id="notify-btn" class="btn btn-brand rounded-pill !w-full !py-3 mt-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l4 4 8-8m-6 4l4 4 8-8"/></svg>
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Order Summary -->
                <div class="card p-6">
                    <h3 class="font-semibold text-navy-900 mb-4">Ringkasan Biaya</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Subtotal Produk</span>
                            <span class="font-medium text-navy-900">{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($order->shipping_cost > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Pengiriman</span>
                            <span class="font-medium text-navy-900">{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                            <span class="font-semibold text-navy-900">Total</span>
                            <span class="font-display text-xl font-bold text-navy-900">{{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="card p-6">
                    <h3 class="font-semibold text-navy-900 mb-4">Status Pesanan</h3>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="w-0.5 h-full bg-green-200"></div>
                            </div>
                            <div class="pb-3">
                                <p class="text-sm font-medium text-navy-900">Pesanan Dibuat</p>
                                <p class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ in_array($order->payment_status, ['paid', 'pending']) ? 'bg-brand-100 text-brand-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center flex-shrink-0">
                                    {{ in_array($order->payment_status, ['paid', 'pending']) ? '◉' : '○' }}
                                </div>
                                <div class="w-0.5 h-full bg-slate-200"></div>
                            </div>
                            <div class="pb-3">
                                <p class="text-sm font-medium {{ in_array($order->payment_status, ['paid', 'pending']) ? 'text-navy-900' : 'text-slate-400' }}">Pembayaran {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['processing','shipped','completed']) ? 'bg-brand-100 text-brand-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center flex-shrink-0">
                                    {{ in_array($order->status, ['processing','shipped','completed']) ? '◉' : '○' }}
                                </div>
                                <div class="w-0.5 h-full bg-slate-200"></div>
                            </div>
                            <div class="pb-3">
                                <p class="text-sm font-medium {{ in_array($order->status, ['processing','shipped','completed']) ? 'text-navy-900' : 'text-slate-400' }}>Diproses</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ $order->status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center flex-shrink-0">
                                    {{ $order->status === 'completed' ? '✓' : '○' }}
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium {{ $order->status === 'completed' ? 'text-green-700' : 'text-slate-400' }}">Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@if(\Config::get('midtrans.is_production') && session('snap_token'))
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ session('snap_redirect_url') }}', {
            onSuccess: function(result) {
                fetch('{{ route("frontend.orders.pay", $order->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({payment_method: 'midtrans'})
                })
                .then(() => location.reload())
                .catch(() => location.reload());
            },
            onPending: function(result) {
                location.reload();
            },
            onError: function(result) {
                location.reload();
            }
        });
    });
</script>
@endif

<script>
document.getElementById('notify-btn')?.addEventListener('click', function () {
    this.disabled = true;
    this.innerHTML = `<svg class="w-5 h-5 animate-spin inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim...`;
    fetch('{{ route("frontend.orders.notify", $order->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    })
    .then(() => location.reload())
    .catch(() => location.reload());
});
</script>
@endpush
