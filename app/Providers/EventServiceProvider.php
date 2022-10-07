<?php

namespace App\Providers;

use App\Events\OrderPreparedEvent;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use App\Observers\PhoneVerificationObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\FeedbackSent::class => [
            \App\Listeners\SendFeedbackMessage::class,
        ],
        \App\Events\VerificationCreated::class => [
            \App\Listeners\SendVerificationCode::class,
        ],
        \App\Events\OrderCreated::class => [
            \App\Listeners\OrderCreatedListener::class,
        ],
        \App\Events\OrderAcceptedEvent::class => [
            \App\Listeners\OrderAcceptedListener::class,
        ],
//        \App\Events\SendMessageEvent::class => [
//            \App\Listeners\SendMessageListener::class,
//        ],
          \App\Events\VoteEvent::class => [
          \App\Listeners\VoteListener::class,
        ],
        \App\Events\FavoriteEvent::class => [
            \App\Listeners\FavoriteListener::class,
        ],
        \App\Events\SpecialOrderCreatedEvent::class => [
            \App\Listeners\SpecialOrderCreatedListener::class,
        ],
        \App\Support\Chat\Events\MessageSent::class => [
            \App\Listeners\MessageSendListeners::class,
        ],
        \App\Support\Chat\Events\KitchenActivationEvent::class => [
            \App\Listeners\KitchenActivationListener::class,
        ],
        \App\Events\UserCancelSpecialOrderEvent::class => [
            \App\Listeners\UserCancelSpecialOrderListener::class,
        ],
        \App\Events\UserApproveSpecialOrderEvent::class => [
            \App\Listeners\UserApproveSpecialOrderListener::class,
        ],
        \App\Events\ChefApproveSpecialOrderEvent::class => [
            \App\Listeners\ChefApproveSpecialOrderListener::class,
        ],
        \App\Events\UserCancelOrderEvent::class => [
            \App\Listeners\UserCancelOrderListener::class,
        ],
        \App\Events\ChefEndSpecialOrder::class => [
            \App\Listeners\ChefEndSpecialOrderListener::class,
        ],
        \App\Events\OrderPreparedEvent::class => [
            \App\Listeners\OrderPreparedListener::class,
        ],
        \App\Events\UserReceiveOrderEvent::class => [
            \App\Listeners\UserReceiveOrderListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Customer::observe(PhoneVerificationObserver::class);
    }
}
