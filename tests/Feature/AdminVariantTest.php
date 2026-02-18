<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Condition;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AdminVariantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
    }

    public function test_admin_can_view_variants_list()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Model', 'slug' => 'model']);
        $product = Product::create([
            'phone_model_id' => $model->id, 'title' => 'Phone', 'slug' => 'phone', 'base_price' => 100, 'warranty_months' => 12
        ]);

        $response = $this->actingAs($admin)->get(route('admin.products.variants.index', $product));

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.variants.index');
    }

    public function test_admin_can_create_variant()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Model', 'slug' => 'model']);
        $product = Product::create([
            'phone_model_id' => $model->id, 'title' => 'Phone', 'slug' => 'phone', 'base_price' => 100, 'warranty_months' => 12
        ]);
        $condition = Condition::create(['name' => 'New', 'slug' => 'new', 'description' => 'New']);

        $response = $this->actingAs($admin)->post(route('admin.products.variants.store', $product), [
            'condition_id' => $condition->id,
            'color' => 'Black',
            'storage' => '128GB',
            'price' => 15000,
            'stock' => 10,
            'sku' => 'TEST-SKU-123',
            'is_available' => 1,
        ]);

        $response->assertRedirect(route('admin.products.variants.index', $product));
        $this->assertDatabaseHas('product_variants', [
            'sku' => 'TEST-SKU-123',
            'storage' => '128GB',
            'color' => 'Black',
            'stock' => 10
        ]);
    }

    public function test_admin_can_update_variant()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Model', 'slug' => 'model']);
        $product = Product::create([
            'phone_model_id' => $model->id, 'title' => 'Phone', 'slug' => 'phone', 'base_price' => 100, 'warranty_months' => 12
        ]);
        $condition = Condition::create(['name' => 'New', 'slug' => 'new', 'description' => 'New']);
        
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'condition_id' => $condition->id,
            'color' => 'White',
            'storage' => '64GB',
            'price' => 12000,
            'stock' => 5,
            'sku' => 'TEST-SKU-OLD',
            'is_available' => true
        ]);

        $response = $this->actingAs($admin)->put(route('admin.products.variants.update', [$product, $variant]), [
            'condition_id' => $condition->id,
            'color' => 'White',
            'storage' => '128GB', // Changed
            'price' => 14000, // Changed
            'stock' => 8, // Changed
            'sku' => 'TEST-SKU-OLD',
            'is_available' => 1,
        ]);

        $response->assertRedirect(route('admin.products.variants.index', $product));
        $this->assertDatabaseHas('product_variants', [
            'id' => $variant->id,
            'storage' => '128GB',
            'price' => 14000,
            'stock' => 8
        ]);
    }

    public function test_admin_can_delete_variant()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Brand', 'slug' => 'brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Model', 'slug' => 'model']);
        $product = Product::create([
            'phone_model_id' => $model->id, 'title' => 'Phone', 'slug' => 'phone', 'base_price' => 100, 'warranty_months' => 12
        ]);
        $condition = Condition::create(['name' => 'New', 'slug' => 'new', 'description' => 'New']);
        
        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'condition_id' => $condition->id,
            'color' => 'White',
            'storage' => '64GB',
            'price' => 12000,
            'stock' => 5,
            'sku' => 'TEST-SKU-DEL',
            'is_available' => true
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.products.variants.destroy', [$product, $variant]));

        $response->assertRedirect(route('admin.products.variants.index', $product));
        $this->assertDatabaseMissing('product_variants', [
            'id' => $variant->id,
        ]);
    }
}
