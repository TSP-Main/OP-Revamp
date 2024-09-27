<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
        $userId = auth()->user()->id;

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15',
            'address' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional, max size 2MB
            'short_bio' => 'nullable|string|max:500',
            'status' => 'Active',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'phone.required' => 'Phone number is required',
            'email.required' => 'Email is required',
            'email.unique' => 'This email is already exist',
        ];
    }
}
