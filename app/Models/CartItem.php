<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Transformers\MediaResource;
use App\Support\Price;
use App\Http\Resources\ProductResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cart_id',
        'kitchen_id',
        'kitchen_id',
        'meal_id',
        'quantity',
        'cost',
        'cost_after_discount',
        'updated',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class)->withTrashed();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class)->withTrashed();
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
            'quantity' => $this->quantity,
            'updated' => $this->wasUpdated(),
            'updated_message' => $this->getUpdateMessage(),
            'price' => new Price((is_null($this->cost_after_discount)) ? $this->cost * $this->quantity: $this->cost_after_discount * $this->quantity),
            'item' => [
                'id' => $this->id,
                'quantity' => $this->quantity,
                'item_cost' => new Price((is_null($this->cost_after_discount)) ? $this->cost: $this->cost_after_discount),
                'kitchen' => [
                     'id' => $this->kitchen->id,
                     'name' => $this->kitchen->name,
                ],
                'meal' => [
                    'id' => $this->meal->id,
                    'name' => $this->meal->name,
                    'image' => $this->meal->getFirstMediaUrl('Meal'),
                    'price_meal'=> new Price($this->meal->getPrice() ),

                ],
            ],

        ];
    }

    /**
     * @return bool
     */
    public function wasUpdated()
    {
        if ($this->meal->trashed()) {
            return true;
        }

        return  $this->cost != $this->meal->getPrice();
    }

    /**
     * @return bool
     */
    public function getUpdateMessage()
    {
        if ($this->meal->trashed()) {
            return __('هذا المنتج غير متوفر حاليا');
        }
        if(is_null($this->cost_after_discount)){
            if($this->cost != $this->meal->getPrice()){
                return __('تم تحديث سعر المنتج');
            }
        }else {
            if($this->cost_after_discount != $this->meal->getPrice()){
                return __('تم تحديث سعر المنتج');
            }
        }
    }
}
