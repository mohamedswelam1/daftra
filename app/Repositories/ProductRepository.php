<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository
{
    public function getProducts( $currentPage, $minPrice, $maxPrice, $category, $perPage )
    {
        $cacheKey = 'products_page_' . $currentPage . '_perPage_' . $perPage . '_minPrice_' . $minPrice . '_maxPrice_' . $maxPrice . '_category_' . $category;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($minPrice, $maxPrice, $category, $perPage) {
            return $this->getFilteredProducts($minPrice, $maxPrice, $category)->paginate($perPage);
        });    
    }

    public function createProduct(array $data)
    {

        return Product::create($data);
    }
    public function getFilteredProducts($minPrice, $maxPrice, $category)  
    {
        $query = Product::query();

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($category !== null) {
            $query->where('category_id', $category);
        }

        return $query;
    } 
    public function updateProduct($id, array $data)
    {
        $product = $this->getProductById($id);
        $product->update($data);
        return $product; 
    }
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }
}
