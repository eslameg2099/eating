<?php

namespace App\Listeners;

use App\Events\FavoriteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FavoriteListener
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
     * @param  FavoriteEvent  $event
     * @return void
     */
    public function handle(FavoriteEvent $event)
    {
        //
    }
}
