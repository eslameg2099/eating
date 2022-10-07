<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use App\Http\Resources\OrderResource;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AssignOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var \App\Models\Feedback
     */
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        foreach ($this->order->assign_orders as $assigned) {
            $channels[] = new PresenceChannel('delegate-'.$assigned->delegate_id);
        }

        return $channels;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return "assign-order";
    }

    /**
     * Get the data to broadcast.
     *
     * @return OrderResource
     */
    public function broadcastWith()
    {
        return new OrderResource($this->order);
    }
}
