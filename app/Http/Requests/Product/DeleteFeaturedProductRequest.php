<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFeaturedProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id', // Ensure the product ID is provided and exists
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product ID is required',
            'product_id.exists'   => 'Product not found',
        ];
    }
}
