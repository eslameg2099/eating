<?php

namespace App\Events;

use App\Http\Resources\miniOrderResource;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderAcceptedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Order $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        //return "order-accepted";
        return "order-changed";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            //new PresenceChannel('order.'.$this->order->id),
                new PresenceChannel('App.User.'.$this->order->customer->id),
                new PresenceChannel('App.User.'.$this->order->chef->id),
            ];
    }

    public function broadcastWith()
    {
        return [
            'order' => new miniOrderResource($this->order),
        ];
    }
}
