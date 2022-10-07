<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Concerns\WithHashedPassword;

class ProfileRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'city_id' => ['sometimes', 'required', 'exists:cities,id'],
            'email' => ['sometimes', 'required', 'email', 'unique:users,email,'.auth()->id()],
            'avatar' => ['nullable', 'image'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        switch (auth()->user()->type) {
            case User::ADMIN_TYPE:
                return trans('admins.attributes');
                break;
            case User::CUSTOMER_TYPE:
                return trans('customers.attributes');
            case User::CHEF_TYPE:
                return trans('chefs.attributes');
            default:
                return trans('customers.attributes');
                break;
        }
    }
}
