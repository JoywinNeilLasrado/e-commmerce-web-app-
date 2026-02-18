<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained();
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Price at time of order
            $table->decimal('subtotal', 10, 2);
            
            // Store phone details at time of purchase
            $table->string('phone_title');
            $table->string('storage');
            $table->string('color');
            $table->string('condition');
            $table->timestamps();
            
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
