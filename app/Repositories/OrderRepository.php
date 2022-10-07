<?php

namespace App\Repositories;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Kitchen;
use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use App\Models\SpecialOrder;
use App\Models\Wallet;
use App\Support\Payment\Contracts\TransactionStatuses;
use App\Support\Payment\Facades\Cashier;
use Carbon\Carbon;
use App\Models\CanceledOrder;
use App\Models\Helpers\priceHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Collection;
use Laraeast\LaravelSettings\Facades\Settings;
use App\Models\Coupon;

class OrderRepository
{
    /**
     * The order instance.
     *
     * @var \App\Models\Meal
     */
    protected $cart;
    protected $kitchen;
    protected $OrderItem;
    protected $cost;
    protected $cost_after_discount;

    /**
     * Set the order array.
     *
     * @param \App\Models\Cart $cart
     */
    public function getCart($pin)
    {
        $this->cart = Cart::where('identifier', $pin)->orWhere('checkout_id',$pin)->first();

        return $this->cart;
    }

    /**
     * Set the order array.
     *
     * @param \App\Models\Cart $cart
     */
    public function getKitchen($identifier)
    {
        $this->kitchen = Cart::where('identifier', $identifier)->first()->kitchen()->first();

        return $this->kitchen;
    }

    /**
     * Set the order instance.
     *
     * @param \App\Models\OrderItem $OrderItem
     */
    public function setOrderItem()
    {
        $this->OrderItem = new OrderItem();

        return $this->OrderItem;
    }

    /**
     * Set the order instance.
     *
     * @param \App\Models\OrderItem $OrderItem
     */
    public function initCost() :void
    {
        $this->cost = 0;
        $this->cost_after_discount = 0;
    }

    /**
     * create Order items and clean up the cart created resource in storage.
     *
     * @param  array  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store_items($identifier)
    {        
        $cart = $this->getCart($identifier);
        $wallet_balance = auth()->user()->wallet()->Balance();
        //if($wallet_balance < ($cart->total)) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.can_withdrew")]);
        $order = $this->storeOrder($cart);

        return response()->json(['message' => trans('orders.messages.created') , 'order' => new OrderResource($order)]);
    }
    protected function storeOrder($cart)
    {
        $order = $this->create_order($cart);
        $this->setOrderItem();
        if ($order) {
            $this->setOrderItem();
            $order_item = $this->moveItems($order);
        }
        if (isset($order_item)) {
            $this->clean_cart();
        }
        broadcast(new OrderCreated($order)); // TODO
        return $order;
    }
    protected function moveItems($order){
        $items = $this->cart->items;
        foreach ($items as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'kitchen_id' => $order->kitchen_id,
                'meal_id' => $item->meal_id,
                'quantity' => $item->quantity,
                'cost' => $item->cost,
                'cost_after_discount' => $item->cost_after_discount,
                'main_cost' => is_null($item->cost_after_discount) ? $item->cost:$item->cost_after_discount
            ]);
        }
        return true;
    }

    private function create_order($cart)
    {
        $kitchen = Kitchen::find($cart->kitchen_id);
      //  if(! $kitchen->active) throw ValidationException::withMessages([
       //     'data' => trans("kitchen.messages.not-active")
      //  ]);
        $cart['chef_id'] = Kitchen::find($cart->kitchen_id)->user_id;
        $cart['total_cost'] = $cart['total'];
        $order = Order::create($cart->getAttributes());
        $order->user_id =auth()->user()->id;
        $order->system_percentage = Settings::get('systen_profit') ;
        $order->system_profit = (($cart['sub_total'] * Settings::get('systen_profit')) /100) ;
        $order->total_cost = ($cart->sub_total +$cart->shipping_cost  + priceHelper::adminCommission() + priceHelper::taxesAndServiceOnSpecialOrders()) - (((priceHelper::adminCommission()+(($cart->sub_total * Settings::get('systen_profit')) /100))*$cart->discount_percentage)/100);
        $order->save();
        if($order->coupon  != null)
        {
            $order->coupon->update([
                'used' =>$order->coupon->used+1,
            ]);
            $order->discount_value = ((priceHelper::adminCommission()+(($order->sub_total * Settings::get('systen_profit')) /100))*$order->discount_percentage)/100 ;
            $order->save();
        }
       $cart->delete();
       
        return $order;
    }

    public function clean_cart()
    {
        foreach ($this->cart->items as $item){
            $item->delete();
        }
        return $this->cart->delete();
    }

    /**
     * cancel Order for chef.
     *
     * @param collection $order
     * @return boolean
     */
    public function can_cancel($order): bool
    {
        $acceptable_statuses = [Order::REQUEST_STATUS , Order::PENDING_STATUS];
        switch (auth()->user()->type){
            case 'chef':
                return $this->chef_cancel($order,$acceptable_statuses);
                break;
            case 'customer':
                return $this->customer_cancel($order,$acceptable_statuses);
                break;
            default:
                return false;
        }
    }
    public function customer_cancel($order,$acceptable_statuses){
        if(auth()->user()->type != 'chef' && auth()->user()->id != $order->user_id) return false; // TODO: remove on policies
        if(! in_array($order->status, $acceptable_statuses)) return false;
        return true;
    }
    public function chef_cancel($order,$acceptable_statuses){
        if(auth()->user()->type != 'chef' && auth()->user()->id != $order->chef_id) return false; // TODO: remove on policies
        if(! in_array($order->status, $acceptable_statuses)) return false;
        return true;
    }
    public function autoCancel($order)
    {
        $order->delete();
        CanceledOrder::create([
            "order_id" => $order->id,
            "type" => 'auto'
        ]);
    }
    public function deliveryDistance($kitchen_lat,$kitchen_long,$user_lat,$user_long){
       return ;
    }

}
