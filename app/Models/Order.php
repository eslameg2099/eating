<?php

namespace App\Models;

use App\Casts\DateTime;
use App\Http\Filters\Filterable;
use App\Http\Filters\OrderFilter;
use App\Traits\CouponTrait;
use App\Traits\EkhdemnyTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function PHPUnit\Framework\isNull;

class Order extends Model
{
    use HasFactory;
    use Filterable;
    use SoftDeletes;
    use CouponTrait;
    use EkhdemnyTrait;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const REQUEST_STATUS = 0;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const PENDING_STATUS = 1;

    /**
     * The code of cooking status.
     *
     * @var int
     */
    const COOKING_STATUS = 2;

    /**
     * The code of cooked status.
     *
     * @var int
     */
    const COOKED_STATUS = 3;

    /**
     * The code of assigned to delegate status.
     *
     * @var int
     */
    const RECEIVED_STATUS = 4;

    /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const DELIVERED_STATUS = 5;
    /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const CUSTOMER_CANCEL = 6;
    /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const CHEF_CANCEL = 7;
    /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const ADMIN_CANCEL = 8;
     /**
     * The code of delivered to delegate status.
     *
     * @var int
     */
    const AUTO_CANCEL = 9;


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
    protected $filter = OrderFilter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'chef_id',
        'kitchen_id',
        'delivery_id',
        'coupon_id',
        'address_id',
        'total_cost',
        'purchased',
        'payment_method',
        'shipping_cost',
        'delegate_id',
        'status',
        'notes',
        'cooked_at',
        'received_at',
        'delivered_at',
        'discount_percentage',
        'sub_total',
        'checkout_id',
        'system_percentage',
        'system_profit',
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

//    protected $casts = [
//        'cooked_at' => 'date:hh:mm'
//    ];


    /**
     *
     * Relations.
     *
     * @return Object
     */
    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function main_order()
    {
        return $this->belongsTo(MainOrder::class);
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function scopeReadablePaymentMethods()
    {
        switch ($this->payment_method) {
            case Order::ONLINE_PAYMENT:
                return trans("orders.payments.".Order::ONLINE_PAYMENT);
            case Order::CASH_PAYMENT:
                return trans("orders.payments.".Order::CASH_PAYMENT);
            case Order::WALLET_PAYMENT:
                return trans("orders.payments.".Order::WALLET_PAYMENT);
        }
    }
    public function scopeReadableStatus()
    {
        switch ($this->status) {
            case Order::REQUEST_STATUS:
                return trans("orders.messages.created");

            case Order::PENDING_STATUS:
                return trans("orders.messages.acceptOrder");

            case Order::COOKING_STATUS:
                return trans("orders.messages.workingOrder");

            case Order::COOKED_STATUS:
                return trans("orders.messages.orderPrepared");

            case Order::RECEIVED_STATUS:
                return trans("orders.messages.orderReceived");

            case Order::DELIVERED_STATUS:
                return trans("orders.messages.orderDelivered");

            case Order::CUSTOMER_CANCEL:
                return trans("orders.messages.orderCanceledUser");

            case Order::CHEF_CANCEL:
                return trans("orders.messages.orderCanceledChef");

            case Order::ADMIN_CANCEL:
                return trans("orders.modifiable_statuses.".Order::ADMIN_CANCEL);

            default:
                return 'غير معرف';
        }
    }
    public function scopeCanCancel()
    {
        if($this->status < 2 || $this->cooked_at == null)
        {
        return true;
        }
        else
         return false;

    }
    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chef()
    {
        return $this->belongsTo(Chef::class)->select("id", "name", "type", "email", "phone", "city_id");
    }
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function canceled()
    {
        return $this->belongsTo(CanceledOrder::class);
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assign_orders()
    {
        return $this->hasMany(AssignOrder::class);
    }
    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
