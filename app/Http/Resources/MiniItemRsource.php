<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AhmedAliraqi\LaravelMediaUploader\Transformers\MediaResource;

class MiniItemRsource extends JsonResource
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
             'meal' => $this->meal->name ?? null ,
             
            // 'image'=> if($this->meal->name != null) { MediaResource::collection($this->meal->getMedia('Meal'))},

        ];
    }
}
