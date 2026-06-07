@extends('frontend.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Midtrans</h1>
            <p class="text-gray-600 mb-2">Order: <span class="font-semibold">{{ $order->order_number }}</span></p>
            <p class="text-3xl font-bold text-indigo-600 mb-8">{{ $order->formatted_total }}</p>
            <p class="text-sm text-gray-500 mb-6">Anda akan diarahkan ke halaman pembayaran Midtrans...</p>
            <button id="pay-button" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-4 px-8 rounded-xl transition-colors shadow-lg shadow-indigo-600/30">
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '/orders/{{ $order->id }}?payment_status=success';
            },
            onPending: function(result) {
                window.location.href = '/orders/{{ $order->id }}?payment_status=pending';
            },
            onError: function(result) {
                window.location.href = '/orders/{{ $order->id }}?payment_status=error';
            },
            onClose: function() {
                // User closed the popup
            }
        });
    });

    // Auto-trigger on page load
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('pay-button').click();
        }, 500);
    });
</script>
@endsection
