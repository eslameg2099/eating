<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKitchenRequest extends FormRequest
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
            'name' => 'max:125',
            'address' => ['sometimes'],
            'description' => ['sometimes'],
            'city_id' => 'exists:cities,id',
            'longitude' => 'sometimes',
            'latitude'   => 'sometimes',
            'cookable_id' => '',
            'avatar' => 'sometimes',
            'attach' => 'sometimes',
        ];
    }

    public function attributes()
    {
        return trans('kitchen.attributes');
    }
}
