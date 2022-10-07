<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($this);
        return [
            'id' => $this->id,
            'identifier' => $this->identifier,
            'address' => null, // user address obj
            'shipping_cost' => null,
            'payment_type' => null,
            'total' => null,
            'items' => [
              'id' => null,
              'quantity' => $this->quantity,
              'total' => null,
              'kitchen' => [
                  'id' => $this->kitchen->id,
                  'name' => $this->kitchen->name,
              ],
              'meal' => [
                  'id' => $this->meal->id,
                  'name' => $this->meal->name,
                  'image' => null
              ]
            ],
//            'user_id'=> $this->user_id,
//            'main_cost' => $this->main_cost,
//            'quantity'=>$this->quantity,
//            'cost' => $this->cost,
//            'purchased' => $this->purchased,
            'payment_method' => $this->payment_method,
            'changed' => $this->wasUpdated(),
//            'readable_payment_method' => trans('orders.payments.'.$this->payment_method),
//            'cost_after_discount' => $this->cost_after_discount,

        ];
    }
}
