<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;

class DeleteCategoryRequest extends FormRequest
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
            'id' => 'required|exists:categories,id', // Ensure that the ID exists in the categories table
            'cat_type' => 'required|in:category_id,sub_category,child_category', // Validating allowed category types
            'status' => 'required', // Adjust based on your status values
        ];
    }
}
