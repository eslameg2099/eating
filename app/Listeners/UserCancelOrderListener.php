<?php

namespace App\Listeners;

use App\Events\UserCancelOrderEvent;
use App\Models\Order;
use App\Models\User;
use App\Notifications\UserCancelOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCancelOrderListener
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
     * @param  UserCancelOrderEvent  $event
     * @return void
     */
    public function handle(UserCancelOrderEvent $event)
    {
        if($event->order->type == User::CHEF_TYPE) $event->order->customer->notify(new UserCancelOrderNotification($event->order));
        if($event->order->type == User::CUSTOMER_TYPE) $event->order->kitchen->user->notify(new UserCancelOrderNotification($event->order));
    }
}
