<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'chef_id' => 'required|exists:users,id',
            'kitchen_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'message' => 'required',
        ];
    }
}
