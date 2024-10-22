<?php
namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request as FacadesRequest;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(Request $request)
    {
        $currentPage = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $category = $request->get('category');

        $paginatedProducts = $this->productRepository->getProducts(  $currentPage,$minPrice, $maxPrice, $category, $perPage);
       
        return  $paginatedProducts ; 
    }

    public function createProduct(array $data)
    {
        return $this->productRepository->createProduct($data);
    }
    public function updateProduct($id, array $data)
    {
        return $this->productRepository->updateProduct($id , $data);

    }

 
}
