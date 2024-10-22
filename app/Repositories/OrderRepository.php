<?php
namespace App\Repositories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderRepository
{
    public function createOrder(array $data): Order
    {
        DB::beginTransaction();

        try {
        
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $data['total_amount'],
                'status'=>OrderStatus::PENDING
            ]);
        
            $productsWithQuantities = [];
            foreach ($data['products'] as $product) {
                $productsWithQuantities[$product['id']] = ['quantity' => $product['quantity']];
            }
        
            $order->products()->attach($productsWithQuantities);
        
            DB::commit();
            return $order;
        
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
    }
    public function getOrderById($id): Order
    {
        return Order::with('products')->findOrFail($id);
    }
}

