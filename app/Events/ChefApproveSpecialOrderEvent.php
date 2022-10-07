<?php

namespace App\Events;

use App\Http\Resources\SpecialOrderResource;
use App\Models\SpecialOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChefApproveSpecialOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SpecialOrder $specialOrder;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SpecialOrder $specialOrder)
    {
        $this->specialOrder = $specialOrder;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PresenceChannel('SpecialOrder.'.$this->specialOrder->id) ,
            new PresenceChannel('App.User.'.$this->specialOrder->kitchen->user->id),
            new PresenceChannel('App.User.'.$this->specialOrder->customer->id)
            ];
    }

    public function broadcastAs()
    {
        //return 'chefApprove-special-order';
        return 'special-order-changed';
    }

    public function broadcastWith()
    {
        return [
            'specialOrder' => new SpecialOrderResource($this->specialOrder),
        ];
    }
}
