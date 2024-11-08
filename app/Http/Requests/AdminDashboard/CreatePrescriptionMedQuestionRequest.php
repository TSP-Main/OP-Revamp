<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrescriptionMedQuestionRequest extends FormRequest
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
            'is_assigned' => 'required',
            'anwser_set' => 'required',
            'title' => 'required|string|max:255', // Add additional validation rules as needed
            'desc' => 'nullable|string',
            'type' => 'required|string',
            'yes_lable' => 'nullable|string|max:255',
            'no_lable' => 'nullable|string|max:255',
            'optA' => 'nullable|string|max:255',
            'optB' => 'nullable|string|max:255',
            'optC' => 'nullable|string|max:255',
            'optD' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'next_quest' => 'required|array', // Assuming next_quest is an array
        ];
    }
}
