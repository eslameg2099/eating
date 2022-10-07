<?php

namespace App\Events;

use App\Http\Resources\KitchenResource;
use App\Http\Resources\miniOrderResource;
use App\Models\Kitchen;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KitchenActivationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Kitchen $kitchen;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Kitchen $kitchen)
    {
        $this->kitchen = $kitchen;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return "kitchen-activation";
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('App.User.'.$this->kitchen->user_id);
    }
    public function broadcastWith()
    {
        return [
            'order' => new KitchenResource($this->kitchen),
        ];
    }
}
