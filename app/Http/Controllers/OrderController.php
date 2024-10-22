<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Http\Resources\Order\OrderResource;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    // Create a new order
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());

        OrderPlaced::dispatch($order);

        return $this->successResponse(
            new OrderResource($order), 
            trans('messages.order_placed_successfully'),  
            201
        );
    }

    public function show(Request $request): JsonResponse
    {
        $order = $this->orderService->getOrderById($request->id);

        return $this->successResponse(
            new OrderResource($order), 
            trans('messages.order_details_retrieved_successfully')  
        );    
    }
}

