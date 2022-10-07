<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Rules\ImageRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\WithHashedPassword;

class RegisterRequest extends FormRequest
{
    use WithHashedPassword;

    /**
     * Determine if the chef is authorized to make this request.
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'identity_number' => ['sometimes', 'unique:users,identity_number'],
            'password' => ['required', 'min:6', 'confirmed'],
            'avatar' => ['nullable', 'image'],
            'firebase_id' => ['nullable','string'],
            'type' => [
                'nullable',
                Rule::in([
                    User::CUSTOMER_TYPE,
                    User::CHEF_TYPE,
                    User::DELEGATE_TYPE,
                ]),
            ],
            'identity_front_image' => [
                new ImageRule(),
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
            'identity_back_image' => [
                new ImageRule(),
                Rule::requiredIf(function () {
                    return $this->type == User::DELEGATE_TYPE;
                }),
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('customers.attributes');
    }
}
