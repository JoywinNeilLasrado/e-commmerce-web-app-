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
        Schema::create('phone_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., iPhone 14 Pro, Galaxy S23 Ultra
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            // Specifications
            $table->string('display_size')->nullable(); // e.g., 6.1 inches
            $table->string('display_type')->nullable(); // e.g., OLED
            $table->string('processor')->nullable(); // e.g., A16 Bionic
            $table->string('ram')->nullable(); // e.g., 6GB
            $table->string('camera')->nullable(); // e.g., 48MP + 12MP + 12MP
            $table->string('battery')->nullable(); // e.g., 3200 mAh
            $table->string('os')->nullable(); // e.g., iOS 16
            $table->string('dimensions')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
    
            $table->index(['brand_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_models');
    }
};
