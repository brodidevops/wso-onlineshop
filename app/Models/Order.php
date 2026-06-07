<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
        'email',
        'phone',
        'address',
        'province_id',
        'city_id',
        'postal_code',
        'shipping_courier',
        'shipping_service',
        'shipping_cost',
        'tracking_number',
        'payment_method',
        'payment_status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'midtrans_gross_amount',
        'transfer_receipt',
        'transfer_date',
        'subtotal',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
        'shipping_cost' => 'decimal:0',
        'subtotal' => 'decimal:0',
        'total' => 'decimal:0',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function paymentSetting(): BelongsTo
    {
        return $this->belongsTo(PaymentSetting::class);
    }

    public function getPaymentSettings()
    {
        return PaymentSetting::getSettings();
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'paid' => '<span class="badge badge-info">Dibayar</span>',
            'processing' => '<span class="badge badge-primary">Diproses</span>',
            'shipped' => '<span class="badge badge-info">Dikirim</span>',
            'completed' => '<span class="badge badge-success">Selesai</span>',
            'cancelled' => '<span class="badge badge-danger">Dibatalkan</span>',
        ];
        return $badges[$this->status] ?? $this->status;
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">Menunggu</span>',
            'paid' => '<span class="badge badge-success">Lunas</span>',
            'confirmed' => '<span class="badge badge-success">Dikonfirmasi</span>',
            'cancelled' => '<span class="badge badge-danger">Dibatalkan</span>',
            'refunded' => '<span class="badge badge-secondary">Dikembalikan</span>',
        ];
        return $badges[$this->payment_status] ?? $this->payment_status;
    }

    public function getTransferReceiptUrlAttribute(): ?string
    {
        if (!$this->transfer_receipt) return null;
        return asset('storage/' . $this->transfer_receipt);
    }

    public function decrementStock(): void
    {
        foreach ($this->items as $item) {
            $item->product()->decrement('stock', $item->qty);
        }
    }

    public function incrementStock(): void
    {
        foreach ($this->items as $item) {
            $item->product()->increment('stock', $item->qty);
        }
    }
}