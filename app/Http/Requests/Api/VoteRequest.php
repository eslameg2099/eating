<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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

//            'user_id' => ['required','exists:users,id','unique:votes'],
            'kitchen_id' => 'required|exists:kitchens,id',
            'meal_id' => 'sometimes|exists:meals,id',
            'special_order_id' => 'sometimes|exists:special_orders,id',
            'rate' => ['required', Rule::in(['0', '1', '2', '3', '4', '5'])],
            'comment' => 'nullable',
        ];
    }

    public function attributes()
    {
        return trans('vote.attributes');
    }
}
