<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the enum to include 'manual_transfer'
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('midtrans', 'manual', 'manual_transfer') DEFAULT 'midtrans'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('midtrans', 'manual') DEFAULT 'midtrans'");
    }
};