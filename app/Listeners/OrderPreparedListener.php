<?php

namespace App\Listeners;

use App\Events\OrderAcceptedEvent;
use App\Events\OrderPreparedEvent;
use App\Models\User;
use App\Notifications\AcceptOrderNotification;
use App\Notifications\MakeOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderPreparedListener
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
    public function handle(OrderPreparedEvent $event)
    {
        $event->order->customer->notify(new AcceptOrderNotification($event->order));
    }
}
