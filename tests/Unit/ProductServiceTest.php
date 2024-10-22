<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Tests\TestCase;
use Mockery;

class ProductServiceTest extends TestCase
{
    protected $productService;
    protected $productRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the repository
        $this->productRepository = Mockery::mock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepository);
    }

    public function test_create_product()
    {
        $productData = Product::factory()->make()->toArray();

        $product = new Product($productData);

        $this->productRepository->shouldReceive('createProduct')
            ->once()
            ->with($productData)
            ->andReturn($product);

        $createdProduct = $this->productService->createProduct($productData);

        $this->assertInstanceOf(Product::class, $createdProduct);
        $this->assertEquals($productData['name'], $createdProduct->name);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
