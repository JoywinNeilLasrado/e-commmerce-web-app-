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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phone_model_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Display title
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2); // Base price before variants
            $table->string('imei')->unique()->nullable(); // IMEI number for tracking
            $table->integer('warranty_months')->default(6); // Warranty in months
            $table->text('whats_in_box')->nullable(); // What's included
            $table->integer('views')->default(0); // For popularity tracking
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['phone_model_id', 'is_active', 'published_at']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
