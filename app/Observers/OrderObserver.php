<?php

namespace App\Observers;

use App\Models\Delivery;
use App\Models\DeliveryCompany;
use App\Models\Helpers\priceHelper;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Delegate;
use App\Models\AssignOrder;
use App\Events\AssignOrderEvent;
use Illuminate\Database\Eloquent\Builder;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        /*


       if($order->status == Order::COOKING_STATUS) {
            $response = $order->setRecord()->requestDelivery();
            $data = $response->json();
            Delivery::create([
                'order_id' => $order->id,
                'delivery_company_id' =>1 DeliveryCompany::findOrFaile(1)->id ,
                'status' => $data['response'],
                'message' => $data['status'],
                'cost' => $order->choosePrice()
            ]);
        }
        if($order->status == Order::CUSTOMER_CANCEL) {
            $response = $order->requestCancelDelivery();
            //$data = $response->json();
            //Delivery::create([
            //    'order_id' => $order->id,
            //    'status' => $data['response'],
            //    'message' => $data['status'],
            //]);
        }

*/

    }
    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
