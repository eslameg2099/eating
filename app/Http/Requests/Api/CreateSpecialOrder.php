<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSpecialOrder extends FormRequest
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
            'user_id'  => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'kitchen_id' => 'required|exists:kitchens,id',
            'information' => 'required|max:255',
            'payment_method' => ['required', Rule::in(['0', '1', '2'])],
        ];
    }
}
