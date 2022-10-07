<?php

namespace App\Support\Cart;

use App\Models\Cart;
use App\Models\Helpers\priceHelper;
use App\Models\Meal;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use DB;
use Illuminate\Support\Str;
use App\Support\Cart\Events\ItemAdded;
use Illuminate\Validation\ValidationException;

class CartServices
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var \App\Models\Cart
     */
    protected $cart;

    /**
     * @var \App\Models\CartItem[]|\Illuminate\Database\Eloquent\Collection
     */
    protected $items;

    /**
     * @var \App\Models\User|null
     */
    protected $user;

    /**
     * @var array
     */
    protected $cartData = [];

    /**
     * CartServices constructor.
     *
     * @param null $identifier
     * @param \App\Models\User|null $user
     */
    public function __construct($identifier = null, User $user = null)
    {
        $this->cartData['identifier'] = $identifier;

        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        if (empty($this->cartData['identifier'])) {
            $this->setIdentifier(Str::uuid());
        }

        return $this->cartData['identifier'];
    }

    /**
     * @param mixed $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->cartData['identifier'] = $identifier;

        return $this;
    }
    /**
     * @param mixed $identifier
     * @return $this
     */
    public function setKitchen($Kitchen_id)
    {
        $this->cartData['kitchen_id'] = $Kitchen_id;

        return $this;
    }

    /**
     * @param $paymentMethod
     * @return $this
     */
    public function paymentMethod($paymentMethod)
    {
        $this->cartData['payment_method'] = $paymentMethod;

        return $this;
    }

    /**
     * @param $shippingCost
     * @return $this
     */
    public function shippingCost($shippingCost)
    {
        $this->cartData['shipping_cost'] = $shippingCost;
        return $this;
    }

    /**
     * @return \App\Models\Cart
     */
    public function getCart()
    {
        $cart = $this->getCartViaUser() ?: $this->getCartViaIdentifier();
        $cart = $cart ?: $this
            ->createCartForIdentifier()
            ->getCartViaIdentifier();

        $this->refreshItems();

        return $cart;
    }

    /**
     * @return $this
     */
    public function assignUserToCart(User $user = null)
    {
        $cart = $this->getCart();

        if (! $cart->user) {
            $cart->update(['user_id', $user->id ?? null]);
        }

        return $this;
    }

    /**
     * @return \App\Models\Cart|void|null
     */
    public function getCartViaUser()
    {
        if (! $this->getUser()) {
            return;
        }
        return $this->cart = Cart::where('user_id', $this->getUser()->id)->first();
    }

    /**
     * @return \App\Models\Cart|null
     */
    public function getCartViaIdentifier()
    {
        $cart = $this->cart = Cart::where('identifier', $this->getIdentifier())->first();
        if(! is_null($cart)) if(isset($this->user->id)) if(is_null($this->cart->user_id)) $cart->forceFill(['user_id' => $this->user->id])->save();
        return $cart;
    }

    /**
     * @return $this
     */
    public function createCartForIdentifier()
    {
        if ($user = $this->getUser()) {
            $this->cartData['user_id'] = $user->id;
        }
        $this->cart = Cart::create($this->cartData);

        return $this;
    }

    /**
     * @return $this
     */
    public function refreshItems()
    {
        $this->items = $this->cart->items()->get();

        return $this;
    }

    /**
     * @return $this
     */
    public function updateTotals()
    {
        $cart = $this->getCart();

        $sub_total = $cart->items->map(function (CartItem $item) {
            return (!is_null($item->cost_after_discount)) ? $item->cost_after_discount * $item->quantity : $item->cost * $item->quantity ;
        })->sum();

        $this->cartData['shipping_cost'] = $this->cartData['shipping_cost'] ?? $cart->shipping_cost;
        $total = ($this->cartData['shipping_cost']) ? $sub_total + $this->cartData['shipping_cost'] : $sub_total + $this->cartData['shipping_cost'];

        if($cart->discount_percentage) $total = $total - (($total *  $cart->discount_percentage )/ 100);
        
        $cart->forceFill([
            'sub_total' => $sub_total,
            'total' => $total
        ])->save();

        $this->cart = $cart;

        return $this;
    }

    /**
     * @return \App\Models\CartItem[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     * @return $this
     */
    public function addItem($mealId, $kitchenId,int $quantity = 1)
    {
        // Ensure that the given product id is the key of product.
        if ($mealId instanceof Meal) {
            $mealId = $mealId->id;
        }

        // Ensure that the given product is exists.
        if (! $meal = Meal::find($mealId)) {
            throw ValidationException::withMessages([
                'quantity' => __('The requested meal is not found.'),
            ]);
        }
        $card = $this
            ->getCart();

        $item = $card
            ->items()
            ->where('meal_id', $meal->id)
            ->first();
        //if(! is_null($item)) throw ValidationException::withMessages(["message" => trans("carts.messages.exists")]);
        if(! $card
            ->where('kitchen_id', $meal->kitchen_id)
            ->first()) throw ValidationException::withMessages(["message" => trans("carts.messages.diff_kitchen")]);
        if(! is_null($item)) {
            $item->quantity ? $quantity = $item->quantity +1 : $quantity = 1;
            $item->update([
                'quantity' => $quantity ,
            ]);
        } else {
            $item = $this->getCart()->items()->create([
                'kitchen_id' => $meal->kitchen_id,
                'meal_id' => $meal->id,
                'cost' => $meal->cost,
                'cost_after_discount' => $meal->cost_after_discount,
                'quantity' => $quantity,
            ]);
        }
        //$item = $card
        //    ->where('kitchen_id', $meal->kitchen_id)
        //    ->first();




        // Update the cart items.
        $this->refreshItems();

        $this->updateTotals();

        // Fire an event to handle real-time.
        broadcast(new ItemAdded($item))->toOthers();

        return $this;
    }

    /**
     * @return \App\Models\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \App\Models\User|null $user
     * @return \App\Support\Cart\CartServices
     */
    public function setUser(?User $user)
    {
        $this->user = $user;

        return $this;
    }
}
