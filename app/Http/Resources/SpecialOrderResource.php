<?php

namespace App\Http\Resources;

use App\Models\Helpers\priceHelper;
use App\Models\SpecialOrder;
use App\Support\Price;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;

class SpecialOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'kitchen_id' => $this->kitchen_id,
            'information' => $this->information,
            'payment_method' => $this->payment_method,
            'cost' =>  new Price($this->cost + priceHelper::adminCommission()),
            'order_cost' => new Price($this->cost),
            'taxesAndService' => new Price(priceHelper::adminCommission() + priceHelper::taxesAndServiceOnSpecialOrders()),
            'admin_commission' => priceHelper::adminCommission(),
            'tax' => Settings::get('tax_ratio'),
            'added_tax' => Settings::get('additional_added_tax'),
            'time' => $this->time,
            'status' => $this->status,
            'checkout_id' => $this->checkout_id,
            'can_cancel' => $this->status >= SpecialOrder::APPROVED_STATUS ? false : true,
            'readable_status' => $this->ReadableStatusApp(),
            'readable_payment_method' => $this->ReadablePaymentMethods(),
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'kitchen' => [
                'id' => $this->kitchen->id,
                'name' => $this->kitchen->name,
                'address' => $this->kitchen->address,
                'active' => $this->kitchen->active,
                'active_special' => $this->kitchen->active_special,
                'city_id' => $this->kitchen->city_id,
                'chef' => [
                    'name' => $this->kitchen->user->name,
                    'phone' => $this->kitchen->user->phone,
                ]
            ],
            'customer' => new MiniUserResource($this->customer),
            'address' => new AddressResource($this->address) ,
        ];
    }
}
