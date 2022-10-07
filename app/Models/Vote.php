<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\MakeReviewNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Vote extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'kitchen_id',
        'special_order_id',
        'meal_id',
        'rate',
        'comment',
    ];

    /**
     * Relations.
     */

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
    public function specialOrder()
    {
        return $this->belongsTo(specialOrder::class);
    }

    public function sendCustomerAddedVote()
    {
        $this->notify(new MakeReviewNotification($this));
    }
}
