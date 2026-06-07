<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'midtrans_enabled',
        'manual_transfer_enabled',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'payment_instructions',
    ];

    protected $casts = [
        'midtrans_enabled' => 'boolean',
        'manual_transfer_enabled' => 'boolean',
    ];

    /**
     * Get the singleton payment settings instance.
     */
    public static function getSettings(): self
    {
        return static::firstOrCreate([], [
            'midtrans_enabled' => true,
            'manual_transfer_enabled' => true,
            'bank_name' => 'Bank BCA',
            'bank_account_number' => '1234567890',
            'bank_account_holder' => 'Toko Online',
        ]);
    }

    /**
     * Check if at least one payment method is enabled.
     */
    public static function hasActivePaymentMethod(): bool
    {
        $settings = static::getSettings();
        return $settings->midtrans_enabled || $settings->manual_transfer_enabled;
    }
}