<?php

namespace App\Listeners;

use App\Events\OrderAcceptedEvent;
use App\Models\User;
use App\Notifications\AcceptOrderNotification;
use App\Notifications\MakeOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderAcceptedListener
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
     * @param  OrderAcceptedEvent  $event
     * @return void
     */
    public function handle(OrderAcceptedEvent $event)
    {
        if($event->order->active == User::CHEF_TYPE) $user = $event->order->customer;
        if($event->order->active == User::CUSTOMER_TYPE) $user = $event->order->kitchen->user ;
        $user->notify(new AcceptOrderNotification($event->order));
    }
}
