<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('midtrans_enabled')->default(true);
            $table->boolean('manual_transfer_enabled')->default(true);
            $table->string('bank_name')->default('Bank BCA');
            $table->string('bank_account_number')->default('1234567890');
            $table->string('bank_account_holder')->default('Toko Online');
            $table->text('payment_instructions')->nullable();
            $table->timestamps();
        });

        // Insert default payment settings
        DB::table('payment_settings')->insert([
            'midtrans_enabled' => true,
            'manual_transfer_enabled' => true,
            'bank_name' => 'Bank BCA',
            'bank_account_number' => '1234567890',
            'bank_account_holder' => 'Toko Online',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};