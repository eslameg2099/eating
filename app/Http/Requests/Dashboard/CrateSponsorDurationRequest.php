<?php

namespace App\Http\Requests\Dashboard;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class CrateSponsorDurationRequest extends FormRequest
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
    public function rules()
    {
        if ($this->isMethod('POST')) {
            return $this->createRules();
        } else {
            return $this->updateRules();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function updateRules()
    {
        return RuleFactory::make([
            '%title%' => '',
            //'%currency%' => 'string',
            //'cost' => 'numeric',
            'duration' => 'numeric',
            'duration_type' => '']);
    }
    public function createRules()
    {
        return RuleFactory::make([
            '%title%' => 'required|unique:sponsor_duration_translations,title',
            '%currency%' => 'required|string',
            'cost' => 'required|numeric',
            'duration' => 'required|numeric',
            'duration_type' => 'required']);
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('sponsorship.attributes');
    }
}
