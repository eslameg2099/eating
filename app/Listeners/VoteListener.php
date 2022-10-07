<?php

namespace App\Listeners;

use App\Events\VoteEvent;
use App\Notifications\MakeReviewNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VoteListener
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
     * @param  VoteEvent  $event
     * @return void
     */
    public function handle(VoteEvent $event)
    {
        $chef = $event->vote->kitchen->user;

        $chef->notify(new MakeReviewNotification($event->vote));
    }
}
