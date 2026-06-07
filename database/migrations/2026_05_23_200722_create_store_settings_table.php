<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); // Identifies setting group (general, appearance, contact, etc.)
            $table->string('key')->unique(); // Unique key for the setting
            $table->text('value')->nullable(); // Value (can be text, JSON, or serialized data)
            $table->string('type')->default('text'); // Type: text, textarea, image, file, boolean
            $table->string('label')->nullable(); // Human-readable label
            $table->string('description')->nullable(); // Help text or description
            $table->boolean('is_active')->default(true); // Enable/disable setting
            $table->integer('sort')->default(0); // Sort order within group
            $table->json('options')->nullable(); // Additional options (for selects, etc.)
            $table->timestamps();

            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
