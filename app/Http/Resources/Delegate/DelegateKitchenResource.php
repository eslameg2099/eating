<?php

namespace App\Http\Resources\Delegate;

use App\Http\Resources\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateKitchenResource extends JsonResource
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
            'address' => $this->address,
            'long' => $this->long,
            'lat' => $this->lat,
            'avatar' => $this->getFirstMediaUrl(),
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'reviews' => $this->review,
            'city' => new CityResource($this->city),

        ];
    }
}
