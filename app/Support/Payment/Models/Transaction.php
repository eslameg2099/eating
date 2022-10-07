<?php

namespace App\Support\Payment\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\TransactionFilter;
use App\Models\Orders\Order;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Support\Payment\Contracts\TransactionTypes;
use App\Support\Payment\Contracts\TransactionStatuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model implements TransactionStatuses, TransactionTypes
{
    use HasFactory;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'actor_id',
        'identifier',
        'checkout_id',
        'amount',
        'status',
        'type',
        'notes',
        'date',
        'order_id',
        'account_name',
        'bank_name',
        'account_number',
        'iban_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    protected $filter = TransactionFilter::class;

    /**
     * The user who own the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checkout()
    {
        return $this->belongsTo(Checkout::class, 'checkout_id');
    }

    /**
     * The actor of the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id')->withTrashed();
    }

    /**
     * Get the transaction details.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(Transaction::class, 'parent_id');
    }

    /**
     * Get the parent transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Transaction::class, 'parent_id');
    }

    /**
     * The actor of the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope the query to include parents transactions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParentsOnly(Builder $builder)
    {
        return $builder->doesntHave('parent');
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return request('perPage', parent::getPerPage());
    }
}
