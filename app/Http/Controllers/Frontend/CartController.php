<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display cart contents.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = collect($cart);
        $subtotal = $cartItems->sum(fn ($item) => $item['price'] * $item['qty']);
        $totalWeight = $cartItems->sum(fn ($item) => ($item['weight'] ?? 0) * $item['qty']);

        return view('frontend.cart.index', compact(
            'cartItems',
            'subtotal',
            'totalWeight'
        ));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'qty' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('cart.index')->with('login_required', true);
        }

        $qty = $request->qty ?? 1;
        $cart = session()->get('cart', []);

        // Check if product already in cart
        if (isset($cart[$productId])) {
            $newQty = $cart[$productId]['qty'] + $qty;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $cart[$productId]['qty'] = $newQty;
        } else {
            // Get product image
            $image = null;
            if ($product->getFirstMedia('product_images')) {
                $image = $product->getFirstMedia('product_images')->getUrl('thumb');
            }

            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'weight' => $product->weight ?? 1000,
                'image' => $image,
                'stock' => $product->stock,
                'qty' => $qty,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $qty = $request->qty;

        if ($qty <= 0) {
            // Remove item if qty is 0 or less
            unset($cart[$productId]);
        } else {
            // Check stock
            $stock = $cart[$productId]['stock'] ?? 0;
            if ($qty > $stock) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $cart[$productId]['qty'] = $qty;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove item from cart.
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}