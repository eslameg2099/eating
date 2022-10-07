<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AhmedAliraqi\LaravelMediaUploader\Transformers\MediaResource;

class MessagesResource extends JsonResource
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
            'room_id' => $this->room_id,
            'message' => $this->message,
            'receiver' => $this->receiver_id,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
