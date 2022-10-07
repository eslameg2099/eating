<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeScreenOffersResource extends JsonResource
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
            'kitchen_id' => $this->kitchen_id,
            'title' => $this->KitchenSponsor->last()->sponsor_duration->title ?? null,
            'avatar' => $this->KitchenSponsor->first()->getFirstMediaUrl() ?? null,
        ];
    }
}
