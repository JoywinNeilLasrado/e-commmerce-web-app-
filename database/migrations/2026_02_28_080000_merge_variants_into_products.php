<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add variant columns to products table
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('condition_id')->nullable()->after('phone_model_id')->constrained()->nullOnDelete();
            $table->string('storage')->nullable()->after('original_price');
            $table->string('color')->nullable()->after('storage');
            $table->decimal('price', 10, 2)->default(0)->after('color');
            $table->integer('stock')->default(0)->after('price');
            $table->string('sku')->nullable()->unique()->after('stock');
            $table->boolean('is_available')->default(true)->after('sku');
        });

        // Step 2: Migrate data from product_variants into products
        // For each variant, create a new product row with parent product data + variant data
        $variants = DB::table('product_variants')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->select(
                'product_variants.*',
                'products.phone_model_id',
                'products.title as parent_title',
                'products.slug as parent_slug',
                'products.description',
                'products.primary_image',
                'products.base_price as parent_base_price',
                'products.original_price as parent_original_price',
                'products.imei',
                'products.warranty_months',
                'products.whats_in_box',
                'products.views',
                'products.is_featured',
                'products.is_active',
                'products.published_at'
            )
            ->whereNull('products.deleted_at')
            ->get();

        // Map old variant IDs to new product IDs for updating cart/order items
        $variantToProductMap = [];

        foreach ($variants as $variant) {
            // Build a unique slug incorporating variant details
            $slug = $variant->parent_slug . '-' . \Illuminate\Support\Str::slug($variant->storage . '-' . $variant->color);
            
            // Ensure unique slug
            $baseSlug = $slug;
            $counter = 1;
            while (DB::table('products')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            // Build title incorporating variant details
            $title = $variant->parent_title . ' - ' . $variant->storage . ' ' . $variant->color;

            $newProductId = DB::table('products')->insertGetId([
                'phone_model_id' => $variant->phone_model_id,
                'condition_id' => $variant->condition_id,
                'title' => $title,
                'slug' => $slug,
                'description' => $variant->description,
                'primary_image' => $variant->primary_image,
                'base_price' => $variant->price,
                'original_price' => $variant->original_price ?? $variant->parent_original_price,
                'storage' => $variant->storage,
                'color' => $variant->color,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'sku' => $variant->sku,
                'is_available' => $variant->is_available,
                'imei' => null, // Variants don't have unique IMEIs; parent IMEI stays on original product
                'warranty_months' => $variant->warranty_months,
                'whats_in_box' => $variant->whats_in_box,
                'views' => $variant->views ?? 0,
                'is_featured' => $variant->is_featured ?? false,
                'is_active' => $variant->is_active ?? true,
                'published_at' => $variant->published_at,
                'created_at' => $variant->created_at,
                'updated_at' => now(),
            ]);

            $variantToProductMap[$variant->id] = $newProductId;
        }

        // Step 3: Update cart_items — rename column and re-point IDs
        // First add the new column
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('cart_id');
        });

        // Update existing cart items
        foreach ($variantToProductMap as $oldVariantId => $newProductId) {
            DB::table('cart_items')
                ->where('product_variant_id', $oldVariantId)
                ->update(['product_id' => $newProductId]);
        }

        // Drop old column and add foreign key
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // Step 4: Update order_items — same approach
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('order_id');
        });

        foreach ($variantToProductMap as $oldVariantId => $newProductId) {
            DB::table('order_items')
                ->where('product_variant_id', $oldVariantId)
                ->update(['product_id' => $newProductId]);
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
        });

        // Step 5: Drop old parent products that have been flattened (they had variants)
        $parentIdsWithVariants = DB::table('product_variants')->distinct()->pluck('product_id');
        if ($parentIdsWithVariants->isNotEmpty()) {
            // Soft-delete old parent products (they've been replaced by flattened variants)
            DB::table('products')
                ->whereIn('id', $parentIdsWithVariants)
                ->whereNull('condition_id') // Only delete the old parent entries
                ->update(['deleted_at' => now()]);
        }

        // Step 6: Drop product_variants table
        Schema::dropIfExists('product_variants');
    }

    public function down(): void
    {
        // This migration is not easily reversible. Restore from backup.
        // To rollback: restore from backup_before_flatten.sql
    }
};
