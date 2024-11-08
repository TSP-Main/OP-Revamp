<?php

namespace App\Http\Requests\AdminDashboard;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProductStatusRequest extends FormRequest
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
            'order_id' => 'required|integer|exists:orders,id',
            'approvals.*.product_id' => 'required|integer',
            'approvals.*.status' => 'required|string|in:Approved,Not Approved',
        ];
    }
}
