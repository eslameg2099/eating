<?php

namespace App\Http\Requests\Api;

use Composer\DependencyResolver\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'user_id' => 'exists:users,id,type,'.'customer',
            'identifier' => 'exists:carts,identifier',
            'kitchen_id' => ['required','exists:kitchens,id'
//                , Rule::exists('carts')->where(function($query){
//                    $query->where("identifier")
//                })
            ],
            'meal_id' => 'required|exists:meals,id',
            'quantity' => 'required|numeric',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('carts.attributes');
    }

    public function messages()
    {
        return trans('carts.attributes');
    }
}
