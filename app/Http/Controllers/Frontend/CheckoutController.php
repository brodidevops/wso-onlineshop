<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\PaymentSetting;
use App\Models\Province;
use App\Services\MidtransService;
use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    protected RajaOngkirService $rajaOngkir;
    protected MidtransService $midtrans;

    public function __construct(RajaOngkirService $rajaOngkir, MidtransService $midtrans)
    {
        $this->rajaOngkir = $rajaOngkir;
        $this->midtrans = $midtrans;
    }

    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $cartItems = collect($cart);
        $subtotal = $cartItems->sum(fn ($item) => $item['price'] * $item['qty']);
        $totalWeight = $cartItems->sum(fn ($item) => ($item['weight'] ?? 1000) * $item['qty']);

        // Get provinces from database or RajaOngkir
        $provinces = Province::orderBy('name')->get();

        // Get payment settings
        $paymentSettings = PaymentSetting::getSettings();

        // Define courier options
        $couriers = config('rajaongkir.couriers', []);

        return view('frontend.checkout.index', compact(
            'cartItems',
            'subtotal',
            'totalWeight',
            'provinces',
            'paymentSettings',
            'couriers',
        ));
    }

    /**
     * Get cities for a province (AJAX).
     */
    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)
            ->orderBy('type')
            ->orderBy('name')
            ->get(['id', 'type', 'name', 'postal_code']);

        return response()->json($cities);
    }

    /**
     * Get shipping costs from RajaOngkir (AJAX).
     */
    public function getShippingCost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string',
            'weight' => 'required|numeric|min:1',
            'courier' => 'required|string|in:jne,pos,tiki',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $destination = $request->destination;
        $weight = (int) $request->weight;
        $courier = $request->courier;

        // Try to get shipping cost from RajaOngkir
        try {
            $results = $this->rajaOngkir->getShippingCost($destination, $weight, $courier);

            if (!empty($results)) {
                return response()->json([
                    'success' => true,
                    'results' => $results,
                ]);
            }
        } catch (\Exception $e) {
            // Log the error but continue with fallback
            \Log::warning('RajaOngkir API error: ' . $e->getMessage());
        }

        // Fallback: Calculate estimated shipping cost manually
        // Base rate per kg + courier multiplier
        $baseRates = [
            'jne' => 15000,
            'pos' => 12000,
            'tiki' => 14000,
        ];

        $baseRate = $baseRates[$courier] ?? 15000;
        $weightKg = ceil($weight / 1000); // Convert gram to kg, round up
        $estimatedCost = $baseRate * max(1, $weightKg);

        // Calculate estimated days
        $estimatedDays = [
            'jne' => ['min' => 2, 'max' => 5],
            'pos' => ['min' => 3, 'max' => 7],
            'tiki' => ['min' => 1, 'max' => 3],
        ];

        $days = $estimatedDays[$courier] ?? ['min' => 2, 'max' => 5];

        // Create fallback result in RajaOngkir format
        $fallbackResults = [
            [
                'code' => strtoupper($courier),
                'name' => config("rajaongkir.couriers.{$courier}", strtoupper($courier)),
                'costs' => [
                    [
                        'service' => 'REG',
                        'description' => 'Layanan Regular',
                        'cost' => [
                            [
                                'value' => $estimatedCost,
                                'etd' => "{$days['min']}-{$days['max']}",
                                'note' => 'Perkiraan (estimasi)',
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return response()->json([
            'success' => true,
            'results' => $fallbackResults,
            'estimated' => true,
            'message' => 'Ongkir diestimasi. Nilai sebenarnya akan dikonfirmasi setelah pesanan.',
        ]);
    }

    /**
     * Create a new order.
     */
    public function store(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $cartItems = collect($cart);
        $subtotal = $cartItems->sum(fn ($item) => $item['price'] * $item['qty']);
        $totalWeight = $cartItems->sum(fn ($item) => ($item['weight'] ?? 1000) * $item['qty']);

        // Validate shipping selection
        $shippingValidation = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'postal_code' => 'required|string|max:10',
            'shipping_courier' => 'required|string',
            'shipping_service' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:midtrans,manual_transfer',
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'province_id.required' => 'Provinsi wajib dipilih.',
            'city_id.required' => 'Kota/Kabupaten wajib dipilih.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'shipping_courier.required' => 'Kurir pengiriman wajib dipilih.',
            'shipping_service.required' => 'Layanan pengiriman wajib dipilih.',
            'shipping_cost.required' => 'Ongkos kirim wajib dihitung.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ];

        $request->validate($shippingValidation, $messages);

        // Check stock availability for each cart item
        foreach ($cartItems as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if (!$product) {
                return back()->with('error', "Produk tidak ditemukan: {$item['name']}");
            }
            if ($product->stock < $item['qty']) {
                return back()->with('error', "Stok tidak mencukupi untuk {$item['name']}. Tersedia: {$product->stock}");
            }
        }

        $shippingCost = (float) $request->shipping_cost;
        $total = $subtotal + $shippingCost;

        // Create order
        $order = \App\Models\Order::create([
            'user_id' => auth()->id() ?? null,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'shipping_courier' => $request->shipping_courier,
            'shipping_service' => $request->shipping_service,
            'shipping_cost' => $shippingCost,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Store order in session for guest users
        Session::put('guest_order_id', $order->id);

        // Create order items
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'product_sku' => $item['sku'] ?? null,
                'qty' => $item['qty'],
                'price' => $item['price'],
                'weight' => $item['weight'] ?? 1000,
                'subtotal' => $item['price'] * $item['qty'],
            ]);

            // Decrement product stock
            \App\Models\Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
        }

        // Clear cart session
        Session::forget('cart');

        // If Midtrans, create Snap token
        if ($request->payment_method === 'midtrans' && $this->midtrans->isEnabled()) {
            $order->refresh();
            $snapResult = $this->midtrans->createSnapToken($order);

            if ($snapResult['success']) {
                // Update order with Midtrans info
                $order->update([
                    'midtrans_order_id' => $order->order_number,
                ]);

                // Store Snap token in session to be used on confirmation page
                Session::put('midtrans_token', $snapResult['token']);
                Session::put('midtrans_redirect_url', $snapResult['redirect_url']);
            }

            return redirect()->route('orders.show', $order->id)
                ->with('snap_token', $snapResult['token'] ?? null)
                ->with('snap_redirect_url', $snapResult['redirect_url'] ?? null)
                ->with('success', 'Pesanan berhasil dibuat. Silakan selesaikan pembayaran.');
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan selesaikan pembayaran.');
    }
}