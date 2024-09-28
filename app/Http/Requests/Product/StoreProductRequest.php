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
        $rules = [
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'category_id' => 'required',
            'product_template' => 'required',
            'stock' => 'required',
            'stock_status' => 'required',
            'cut_price' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'desc' => 'required',
            'title' => [
                'required',
                Rule::unique('products')->ignore($this->id),
            ],
        ];

        if ($this->isMethod('post') || !$this->id) {
            $rules['main_image'] = [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webm,svg,webp',
                'max:1024',
            ];
        }

        return $rules;
    }
}
