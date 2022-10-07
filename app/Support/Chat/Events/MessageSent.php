<?php

namespace App\Support\Chat\Events;

use App\Http\Resources\Chat\MessageResource;
use App\Http\Resources\Chat\RoomResource;
use App\Models\ChatRoomMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\ChatRoomMessage
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\ChatRoomMessage $message
     */
    public function __construct(ChatRoomMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [
            new PresenceChannel('room.'.$this->message->room_id),
        ];

        foreach ($this->message->room->roomMembers as $roomMember) {
            $channels[] = new PresenceChannel('App.User.'.$roomMember->member_id);
        }

        return $channels;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        //return (new MessageResource($this->message))
        //    ->jsonSerialize();
        return (new MessageResource($this->message))->additional([
            'room' => new RoomResource($this->message->room),
        ])
            ->jsonSerialize();
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'new.message';
    }
}
