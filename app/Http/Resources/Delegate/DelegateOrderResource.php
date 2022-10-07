<?php

namespace App\Http\Resources\Delegate;

use Carbon\Carbon;
use App\Http\Resources\MiniUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateOrderResource extends JsonResource
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
            'order_code'=> strtotime($this->created_at).$this->id,
            'address' => $this->address,
            'total_cost' => $this->total_cost,
            'total_discount' => $this->total_discount,
            'purchased' => $this->purchased,
            'payment_method' => $this->payment_method,
            'shipping_cost'=> $this->shipping_cost,
            'status'=> $this->status,
            'notes'=> $this->notes,
            'cooked_at'=> $this->cooked_at->toDateTimeString(),
            'cooked_at_formatted'=> $this->cooked_at->diffForHumans(Carbon::now()),
            'received_at'=> ! ! $this->received_at,
            'delivered_at'=> ! ! $this->delivered_at,
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'items' => $this->items,
            'chef' => new DelegateChefResource($this->chef),
            'user' => new MiniUserResource($this->customer),
        ];
    }
}
