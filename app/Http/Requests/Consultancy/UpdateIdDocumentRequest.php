<?php

namespace App\Http\Requests\Consultancy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIdDocumentRequest extends FormRequest
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
            'id_document' => 'required|file', // Validate that id_document is a file
        ];
    }
}
