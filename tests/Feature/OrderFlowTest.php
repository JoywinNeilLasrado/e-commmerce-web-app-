<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Address;
use App\Models\Condition;
use App\Models\Brand;
use App\Models\PhoneModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles
        Role::create(['name' => 'customer']);
        Role::create(['name' => 'admin']);
    }

    public function test_customer_can_place_order()
    {
        // 1. Create User
        $user = User::factory()->create();
        $user->assignRole('customer');

        // 2. Create Product & Variant
        $brand = Brand::create(['name' => 'TestBrand', 'slug' => 'test-brand']);
        $phoneModel = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'TestModel', 'slug' => 'test-model']);
        $condition = Condition::create(['name' => 'Excellent', 'slug' => 'excellent', 'sort_order' => 1, 'description' => 'Like new']);
        
        $product = Product::create([
            'phone_model_id' => $phoneModel->id,
            'title' => 'Test Phone',
            'slug' => 'test-phone',
            'base_price' => 10000,
            'is_active' => true,
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'condition_id' => $condition->id,
            'storage' => '128GB',
            'color' => 'Black',
            'price' => 12000,
            'stock' => 10,
            'sku' => 'TEST-SKU-1'
        ]);

        // 3. Login
        $this->actingAs($user);

        // 4. Add to Cart
        $response = $this->post(route('cart.store'), [
            'variant_id' => $variant->id,
            'quantity' => 2,
        ]);
        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('cart_items', [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        // 5. Create Address
        $address = Address::create([
            'user_id' => $user->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'address_line_1' => '123 Test St',
            'city' => 'Test City',
            'state' => 'Test State',
            'postal_code' => '12345',
            'phone' => '9876543210',
            'is_default' => true,
        ]);

        // 6. Checkout
        $response = $this->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'card',
        ]);
        // 7. Assertions
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 24000, // 12000 * 2
            'status' => 'processing', // Should be processing since simulated payment is paid
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
            'price' => 12000,
        ]);

        $this->assertDatabaseHas('payments', [
            'amount' => 24000,
            'payment_method' => 'card',
            'status' => 'completed',
        ]);

        // Stock should decrease
        $this->assertEquals(8, $variant->fresh()->stock);

        // Cart should be empty
        $this->assertDatabaseMissing('cart_items', [
             'product_variant_id' => $variant->id,
        ]);
    }
}
