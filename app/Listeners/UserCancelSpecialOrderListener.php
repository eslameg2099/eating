<?php

namespace App\Listeners;

use App\Events\UserCancelSpecialOrderEvent;
use App\Models\SpecialOrder;
use App\Notifications\UserCancelSpecialOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCancelSpecialOrderListener
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
     * @param  UserCancelSpecialOrderEvent  $event
     * @return void
     */
    public function handle(UserCancelSpecialOrderEvent $event)
    {
        if($event->specialOrder->type == 'chef') $event->specialOrder->customer->notify(new UserCancelSpecialOrderNotification($event->specialOrder));
        if($event->specialOrder->type == 'customer') $event->specialOrder->kitchen->user->notify(new UserCancelSpecialOrderNotification($event->specialOrder));
    }
}
