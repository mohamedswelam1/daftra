<?php

namespace Tests\Feature;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_place_order()
    {
        Event::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $product1 = Product::factory()->create(['quantity' => 10]);
        $product2 = Product::factory()->create(['quantity' => 15]);

        $orderData = [
            'user_id'=>$user->id ,
            'total_amount'=>100,
            'products' => [
                ['id' => $product1->id, 'quantity' => 2],
                ['id' => $product2->id, 'quantity' => 3],
            ],
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Order placed successfully!']);

        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
        $this->assertDatabaseHas('order_product', ['product_id' => $product1->id, 'quantity' => 2]);
        
        Event::assertDispatched(OrderPlaced::class, function ($event) use ($user) {
            return $event->order->user_id === $user->id;
        });
    }
}
