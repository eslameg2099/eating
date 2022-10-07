<?php

namespace App\Support\Payment\Models;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checkouts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'checkout_id',
        'transaction_identifier',
        'amount',
        'payment_type',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function transactions()
    {
        return $this->morphMany(Wallet::class, 'walletable');
    }

    /**
     * Determine whither the checkout status is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return ! ! preg_match("/^(000\.200)/", $this->status);
    }

    /**
     * Scope the query to include only pending checkouts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending(Builder $builder)
    {
        return $builder->whereRaw("status REGEXP '^(000\.200)'");
    }

    /**
     * Determine whither the checkout status is successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return ! ! preg_match("/^(000\.400\.0[^3]|000\.400\.100)/", $this->status);
    }

    /**
     * Scope the query to include only successful checkouts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuccessful(Builder $builder)
    {
        return $builder->whereRaw("status REGEXP '^(000\.400\.0[^3]|000\.400\.100)'");
    }

    /**
     * Determine whither the checkout status is successful and pending.
     *
     * @return bool
     */
    public function isSuccessfulAndPending()
    {
        return ! ! preg_match("/^(000\.000\.|000\.100\.1|000\.[36])/", $this->status);
    }

    /**
     * Scope the query to include only successful and pending checkouts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuccessfulAndPending(Builder $builder)
    {
        return $builder->whereRaw("status REGEXP '^(000\.000\.|000\.100\.1|000\.[36])'");
    }

    /**
     * Determine whither the checkout status is rejected due to blacklist validation.
     *
     * @return bool
     */
    public function isRejectedDueToBlacklistValidation()
    {
        return ! ! preg_match("/^(100\.100\.701|800\.[32])/", $this->status);
    }

    /**
     * Scope the query to include only rejected due to blacklist validation checkouts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejectedDueToBlacklistValidation(Builder $builder)
    {
        return $builder->whereRaw("status REGEXP '^(100\.100\.701|800\.[32])'");
    }

    /**
     * Determine whither the checkout status is rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return ! ! preg_match("/^(000\.400\.[1][0-9][1-9]|000\.400\.2)/", $this->status);
    }

    /**
     * Scope the query to include only rejected checkouts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected(Builder $builder)
    {
        return $builder->whereRaw("status REGEXP '^(000\.400\.[1][0-9][1-9]|000\.400\.2)'");
    }

    /**
     * Determine whither the checkout status is rejections by the external bank or similar payment system.
     *
     * @return bool
     */
    public function isRejectedByExternalBank()
    {
        return ! ! preg_match("/^(800\.[17]00|800\.800\.[123])/", $this->status);
    }

    /**
     * Scope the query to include only rejected By external bank checkouts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejectedByExternalBank(Builder $builder)
    {
        return $builder->whereRaw("status REGEXP '^(800\.[17]00|800\.800\.[123])'");
    }

}
