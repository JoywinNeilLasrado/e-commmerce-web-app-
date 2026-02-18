<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertSee($user->name);
    }

    public function test_user_can_update_profile_info()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_user_can_add_address()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('profile.address.store'), [
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address_line_1' => '123 Test St',
            'city' => 'Test City',
            'state' => 'Test State',
            'postal_code' => '12345',
            'country' => 'Test Country',
            'is_default' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'label' => 'Home',
            'city' => 'Test City',
        ]);
    }

    public function test_user_can_delete_address()
    {
        $user = User::factory()->create();
        $address = Address::create([
            'user_id' => $user->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address_line_1' => '123 Test St',
            'city' => 'Test City',
            'state' => 'Test State',
            'postal_code' => '12345',
            'country' => 'Test Country',
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->delete(route('profile.address.destroy', $address));

        $response->assertRedirect();
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    public function test_user_cannot_delete_others_address()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $address = Address::create([
            'user_id' => $otherUser->id,
            'label' => 'Home',
            'full_name' => 'John Doe',
            'phone' => '1234567890',
            'address_line_1' => '123 Test St',
            'city' => 'Test City',
            'state' => 'Test State',
            'postal_code' => '12345',
            'country' => 'Test Country',
        ]);

        $response = $this->actingAs($user)->delete(route('profile.address.destroy', $address));

        $response->assertStatus(403);
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }
}
