<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\miniOrderResource;
use App\Http\Resources\MiniUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ChatRoom */
class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
//            'order' => new miniOrderResource($this->order),

            'special_order' => is_null($this->specialOrder) ? null : ['id' => $this->specialOrder->id, 'created_at' => $this->specialOrder->created_at->toDateTimeString() , 'phone' => $this->specialOrder->kitchen->user->phone , 'chef' => $this->specialOrder->kitchen->user->name],
            'type' => (int) $this->type,
            'last_message' => new MessageResource($this->whenLoaded('lastMessage')),
            'member' => new MiniUserResource($this->getOtherMember()),
        ];
    }

    protected function getName()
    {
        return $this->getOtherMembers()->implode('member.full_name', ',');
    }

    protected function getImage()
    {
        if ($this->getOtherMembers()->count() > 1) {
            return 'group image';
        }

        if ($member = $this->getOtherMembers()->first()) {
            return optional($member)->member->user_image;
        }
        //return ;
    }

    public function canSendMessage()
    {

        return true;
    }
}
