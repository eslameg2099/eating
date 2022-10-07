<?php

namespace App\Events;

use App\Http\Resources\VoteResource;
use App\Models\Vote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Queue\SerializesModels;

class VoteEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Vote $vote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Vote $vote)
    {
        //
        $this->vote = $vote;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('App.User.'.$this->vote->kitchen->user->id);
    }

    public function broadcastAs()
    {
        return 'voted';
    }

    public function broadcastWith()
    {
        return [
            'vote' => new VoteResource($this->vote),
        ];
    }
}
