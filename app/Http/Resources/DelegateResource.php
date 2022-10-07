<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AhmedAliraqi\LaravelMediaUploader\Transformers\MediaResource;

class DelegateResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_verified_at' => ! ! $this->phone_verified_at,
            'type' => $this->type,
            'avatar' => $this->getAvatar(),
            'identity_front_image' => $this->getFirstMedia('identity_front_image'),
            'identity_back_image' => new MediaResource($this->getFirstMedia('identity_back_image')),
            'localed_type' => $this->present()->type,
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_formatted' => $this->created_at->diffForHumans(),
//            'wallet' => $this->wallet,
//            'wallet_ballance' => $this->wallet->sum('transaction'),
            'city' => new CityResource($this->city) ,
            'vehicle' => new VehicleResource($this->vehicle)
        ];
    }
}
