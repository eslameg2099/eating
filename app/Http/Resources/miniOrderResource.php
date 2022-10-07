<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\OrderItem;
use App\Support\Price;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;
use Laraeast\LaravelSettings\Facades\Settings;

class miniOrderResource extends JsonResource
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
            'user_id'=> $this->user_id,
            'chef_id' => $this->chef_id,
            'kitchen_id' => $this->kitchen_id,
            'kitchen_name' => $this->kitchen->name,
            'chef_name' => $this->chef->name,
            'discount_percentage' => $this->discount_percentage,
            'sub_total' =>new price($this->sub_total),
            'total_cost' =>new price($this->total_cost),
            'tax' => Settings::get('tax_ratio'),
            'added_tax' => Settings::get('additional_added_tax'),
            'shipping_cost' =>new price($this->shipping_cost),
            'status'=> $this->status,
            'readable_status' => $this->ReadableStatus(),
            'readable_payment_method' => $this->ReadablePaymentMethods(),
            'payment_method' => $this->payment_method,
            'timer' => $this->timer($this->updated_at, $this->status),
            'time_to_cook' =>  !is_null($this->cooked_at) ?$this->cooked_at->toDateTimeString() : null,
            'price' => new Price($this->total_cost),
            //'can_cancel' => ! ($this->status > Order::PENDING_STATUS),
            'can_cancel' => $this->canCancel(),
            'created_at' => $this->created_at->toDateTimeString(),
            'items_string' => $this->items->implode('meal.name', "\n"),
            'items' => MiniItemRsource::collection($this->items),
            'customer' => new MiniUserResource($this->customer),
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
