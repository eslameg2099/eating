<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\MakeOrderNotification;
use App\Notifications\MakeReviewNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreatedListener
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->kitchen->user->notify(new MakeOrderNotification($event->order));
    }
}
