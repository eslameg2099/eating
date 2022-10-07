<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
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
            'kitchen_id' => 'exists:kitchens,id',
            'category_id' => 'exists:categories,id',
            'name' => 'max:160',
            'description'=>'',
            'cost' => 'regex:/^\d+(\.\d{1,2})?$/',
            'cost_after_discount' => 'less_than_field:cost',
            'avatar' => 'array',
            'avatar.*' => 'image',
        ];
    }
}
