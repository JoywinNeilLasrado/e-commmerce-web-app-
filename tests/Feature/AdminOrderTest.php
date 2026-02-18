<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Condition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AdminOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
    }

    public function test_admin_can_view_orders_list()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customer = User::factory()->create();
        $customer->assignRole('customer');
        
        $address = Address::create([
            'user_id' => $customer->id, 
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address_line_1' => '123 St', 
            'city' => 'City', 
            'state' => 'State', 
            'postal_code' => '12345', 
            'country' => 'Country', 
            'is_default' => true
        ]);

        Order::create([
            'user_id' => $customer->id,
            'address_id' => $address->id,
            'status' => 'pending',
            'subtotal' => 50000,
            'total' => 50000,
            'order_number' => 'ORD-TEST-1',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
        $response->assertSee('ORD-TEST-1');
    }

    public function test_non_admin_cannot_view_orders()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

        $response = $this->actingAs($user)->get(route('admin.orders.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_order_details()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        // Setup necessary models
        $address = Address::create([
            'user_id' => $customer->id, 
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address_line_1' => '123 St', 
            'city' => 'City', 
            'state' => 'State', 
            'postal_code' => '12345', 
            'country' => 'Country', 
            'is_default' => true
        ]);
        
        $order = Order::create([
            'user_id' => $customer->id,
            'address_id' => $address->id,
            'status' => 'pending',
            'subtotal' => 50000,
            'total' => 50000,
            'order_number' => 'ORD-TEST-DETAILS',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.orders.show', $order));

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.show');
        $response->assertSee('ORD-TEST-DETAILS');
    }

    public function test_admin_can_update_order_status()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $customer = User::factory()->create();
        
        $address = Address::create([
            'user_id' => $customer->id, 
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address_line_1' => '123 St', 
            'city' => 'City', 
            'state' => 'State', 
            'postal_code' => '12345', 
            'country' => 'Country', 
            'is_default' => true
        ]);
        
        $order = Order::create([
            'user_id' => $customer->id,
            'address_id' => $address->id,
            'status' => 'pending',
            'subtotal' => 50000,
            'total' => 50000,
            'order_number' => 'ORD-TEST-UPDATE',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.orders.update', $order), [
            'status' => 'shipped',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.orders.show', $order));
        
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'shipped',
        ]);
    }
}
