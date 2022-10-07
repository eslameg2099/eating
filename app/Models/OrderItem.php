<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kitchen_id',
        'meal_id',
        'quantity',
        'cost',
        'cost_after_discount',
        'purchased',
        'payment_method',
        'main_cost',
        'order_id'
    ];


    /**
     * Relations.
     */

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function meal()
    {
        return $this->belongsTo(Meal::class, 'meal_id')->withTrashed();
    }

//    public function getMedia($collectionName = 'default')
//    {
//        return $this->meal->getMedia($collectionName);
//    }
}
