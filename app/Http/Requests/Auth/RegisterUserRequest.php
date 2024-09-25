<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->id],
            'password' => [
                $this->id ? 'nullable' : 'required', // Password is required only if creating a new user
                'string',
                'min:8',
               'confirmed'  // Ensures that a password confirmation field exists and matches
            ],

            // Role (optional)
            'role' => ['sometimes', 'string', 'exists:roles,name'], // Check if the role exists in Spatie's roles table

            // Date of birth fields
            'year' => ['required', 'integer', 'digits:4'], // Year must be 4 digits (e.g., 1990)
            'month' => ['required', 'integer', 'between:1,12'], // Month must be between 1-12
            'day' => ['required', 'integer', 'between:1,31'], // Day must be between 1-31

            // UserProfile fields
            'speciality' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15', 'regex:/^\+?[0-9]*$/'], // Phone number with optional international code
            'gender' => ['required', 'in:male,female,other'], // Ensure gender is one of the accepted values
            'image' => ['nullable', 'image', 'max:2048'], // User's image should be a valid image and less than 2MB
            'short_bio' => ['nullable', 'string', 'max:1000'],

            // UserAddress fields
            'address' => ['required', 'string', 'max:255'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],

            // Zip code (optional based on needs)
            'zip_code' => ['nullable', 'string', 'max:20'],

            // ID Document (if uploaded)
            'id_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Max 5MB and should be a valid file type
        ];
    }

}
