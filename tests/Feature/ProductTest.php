<?php
namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_a_product()
    {
        $user = User::factory()->create(); 
        $this->actingAs($user); 

        $productData = Product::factory()->make()->toArray();

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Product created successfully']);

        $this->assertDatabaseHas('products', $productData);
    }

    /** @test */
    public function it_validates_store_product_request()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/products', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'description', 'price', 'quantity']);
    }

}
