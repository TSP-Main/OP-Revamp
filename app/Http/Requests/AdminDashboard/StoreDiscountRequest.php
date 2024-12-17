<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // For now, we allow everyone to make this request (you can add authorization logic as needed)
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
            'code'                   => 'required|string|unique:discounts,code|max:255',
            'discount_type'          => 'required|in:percentage,fixed_amount,free_shipping',
            'value'                  => 'numeric|min:0',
            'selection_type'         => 'string',
            'min_purchase_amount'    => 'nullable|numeric|min:0',
            'product_id'             => 'nullable|integer',
            'variant_id'             => 'nullable|integer',
            'category_id'            => 'nullable|integer',
            'subcategory_id'         => 'nullable|integer',
            'childcategory_id'       => 'nullable|integer',
            'start_date'             => 'required|date',
            'end_date'               => 'nullable|date',
            'start_time'             => 'required|date_format:H:i',
            'end_time'               => 'nullable|date_format:H:i',
            'max_usage'              => 'nullable|integer|min:1',
            'max_usage_per_user'     => 'nullable|integer|min:1',
            'is_active'              => 'nullable|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required'                => 'The discount code is required.',
            'code.unique'                  => 'The discount code must be unique.',
            'discount_type.required'       => 'The discount type is required.',
            'min_purchase_amount.numeric'  => 'The minimum purchase amount must be a number.',
            'start_date.required'          => 'The start date is required.',
            'end_date.required'            => 'The end date is required.',
            'start_time.required'          => 'The start time is required.',
            'end_time.required'            => 'The end time is required.',
            'max_usage.integer'            => 'The maximum usage must be an integer.',
            'max_usage_per_user.integer'   => 'The maximum usage per user must be an integer.',
            'is_active.boolean'            => 'The active status must be a boolean value.',
        ];
    }
}
