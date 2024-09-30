<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only allow if the user has the necessary permission
        return auth()->user()->can('add_dispensary');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|digits_between:10,15',
            'address' => 'required',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|exists:roles,name', // Validate if the role exists in the roles table
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
        ];

        // Require password only if creating a new admin
        if (!$this->id) {
            $rules['password'] = 'required';
        }

        return $rules;
    }
}
