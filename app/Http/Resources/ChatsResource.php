<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatsResource extends JsonResource
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

            'messages' => MessagesResource::collection($this->whenLoaded('messages')) ,
//            'messages' => MessagesResource::collection($this->messages) ,
            'sender' => $this->whenLoaded('sender') ,
            'receiver' => $this->whenLoaded('receiver') ,

        ];
    }
}
