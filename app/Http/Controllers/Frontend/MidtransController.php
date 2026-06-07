<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Handle Midtrans notification callback.
     */
    public function notification(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update order with Midtrans data
        $order->update([
            'midtrans_order_id' => $request->order_id,
            'midtrans_transaction_id' => $request->transaction_id,
            'midtrans_payment_type' => $request->payment_type,
            'midtrans_gross_amount' => $request->gross_amount,
        ]);

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status ?? null;

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $order->update([
                    'payment_status' => 'confirmed',
                    'status' => 'paid',
                ]);
                $order->decrementStock();
            }
        } elseif ($transactionStatus === 'settlement') {
            $order->update([
                'payment_status' => 'confirmed',
                'status' => 'paid',
            ]);
            $order->decrementStock();
        } elseif ($transactionStatus === 'pending') {
            $order->update(['payment_status' => 'pending']);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'cancelled',
            ]);
        } elseif ($transactionStatus === 'refund') {
            $order->update(['payment_status' => 'refunded']);
            $order->incrementStock();
        }

        return response()->json(['message' => 'Notification processed']);
    }

    /**
     * Redirect to Midtrans Snap payment page.
     */
    public function pay(Order $order)
    {
        if ($order->payment_method !== 'midtrans') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Metode pembayaran bukan Midtrans');
        }

        if ($order->payment_status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'Pesanan sudah dibayar');
        }

        $result = $this->midtransService->createSnapToken($order);

        if (!$result['success']) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Gagal membuat token pembayaran: ' . $result['error']);
        }

        return view('frontend.midtrans.pay', [
            'order' => $order,
            'snapToken' => $result['token'],
            'clientKey' => $this->midtransService->getClientKey(),
        ]);
    }
}
