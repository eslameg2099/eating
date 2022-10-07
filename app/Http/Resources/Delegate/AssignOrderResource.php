<?php

namespace App\Http\Resources\Delegate;

use App\Http\Resources\MiniUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignOrderResource extends JsonResource
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
            'delegate' => new MiniUserResource($this->delegate),
            'order' => new DelegateOrderResource($this->order),
        ];
    }
}
