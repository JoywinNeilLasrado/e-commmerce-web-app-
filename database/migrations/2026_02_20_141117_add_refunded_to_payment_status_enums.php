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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `orders` MODIFY COLUMN `payment_status` ENUM('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `payments` MODIFY COLUMN `status` ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `orders` MODIFY COLUMN `payment_status` ENUM('pending', 'paid', 'failed') NOT NULL DEFAULT 'pending'");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `payments` MODIFY COLUMN `status` ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending'");
    }
};
