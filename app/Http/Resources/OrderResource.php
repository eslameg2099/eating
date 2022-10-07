<?php

namespace App\Http\Resources;
use App\Models\Helpers\priceHelper;
use App\Support\Price;

use App\Models\Order;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Delegate\AssignOrderResource;
use Laraeast\LaravelSettings\Facades\Settings;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_code'=> (string)$this->id,
            'user_id'=> $this->user_id,
            'chef_id' => $this->chef_id,
            'kitchen_id' => $this->kitchen_id,
            'kitchen_name' => $this->kitchen->name,
            'chef_name' => $this->chef->name,
            //'can_cancel' => ! ($this->status > Order::PENDING_STATUS),
            'can_cancel' => $this->canCancel(),
            'delivery_id'=> $this->delivery_id,
            'discount_percentage' => $this->discount_percentage . "%",
            'discount_value' => new Price(((priceHelper::adminCommission()+(($this->sub_total * Settings::get('systen_profit')) /100))*$this->discount_percentage)/100),
            'sub_total' => new price($this->sub_total),
            'total_cost' => new Price($this->total_cost) ,
            'tax' => Settings::get('tax_ratio'),
            'added_tax' => Settings::get('additional_added_tax'),
            'shipping_cost' => new price($this->shipping_cost),
            
            'system_percentage'=> $this->system_percentage .'%',

            'deserved_amount' => new price($this->sub_total - $this->system_profit),
            'system_profit' => new price($this->system_profit),
             //'order_cost' => new Price($this->total_cost),
            'taxesAndService' =>new Price(priceHelper::adminCommission() + priceHelper::taxesAndServiceOnSpecialOrders()),
            
            'purchased' => $this->purchased,
            'payment_method' => $this->payment_method,
            'timer' => $this->timer($this->updated_at, $this->status),
            'time_to_cook'=> !is_null($this->cooked_at) ?$this->cooked_at->format('d/m/Y h:i') : null,
            'delegate_id'=> $this->delegate_id,
            'status'=> $this->status,
            'readable_status' => $this->ReadableStatus(),
            'notes'=> $this->notes,
            'cooked_at'=> !is_null($this->cooked_at) ?$this->cooked_at->format('d/m/Y h:i') : null,
            'cooked_at_formatted'=> !is_null($this->cooked_at) ? $this->cooked_at->diffForHumans() : null,
            'received_at'=> !is_null($this->received_at) ?$this->received_at->toDateTimeString() : null,
            'received_at_formatted'=> !is_null($this->received_at) ? $this->received_at->diffForHumans() : null ,
            'delivered_at'=> $this->delivered_at,
            'created_at' => $this->created_at->format('d/m/Y h:i'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'readable_payment_method' => $this->ReadablePaymentMethods(),
            'items' => OrderItemResource::collection($this->items),
            'address' => new AddressResource($this->address),
            'chef' => new MiniUserResource($this->chef) ,
            'user' => new MiniUserResource($this->customer),
            'assigned' => AssignOrderResource::collection($this->assign_orders),
            'coupon' => $this->coupon,
        ];
    }
    protected function timer($updated_at,$status)
    {
        $arr = [Order::REQUEST_STATUS , Order::PENDING_STATUS] ;
        if(in_array($status,$arr))
        {
            $updatedAt = Carbon::parse($updated_at);
            $duration = (5*60);
            $time = ($duration - now()->diffInSeconds($updatedAt));
            return ($time >= 0) ? $time : 0;
        }
        return null;
    }
}
