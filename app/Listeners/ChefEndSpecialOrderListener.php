<?php

namespace App\Listeners;

use App\Events\ChefEndSpecialOrder;
use App\Events\UserCancelSpecialOrderEvent;
use App\Models\SpecialOrder;
use App\Notifications\ChefEndSpecialOrderNotification;
use App\Notifications\UserCancelSpecialOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChefEndSpecialOrderListener
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
    public function handle(ChefEndSpecialOrder $event)
    {
        $event->specialOrder->customer->notify(new ChefEndSpecialOrderNotification($event->specialOrder));
    }
}
