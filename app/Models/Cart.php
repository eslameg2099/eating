<?php

namespace App\Models;

use App\Models\Helpers\priceHelper;
use App\Support\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Resources\AddressResource;
use Laraeast\LaravelSettings\Facades\Settings;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'identifier',
        'user_id',
        'address_id',
        'kitchen_id',
        'coupon_id',
        'sub_total',
        'shipping_cost',
        'payment_method',
        'purchased_at',
        'notes'
    ];

    /**
     * Get the cart user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the cart address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    /**
     * Get the cart address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
    /**
     * Get the cart address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get all the cart items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'kitchen_id' => $this->kitchen_id,
            'identifier' => $this->identifier,
            'payment_method' => $this->payment_method,
            'readable_payment_method' => ! is_null($this->payment_method)
                ? trans('orders.payments.'.$this->payment_method)
                : null,
            'notes' => $this->notes,
            'taxesAndService' => new Price(priceHelper::adminCommission() + priceHelper::taxesAndServiceOnSpecialOrders()),
            'address' => $this->address ? new AddressResource($this->address) : null,
            'sub_total' => new Price($this->sub_total),
            'shipping_cost' => new Price($this->shipping_cost),
            'discount_percentage' => (float)$this->discount_percentage . "%",
            'discount_value' => new Price(((priceHelper::adminCommission()+(($this->sub_total * Settings::get('systen_profit')) /100))*$this->discount_percentage)/100),
            'total_service' => new Price($this->total - priceHelper::additionalAddedTax()),
            'added_value' => new Price(priceHelper::additionalAddedTax()),
            'total' => new Price(($this->sub_total +$this->shipping_cost  + priceHelper::adminCommission() + priceHelper::taxesAndServiceOnSpecialOrders()) - (((priceHelper::adminCommission()+(($this->sub_total * Settings::get('systen_profit')) /100))*$this->discount_percentage)/100)) ,
            'count_cart' => $this->items->sum('quantity'),
            'items' => $this->items,
        ];
    }
}
