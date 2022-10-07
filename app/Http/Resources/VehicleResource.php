<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'type' => $this->type,
            'model' => $this->model,
            'number' => $this->number,
            'active' => $this->active,
            'verified' => true,
            'verified_at' => $this->verified_at,
            'created_at' => $this->created_at,
        ];
    }
}
