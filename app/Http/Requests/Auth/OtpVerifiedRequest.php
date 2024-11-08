<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class OtpVerifiedRequest extends FormRequest
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
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'otp.required' => 'The OTP field is required.',
            'otp.digits' => 'The OTP must be exactly 6 digits.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'user' => User::where('email', $this->email)->first(),
    //     ]);
    // }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $user = $this->user;

    //         if ($user && $user->otp !== trim($this->otp)) {
    //             $validator->errors()->add('otp', 'The provided OTP is incorrect for this email.');
    //         }

    //         if (!$user) {
    //             $validator->errors()->add('email', 'The provided email is incorrect.');
    //         }
    //     });
    // }
}
