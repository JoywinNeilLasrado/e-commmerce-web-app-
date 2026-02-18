<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class AdminReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
    }

    public function test_admin_can_view_reports_page()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.reports.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reports.index');
        $response->assertSee('Reports & Analytics');
    }

    public function test_non_admin_cannot_view_reports_page()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

        $response = $this->actingAs($user)->get(route('admin.reports.index'));

        $response->assertStatus(403);
    }

    public function test_reports_page_shows_correct_data()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Create some data
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

        // Create an order
        Order::create([
            'user_id' => $customer->id,
            'address_id' => $address->id,
            'status' => 'delivered',
            'subtotal' => 10000,
            'total' => 10000,
            'order_number' => 'ORD-REPORT-1',
            'created_at' => Carbon::now(),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.reports.index'));

        $response->assertStatus(200);
        // Check if data is passed to view
        $response->assertViewHas(['salesData', 'topProducts', 'orderStatusDist', 'customerGrowth']);
    }
}
