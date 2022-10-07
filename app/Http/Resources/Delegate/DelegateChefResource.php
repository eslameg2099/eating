<?php

namespace App\Http\Resources\Delegate;

use App\Http\Resources\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateChefResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'avatar' => $this->getAvatar(),
            'kitchen' => new DelegateKitchenResource($this->kitchen),
        ];
    }
}
