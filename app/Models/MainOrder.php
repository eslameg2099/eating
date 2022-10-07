<?php

namespace App\Models;

use App\Casts\DateTime;
use App\Http\Filters\MainOrderFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainOrder extends Model
{
    use HasFactory;

    /**
     * The code of online payment.
     *
     * @var int
     */
    const ONLINE_PAYMENT = 0;

    /**
     * The code of cash payment.
     *
     * @var int
     */
    const CASH_PAYMENT = 1;
    /**
     * The code of cash payment.
     *
     * @var int
     */
    const WALLET_PAYMENT = 2;

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = MainOrderFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'addresses_id',
        'total_cost',
        'total_discount',
        'payment_method',
        'purchased',
        'note',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'cooked_at',
        // your other new column
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cooked_at' => DateTime::class,
    ];

    /**
     *
     * Relations.
     *
     * @return Object
     */

    /**
     * Retrieve the OrderItem instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function items()
    {
        return $this->hasManyThrough(
            OrderItem::class,
            Order::class,
            "main_order_id",
            "order_id");
    }
    /**
     * Retrieve the Order instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Retrieve the User instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Customer::class);
    }


}
