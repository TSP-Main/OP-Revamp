<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreSopRequest extends FormRequest
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
            'file_for' => 'required',
        ];

        if ($this->hasFile('file') || !$this->id) {
            $rules['file'] = ['required', 'file']; // Add 'file' rule to ensure it's a valid file type
        }

        return $rules;
    }
}
