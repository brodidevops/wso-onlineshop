<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);

            // Address
            $table->text('address');
            $table->foreignId('province_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('postal_code', 10)->nullable();

            // Shipping
            $table->string('shipping_courier', 50)->nullable();
            $table->string('shipping_service', 100)->nullable();
            $table->decimal('shipping_cost', 15, 0)->default(0);
            $table->string('tracking_number')->nullable();

            // Payment
            $table->enum('payment_method', ['midtrans', 'manual', 'manual_transfer'])->default('midtrans');
            $table->enum('payment_status', ['pending', 'paid', 'confirmed', 'cancelled', 'refunded'])->default('pending');
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->decimal('midtrans_gross_amount', 15, 0)->nullable();
            $table->string('transfer_receipt')->nullable();
            $table->timestamp('transfer_date')->nullable();

            // Totals
            $table->decimal('subtotal', 15, 0)->default(0);
            $table->decimal('total', 15, 0)->default(0);

            // Status
            $table->enum('status', [
                'pending',
                'paid',
                'processing',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};