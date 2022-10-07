<?php

namespace App\Listeners;

use App\Models\ChatRoomMembers;
use App\Models\User;
use App\Notifications\SendMessageNotification;
use App\Support\Chat\Contracts\ChatMember;
use App\Support\Chat\Events\MessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageSendListeners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $event->message->receiver()->notify(new SendMessageNotification($event->message));

        //$event->message->room->roomMembers->each(function (ChatRoomMembers $member) use ($event) {
        //    if ($member != auth()->user()) dd($member == $event->message->receiver());
        //
        //    if($member == $event->message->receiver())
        //    {
        //        $member->member->notify(new SendMessageNotification($event->message));
        //    }
        //    //if (! $member->member->subscribedTo('room.'. $event->message->room->id)) {
        //    //    $member->member->notify(new SendMessageNotification($event->message));
        //    //    //$event->message->receiver->notify(new SendMessageNotification($event->message));
        //    //}
        //});

    }
}
