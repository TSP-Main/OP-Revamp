<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Define the base rules
        $rules = [
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'category_id' => 'required|exists:categories,id', // Ensure the category exists
            'product_template' => 'required',
            'stock' => 'required|integer|min:0', // Ensure stock is a positive integer
            'stock_status' => 'required',
            'high_risk' => 'required|integer', // Assuming this is an integer
            'cut_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'desc' => 'required',
            'title' => [
                'required',
                Rule::unique('products')->ignore($this->id),
            ],
        ];

        // Add conditional rule for leaflet_link
        if ($this->high_risk == 2) {
            $rules['leaflet_link'] = 'required|string';
        } else {
            $rules['leaflet_link'] = 'nullable|string';
        }

        // Conditional rule for main_image
        if ($this->isMethod('post') || !$this->id) {
            $rules['main_image'] = [
                'required',
                'mimes:jpeg,png,jpg,gif,webm,svg,webp',
                'max:1024',
            ];
        }

        return $rules;
    }
}
