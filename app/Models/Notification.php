<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    /**
     * @var int
     */
    const ORDER_TYPE = 1;
    const VOTE_TYPE = 2;
    const FAVORITE_TYPE = 3;
    const SPECIALORDER_TYPE = 4;
    const CHAT_TYPE = 5;
    const ACTIVATION_TYPE = 6;
    const ADMIN_TYPE = 7;
    const Beforeten_TYPE = 8;

    /**
     * Get the user that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function notifiable()
    {
         return $this->morphTo(); // TODO: Change the autogenerated stub
    }

    /**
     * Get the user that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reciever()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }

    /**
     * Get the order that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    /**
     * Get the shop that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }
    /**
     * Get the shop that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id');
    }
    /**
     * Get the shop that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialOrder()
    {
        return $this->belongsTo(SpecialOrder::class, 'special_order_id');
    }

    /**
     * Get the transaction that associated the notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}