<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_submit_review()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('reviews.store'), [
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great phone!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great phone!',
        ]);
    }

    public function test_guest_cannot_submit_review()
    {
        $product = Product::factory()->create();

        $response = $this->post(route('reviews.store'), [
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Great phone!',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_user_cannot_review_same_product_twice()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 4,
            'comment' => 'First review',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($user)->post(route('reviews.store'), [
            'product_id' => $product->id,
            'rating' => 5,
            'comment' => 'Second review',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, Review::where('user_id', $user->id)->where('product_id', $product->id)->count());
    }

    public function test_rating_must_be_between_1_and_5()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('reviews.store'), [
            'product_id' => $product->id,
            'rating' => 6, // Invalid
            'comment' => 'Invalid rating',
        ]);

        $response->assertSessionHasErrors('rating');
    }
}
