<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_authenticated_user_can_create_product()
    {
        // Create a user
        $user = User::factory()->create();

        // Authenticate the user
        $this->actingAs($user);

        // Make a request to create a product
        $response = $this->postJson(route('products.store'), [
            'title' => 'Test Product',
            'description' => 'Test description',
            'price' => 10.99,
        ]);

        // Assert that product was created successfully
        $response->assertStatus(201)
            ->assertJson(['message' => 'Product Created Successfully!']);

        // Assert that product exists in the database
        $this->assertDatabaseHas('products', [
            'title' => 'Test Product',
            'description' => 'Test description',
            'price' => 10.99,
            'user_id' => $user->id,
        ]);
    }
}
