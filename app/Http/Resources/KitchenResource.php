<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\MealResource;
use App\Http\Requests\Api\VoteRequest;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Kitchen */
class KitchenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'address_on_map' => $this->map_addres,
            'description' => $this->description,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'active' => $this->active,
            'active_special' => $this->active_special,
            "verified" => true,
            "verified_at" => $this->verified_at,
            'cookable_type' => $this->cookable_type,
            'avatar' => $this->getFirstMediaUrl(),
            'attach' => $this->getMedia('attach')->map->getUrl(),
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'is_favorite' => $this->isFavorited(),
            'sponsor' => new KitchenDurationResource($this->kitchenSponsorDurations->last()),
            'is_sponsored' => !!$this->kitchenSponsorDurations->last(),
            'reviews' => (is_null($this->review)) ? $this->reviews() : $this->review,
            'city' => new CityResource($this->city),
            
//            'meals' => MealResource::collection($this->meals()->inRandomOrder()->limit(5)->get()),
//            'meals_offers' => MealResource::collection($this->meals()->whereNotNull('cost_after_discount')->inRandomOrder()->limit(5)->get()),
//            'votes' => VoteResource::collection($this->votes),

        ];
    }
    protected function reviews(){
        return [
            'rate' => (double) 0.0,
            'reviewers' => 0
        ];
    }

}
