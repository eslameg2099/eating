<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'credit_id',
        'wallet_id',
        'value',
        'confirmed_at',
        'withdrawal_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class,'withdrawal_id');
    }
    public function credit()
    {
        return $this->belongsTo(Credit::class);
    }
    /**
     * Scope the query to include only unread messages.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHolding($query)
    {
        return $query->whereNull('confirmed_at');
    }
}
