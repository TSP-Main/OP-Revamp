<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'phone' => 'required|digits_between:10,15',
            'address' => 'required',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|exists:roles,name',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
        ];

        if (!$this->id) {
            $rules['password'] = 'required';
        }

        return $rules;
    }
}
