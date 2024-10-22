<?php

namespace App\Http\Requests\Order;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'total_amount'=>'required|numeric|min:1', 
            'products' => 'required|array|min:1', 
            'products.*.id' => 'required|exists:products,id', 
            'products.*.quantity' => 'required|integer|min:1', 
        ];
    }
    public function messages()
    {
        return [
            'products.*.id.required' => 'The product ID is required.',
            'products.*.id.exists' => 'The selected product ID is invalid.',
            'products.*.quantity.required' => 'The product quantity is required.',
            'products.*.quantity.integer' => 'The product quantity must be an integer.',
            'products.*.quantity.min' => 'The product quantity must be at least 1.',
        ];
    }
    public function withValidator(ValidationValidator $validator)
    {
        $validator->after(function ($validator) {
            $products = $this->input('products');

            foreach ($products as  $index => $product) {
                $productModel = Product::find($product['id']);

                // Check if the product exists and if the requested quantity is in stock
                if (!$productModel || $productModel->quantity < $product['quantity']) {
                    $validator->errors()->add("products.$index.quantity", "Insufficient stock for product ID: " . $product['id']);
                }
            }
        });
    }   
}
