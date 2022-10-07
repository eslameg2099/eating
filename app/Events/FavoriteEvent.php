<?php

namespace App\Events;

use App\Http\Resources\KitchenResource;
use App\Models\Notification;
use ChristianKuri\LaravelFavorite\Models\Favorite;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FavoriteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Favorite $favorite;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('App.User.'.$this->favorite->kitchen->user->id);
    }

    public function broadcastAs()
    {
        return 'favorited';
    }

    public function broadcastWith()
    {
        return [
            'favorited' => [
                'user_id' => $this->favorite->user_id,
                'type' => Notification::FAVORITE_TYPE,
                'kitchen' => $this->favorite,
            ],
        ];
    }
}
