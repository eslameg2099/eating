<?php

namespace App\Listeners;

use App\Models\Kitchen;
use App\Notifications\KitchenActivated;
use App\Support\Chat\Events\KitchenActivationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class KitchenActivationListener
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
     * @param  KitchenActivationEvent  $event
     * @return void
     */
    public function handle(KitchenActivationEvent $event)
    {
        $event->kitchen->user->notify(new KitchenActivated($event->kitchen));
    }
}
