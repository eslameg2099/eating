<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\OrderFilter;
use App\Http\Filters\SpecialOrderFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialOrder extends Model
{
    use HasFactory;
    use Filterable;

    /**
     * The code of pending status.
     *
     * @var int
     */
    const REQUEST_STATUS = 0;


    /**
     * The code of cooking status.
     *
     * @var int
     */
    const ACCEPT_STATUS = 1;

    /**
     * The code of cooked status.
     *
     * @var int
     */
    const APPROVED_STATUS = 2;

    /**
     * The code of assigned to delegate status.
     *
     * @var int
     */
    const FINISHED_STATUS = 3;
    /**
     * The code of assigned to delegate status.
     *
     * @var int
     */
    const USER_CANCEL = 4;
    /**
     * The code of assigned to delegate status.
     *
     * @var int
     */
    const CHEF_CANCEL = 5;
    /**
     * The code of assigned to delegate status.
     *
     * @var int
     */
    const ADMIN_CANCEL = 6;

//    /**
//     * The code of delivered to delegate status.
//     *
//     * @var int
//     */
//    const DELIVERED_STATUS = 5;


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
    protected $filter = SpecialOrderFilter::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'code',
        'kitchen_id',
        'information',
        'address_id',
        'payment_method',
        'status',
        'cost',
        'time',
        'checkout_id'
    ];
    public function scopeReadablePaymentMethods()
    {
        switch ($this->payment_method) {
            case SpecialOrder::ONLINE_PAYMENT:
                return trans("orders.payments.".SpecialOrder::ONLINE_PAYMENT);
                break;
            case SpecialOrder::CASH_PAYMENT:
                return trans("orders.payments.".SpecialOrder::CASH_PAYMENT);
                break;
            case SpecialOrder::WALLET_PAYMENT:
                return trans("orders.payments.".SpecialOrder::WALLET_PAYMENT);
                break;
        }
    }
    public function scopeReadableStatusApp()
    {
        $path = "specialOrders.app-statuses.";
        switch ($this->status) {
            case SpecialOrder::REQUEST_STATUS:
                return trans($path.SpecialOrder::REQUEST_STATUS);
            case SpecialOrder::ACCEPT_STATUS:
                return trans($path.SpecialOrder::ACCEPT_STATUS);
            case SpecialOrder::APPROVED_STATUS:
                return trans($path.SpecialOrder::APPROVED_STATUS);
            case SpecialOrder::FINISHED_STATUS:
                return trans($path.SpecialOrder::FINISHED_STATUS);
            case SpecialOrder::USER_CANCEL:
                return trans($path.SpecialOrder::USER_CANCEL);
            case SpecialOrder::CHEF_CANCEL:
                return trans($path.SpecialOrder::CHEF_CANCEL);
            case SpecialOrder::ADMIN_CANCEL:
                return trans($path.SpecialOrder::ADMIN_CANCEL);
        }
    }

    public function scopeReadableStatus()
    {
        switch ($this->status) {
            case SpecialOrder::REQUEST_STATUS:
                return trans("specialOrders.messages.created");
                break;
            case SpecialOrder::ACCEPT_STATUS:
                return trans("specialOrders.messages.accepted");
                break;
            case SpecialOrder::APPROVED_STATUS:
                return trans("specialOrders.messages.approved");
                break;
            case SpecialOrder::FINISHED_STATUS:
                return trans("specialOrders.messages.finished");
                break;
            case SpecialOrder::USER_CANCEL:
                return trans("specialOrders.messages.userCancel");
                break;
            case SpecialOrder::CHEF_CANCEL:
                return trans("specialOrders.messages.chefCancel");
                break;
        }
    }

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }
    /**
     * Relations.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
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
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
