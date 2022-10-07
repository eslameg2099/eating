<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends FormRequest
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
            'kitchen_id' => 'required|exists:kitchens,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:160',
            'description'=>'required',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_after_discount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|less_than_field:cost|digits_between:1,5',
            'avatar' => 'sometimes|array',
            'avatar.*' => 'sometimes|image',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('meal.attributes');
    }
}
