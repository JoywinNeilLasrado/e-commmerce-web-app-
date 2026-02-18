<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('wishlist_items');
    }

    public function down(): void
    {
        // Not needed since we're using wishlists table directly
    }
};
