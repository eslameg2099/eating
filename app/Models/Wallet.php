<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\WalletFilter;
use App\Support\Payment\Contracts\TransactionStatuses;
use App\Support\Payment\Contracts\TransactionTypes;
use App\Traits\WalletTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model implements TransactionStatuses, TransactionTypes
{
    use HasFactory;
    use Filterable ;
    use WalletTrait ;


    /**
     * The code of request status.
     *
     * @var int
     */
    const REQUEST_STATUS = 0;
    /**
     * The code of refund status.
     *
     * @var int
     */
    //const REFUND_STATUS = 1;
    /**
     * The code of refund status.
     *
     * @var int
     */
    //const TRANSFER_STATUS = 2;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'credit_id',
        'identifier',
        'checkout_id',
        'walletable_id',
        'walletable_type',
        'withdrawal_id',
        'transaction',
        'title',
        'confirmed',
        'status',
        'note'
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = WalletFilter::class;

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return User::class;
    }

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'model_id';
    }
    public function scopeReadableStatus()
    {
        switch ($this->status) {
            case TransactionStatuses::CHARGE_WALLET_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::CHARGE_WALLET_STATUS);
            case TransactionStatuses::PENDING_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::PENDING_STATUS);
            case TransactionStatuses::HOLED_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::HOLED_STATUS);
            case TransactionStatuses::REJECTED_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::REJECTED_STATUS);
            case TransactionStatuses::WITHDRAWAL_REQUEST_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::WITHDRAWAL_REQUEST_STATUS);
            case TransactionStatuses::WITHDRAWAL_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::WITHDRAWAL_STATUS);
            case TransactionStatuses::TRANSFER_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::TRANSFER_STATUS);
            case TransactionStatuses::SPONSOR_STATUS:
                return trans("wallets.statuses.".TransactionStatuses::SPONSOR_STATUS);
            default;
                return trans("wallets.statuses.".'0');

        }
    }

    /**
     * Relations.
     * @return object
     */
    public function walletable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class,"walletable_id");
    }
    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class,'withdrawal_id');
    }

    public function scopeBalance($query)
    {
        return $query->sum("transaction");
    }
    public function scopeDeposit($query)
    {
        return $query->where('title','deposit')->where('transaction','>',0)->sum("transaction");
    }
    public function scopePendingWithdrawal($query)
    {
        return $query->where('title','withdrawal')->where('transaction','<',0)->where('confirmed',0)->sum("transaction");
    }

}
