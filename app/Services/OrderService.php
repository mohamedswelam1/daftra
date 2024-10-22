<?php
namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    // Create an order through the repository
    public function createOrder(array $data)
    {
        return $this->orderRepository->createOrder($data);
    }

    // Retrieve an order by ID through the repository
    public function getOrderById($id)
    {
        return $this->orderRepository->getOrderById($id);
    }
}


