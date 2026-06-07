<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production', false);
        $this->baseUrl = $this->isProduction
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    /**
     * Create a Snap transaction token for an order.
     *
     * @param Order $order
     * @return array
     */
    public function createSnapToken(Order $order): array
    {
        $transactionDetails = [
            'order_id' => $order->order_number,
            'gross_amount' => (int) $order->total,
        ];

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => (int) $item->qty,
                'name' => $item->product_name,
            ];
        })->toArray();

        // Add shipping cost as an item
        $itemDetails[] = [
            'id' => 'SHIPPING',
            'price' => (int) $order->shipping_cost,
            'quantity' => 1,
            'name' => "Pengiriman {$order->shipping_courier} - {$order->shipping_service}",
        ];

        $customerDetails = [
            'first_name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
            'shipping_address' => [
                'first_name' => $order->name,
                'phone' => $order->phone,
                'address' => $order->address,
                'postal_code' => $order->postal_code,
                'city_name' => $order->city?->full_name ?? '',
            ],
        ];

        $payload = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            'callbacks' => [
                'finish' => route('orders.show', $order->id) . '?payment_status=success',
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post("{$this->baseUrl}/snap/v1/transactions", $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'token' => $response->json('token'),
                    'redirect_url' => $response->json('redirect_url'),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('error_messages.0') ?? 'Failed to create Snap token',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get the client key for frontend use.
     *
     * @return string
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Check if Midtrans is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return !empty($this->serverKey) && !empty($this->clientKey);
    }

    /**
     * Get transaction status from Midtrans.
     *
     * @param string $orderId
     * @return array
     */
    public function getTransactionStatus(string $orderId): array
    {
        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->get("{$this->baseUrl}/v1/{$orderId}/status");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to get transaction status',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
