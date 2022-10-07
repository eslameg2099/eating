<?php

namespace App\Listeners;

use App\Events\SpecialOrderCreatedEvent;
use App\Notifications\MakeSpecialOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SpecialOrderCreatedListener
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
     * @param  SpecialOrderCreatedEvent  $event
     * @return void
     */
    public function handle(SpecialOrderCreatedEvent $event)
    {
        $event->specialOrder->kitchen->user->notify(new MakeSpecialOrderNotification($event->specialOrder));
    }
}
