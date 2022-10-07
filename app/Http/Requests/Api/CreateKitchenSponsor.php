<?php

namespace App\Http\Requests\Api;

use App\Models\KitchenSponsor;
use App\Models\SponsorDurations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateKitchenSponsor extends FormRequest
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
            //'kitchen_id' => 'required|exists:kitchens,id',
            'sponsor_duration_id' => 'required|exists:sponsor_durations,id',
            'payment_method' =>['required',Rule::in(KitchenSponsor::ONLINE_PAYMENT,KitchenSponsor::WALLET_PAYMENT)],
            'payment_type' =>'nullable',
            'avatar' => 'image',
            'checkout_id' => 'nullable'
        ];
    }
}
