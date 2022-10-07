<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateSponsorDuration extends FormRequest
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
            'info' => 'required|array',
            'info.title' => 'required|max:255',
            'info.locale' => 'in:ar,en',
            'info.duration' => 'required|numeric|between:0,12',
            'info.cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'info.currency' => '',
        ];
    }
}
