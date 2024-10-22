<?php

namespace App\Http\Controllers;

use App\Http\Requests\product\CreateProductRequest;
use App\Http\Requests\product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {    
        $products = $this->productService->getAllProducts($request) ; 
        
        return $this->successResponse(
            ProductResource::collection($products)->response()->getData(true), 
            trans('messages.products_retrieved_successfully')
        );
        
    }
    public function store(CreateProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());

        return $this->successResponse(new ProductResource($product), 'Product created successfully', 201);
    }
    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());

        return $this->successResponse(new ProductResource($product), 'Product updated successfully');
    }

}

