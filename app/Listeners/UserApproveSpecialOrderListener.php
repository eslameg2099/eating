<?php

namespace App\Listeners;

use App\Events\UserApproveSpecialOrderEvent;
use App\Models\SpecialOrder;
use App\Notifications\UserApproveSpecialOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserApproveSpecialOrderListener
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
     * @param  UserApproveSpecialOrderEvent  $event
     * @return void
     */
    public function handle(UserApproveSpecialOrderEvent $event)
    {
        $event->specialOrder->kitchen->user->notify(new UserApproveSpecialOrderNotification($event->specialOrder));
    }
}
