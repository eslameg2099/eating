<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\Price;

class OrderItemResource extends JsonResource
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
            'quantity' => $this->quantity,
            'cost' => $this->cost,
            'cost_after_discount' => $this->cost_after_discount,
            'total'=> new Price($this->meal->getPrice() * $this->quantity ),
            'purchased' => $this->purchased,
            'meal' => new MealResource($this->meal),
        ];
    }
}
