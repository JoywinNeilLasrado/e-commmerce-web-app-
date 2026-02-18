<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Models\PhoneModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
    }

    public function test_admin_can_view_products_list()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
    }

    public function test_non_admin_cannot_access_products_management()
    {
        $user = User::factory()->create();
        $user->assignRole('customer');

        $response = $this->actingAs($user)->get(route('admin.products.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Test Brand', 'slug' => 'test-brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Test Model', 'slug' => 'test-model']);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'phone_model_id' => $model->id,
            'title' => 'New Test Phone',
            'base_price' => 50000,
            'description' => 'Great phone',
            'warranty_months' => 12,
            'is_featured' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'title' => 'New Test Phone',
            'base_price' => 50000,
            'slug' => 'new-test-phone'
        ]);
    }

    public function test_admin_can_update_product()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Test Brand', 'slug' => 'test-brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Test Model', 'slug' => 'test-model']);
        
        $product = Product::create([
            'phone_model_id' => $model->id,
            'title' => 'Old Title',
            'slug' => 'old-title',
            'base_price' => 10000,
            'warranty_months' => 6,
            'is_active' => true
        ]);

        $response = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'phone_model_id' => $model->id,
            'title' => 'Updated Title',
            'base_price' => 20000,
            'description' => 'Updated description',
            'warranty_months' => 12,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Title',
            'base_price' => 20000,
        ]);
    }

    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $brand = Brand::create(['name' => 'Test Brand', 'slug' => 'test-brand']);
        $model = PhoneModel::create(['brand_id' => $brand->id, 'name' => 'Test Model', 'slug' => 'test-model']);
        
        $product = Product::create([
            'phone_model_id' => $model->id,
            'title' => 'Delete Me',
            'slug' => 'delete-me',
            'base_price' => 10000,
            'warranty_months' => 6,
            'is_active' => true
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.products.index'));
        // Soft delete check
        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }
}
