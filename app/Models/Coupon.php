<?php

namespace App\Models;

use App\Http\Filters\CouponFilter;
use App\Http\Filters\Filterable;
use App\Traits\CouponTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CouponTrait;
    use Filterable;


    const NUMERIC_DISCOUNT = 'numeric';
    const PERCENTAGE_DISCOUNT = 'percentage';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        "title",
        "discount",
        "discount_percentage",
        "limit",
        "expire_date",
        'used',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['expire_date'];
    protected $filter = CouponFilter::class;

    /**
     * Retrieve the user instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders(){
        return $this->belongsToMany(Order::class);
    }
    /**
     * Determine whither the coupon is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return (is_null($this->expire_date)) ? false :  $this->expire_date->isPast();
    }

    public function isused()
    {
        if($this->used < $this->limit){return false;}else{ return true;}
    }

}
