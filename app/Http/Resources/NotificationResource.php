<?php

namespace App\Http\Resources;

use App\Models\Meal;
use App\Models\Notification;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'image' => $this->notifiable->getAvatar() ?? 'https://ui-avatars.com/api/?name='.rawurldecode(config('app.name')).'&bold=true',
            'body' => $this->message($this->data["type"]),
            'is_read' => !!$this->read_at,
            'data' => [
                'id' => $this->typeable ($this->data['type']),
                'type' => $this->data['type'],
                'readable_type' => $this->readable_type($this->data['type'])
            ],
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
    protected function message($type){
        switch ($type){
            case Notification::ORDER_TYPE:
                return ' '.trans("notifications.messages.order" , ["user" => $this->notifiable->name]) ;
                break;
            case Notification::VOTE_TYPE:
                if ($this->meal) return $this->notifiable->name .' '. trans("notifications.messages.vote") .' ' .$this->meal->name;
                if($this->specialOrder) return $this->notifiable->name .' '. trans("notifications.messages.vote") .' ' .$this->specialOrder->id;

                break;
            case Notification::FAVORITE_TYPE:
                return $this->notifiable->name .' '. trans("notifications.messages.favorite") .' ' .$this->kitchen->name;
                break;
            case Notification::SPECIALORDER_TYPE:
                return $this->notifiable->name .' '. trans("notifications.messages.specialOrder", ["user" => $this->notifiable->name]);
                break;
            //case Notification::CHAT_TYPE:
            //    return $this->notifiable->name .' '. trans("notifications.messages.favorite") .' ' .$this->kitchen->name;
            //    break;
            case Notification::ACTIVATION_TYPE:
                return ' '. trans("notifications.messages.activation" , ['kitchen' => $this->kitchen->name]) ;
                break;
            default:
                return null;
                break;
        }
    }
    protected function typeable($type){
        switch ($type){
            case Notification::ORDER_TYPE:
                return $this->order_id ;
                break;
            case Notification::VOTE_TYPE:
                return $this->meal_id;
                break;
            case Notification::FAVORITE_TYPE:
                return $this->kitchen_id;
                break;
            case Notification::SPECIALORDER_TYPE:
                return $this->kitchen_id;
                break;
            case Notification::ACTIVATION_TYPE:
                return $this->kitchen_id;
                break;
            default:
                return null;
                break;
        }
    }
    protected function readable_type($type){
        switch ($type){
            case Notification::ORDER_TYPE:
                return 'order' ;
                break;
            case Notification::VOTE_TYPE:
                return 'meal';
                break;
            case Notification::FAVORITE_TYPE:
                return 'kitchen';
                break;
            case Notification::SPECIALORDER_TYPE:
                return 'kitchen';
                break;
            case Notification::ACTIVATION_TYPE:
                return 'kitchen';
                break;
            default:
                return null;
                break;
        }
    }

}
