<?php

namespace App\Http\Resources;

use App\Models\Meal;
use App\Support\Price;
use Illuminate\Http\Resources\Json\JsonResource;
use AhmedAliraqi\LaravelMediaUploader\Transformers\MediaResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    /*
     *
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'kitchen_id'            => $this->kitchen_id,
            'kitchen_name'            => $this->kitchen->name,
            'category'              => new CategoryResource($this->category),
            'name'                  => $this->name,
            'description'           => $this->description,
            'cost'                  => new Price($this->cost),
            'cost_after_discount'   => ! is_null($this->cost_after_discount) ? new Price($this->cost_after_discount) : null,
            'has_discount'          => $this->cost_after_discount ? true : false,
            'is_favorite' => $this->isFavorited(),
            'is_voted' => auth()->user() ?  auth()->user()->is_voted($this) : false,
            'user_vote' => auth()->user() ? auth()->user()->vote_rate($this) : null,
            'images'                => MediaResource::collection($this->getMedia('Meal')),
            'votes' => ['avg' => round($this->votes->avg('rate'),1)??0.0,'count'=> (int) $this->votes->count()],
            'deleted' => ! ! $this->deleted_at,
            'deleted_at' => $this->deleted_at,

        ];
    }
}
