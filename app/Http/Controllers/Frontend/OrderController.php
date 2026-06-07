<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            // For guests, redirect to home
            return redirect()->route('home');
        }

        $query = Order::query()
            ->where('user_id', auth()->id())
            ->with('items.product')
            ->orderByDesc('created_at');

        // Search by order number
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Allow access if:
        // 1. User is authenticated and owns the order, OR
        // 2. Guest user with valid order in session
        $isGuest = Session::get('guest_order_id') == $order->id;

        if (auth()->check()) {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        } elseif (!$isGuest) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['province', 'city', 'items.product']);

        // Check if there's a Midtrans redirect result
        $paymentStatus = request('payment_status');
        $snapToken = session('snap_token');
        $snapRedirectUrl = session('snap_redirect_url');
        session()->forget(['snap_token', 'snap_redirect_url']);

        return view('frontend.orders.show', compact(
            'order',
            'paymentStatus',
            'snapToken',
            'snapRedirectUrl'
        ));
    }

    /**
     * Show the payment confirmation form.
     */
    public function confirmPayment(Order $order)
    {
        // Allow access if guest with valid order in session
        $isGuest = Session::get('guest_order_id') == $order->id;

        if (auth()->check()) {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        } elseif (!$isGuest) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Only allow confirmation for manual transfer orders
        if ($order->payment_method !== 'manual_transfer') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Konfirmasi pembayaran hanya untuk metode transfer manual.');
        }

        // Only allow confirmation for pending/unpaid orders
        if (!in_array($order->payment_status, ['pending', 'paid'])) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Pesanan ini tidak memerlukan konfirmasi pembayaran.');
        }

        return view('frontend.orders.confirm-payment', compact('order'));
    }

    /**
     * Handle receipt upload.
     */
    public function uploadReceipt(Request $request, Order $order)
    {
        // Allow access if guest with valid order in session
        $isGuest = Session::get('guest_order_id') == $order->id;

        if (auth()->check()) {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }
        } elseif (!$isGuest) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $request->validate([
            'transfer_receipt' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'transfer_date' => 'required|date|before_or_equal:today',
        ], [
            'transfer_receipt.required' => 'Bukti transfer wajib diupload.',
            'transfer_receipt.image' => 'File harus berupa gambar.',
            'transfer_receipt.mimes' => 'Format file harus JPEG, PNG, JPG, GIF, atau WEBP.',
            'transfer_receipt.max' => 'Ukuran file maksimal 2MB.',
            'transfer_date.required' => 'Tanggal transfer wajib diisi.',
            'transfer_date.date' => 'Format tanggal tidak valid.',
            'transfer_date.before_or_equal' => 'Tanggal transfer tidak boleh melebihi hari ini.',
        ]);

        // Store the receipt image
        if ($request->hasFile('transfer_receipt')) {
            // Delete old receipt if exists
            if ($order->transfer_receipt) {
                Storage::disk('public')->delete($order->transfer_receipt);
            }

            $path = $request->file('transfer_receipt')->store('receipts', 'public');
            $order->transfer_receipt = $path;
        }

        $order->transfer_date = $request->transfer_date;
        $order->payment_status = 'paid';
        $order->save();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Bukti transfer berhasil diupload. Tim kami akan memverifikasi pembayaran Anda.');
    }
}