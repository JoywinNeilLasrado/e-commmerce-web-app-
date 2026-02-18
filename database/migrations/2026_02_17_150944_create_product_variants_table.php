<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('condition_id')->constrained()->onDelete('cascade');
            $table->string('storage'); // e.g., 64GB, 128GB, 256GB, 512GB, 1TB
            $table->string('color'); // e.g., Space Gray, Gold, Silver
            $table->decimal('price', 10, 2); // Price for this specific variant
            $table->decimal('original_price', 10, 2)->nullable(); // Original price before discount
            $table->integer('stock')->default(0);
            $table->string('sku')->unique(); // Stock Keeping Unit
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            $table->index(['product_id', 'condition_id', 'storage', 'color']);
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
