<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class CreateKitchenRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id,type,chef',
            'name' => ['required', 'max:125'],
            'address' => ['required','max:255'],
            'description' => ['required'],
            'city_id' => 'required|exists:cities,id',
            //'longitude' => 'required',
            //'latitude'   => 'required',
            'lng' => 'required',
            'lat'   => 'required',
            'cookable_id' => 'sometimes',
            'avatar' => 'nullable',
            'attach' => 'sometimes|max:10000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('kitchen.attributes');
    }
}
