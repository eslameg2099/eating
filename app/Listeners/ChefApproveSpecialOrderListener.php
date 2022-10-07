<?php

namespace App\Listeners;

use App\Events\ChefApproveSpecialOrderEvent;
use App\Events\UserApproveSpecialOrderEvent;
use App\Models\SpecialOrder;
use App\Notifications\ChefApproveSpecialOrderNotification;
use App\Notifications\UserApproveSpecialOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChefApproveSpecialOrderListener
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
     * @param  ChefApproveSpecialOrderEvent  $event
     * @return void
     */
    public function handle(ChefApproveSpecialOrderEvent $event)
    {
        $event->specialOrder->customer->notify(new ChefApproveSpecialOrderNotification($event->specialOrder));
    }
}
