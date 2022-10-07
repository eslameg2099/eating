<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Events\UserApproveSpecialOrderEvent;
use App\Events\UserCancelOrderEvent;
use App\Events\UserReceiveOrderEvent;
use App\Http\Resources\SpecialOrderResource;
use App\Jobs\AutoCancelOrder;
use App\Models\Address;
use App\Models\Helpers\priceHelper;
use App\Models\Kitchen;
use App\Models\SpecialOrder;
use App\Models\User;
use App\Models\Wallet;
use App\Support\Payment\Contracts\TransactionStatuses;
use App\Support\Payment\Facades\Cashier;
use Carbon\Carbon;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;
use App\Events\OrderAcceptedEvent;
use App\Events\OrderPreparedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\miniOrderResource;
use App\Http\Requests\Api\AcceptOrderRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OrdersController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository =$orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $orders = auth()->user()->orders()->filter()->latest()->simplePaginate();

        return miniOrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \app\Http\Requests\Api\OrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request, Order $order)
    {
        $exist_order = Order::where('user_id',auth()->user()->id)->where('status','<',Order::COOKING_STATUS)->first();
        if(! is_null($exist_order)) return response()->json(['message' => trans('orders.messages.unfinished_order')],422);

        return $this->orderRepository->store_items($request->identifier);
    }
    public function onlinePayment(Request $request)
    {
        $request->validate([
            'checkout_id' => 'required|exists:checkouts,checkout_id',
        ]);

        /** @var \App\Models\Users\User $user */
        $user = User::find(1);

        Cashier::setActor($user)->setCheckout($request->checkout_id);
        $checkout = Cashier::updateStatus()->getCheckout();

        if ($checkout->transactions()->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'checkout' => [__('The given checkout_id already used.')],
                'status' => trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        $status = TransactionStatuses::PENDING_STATUS;

        if ($checkout->isPending()) {
            $status = TransactionStatuses::PENDING_STATUS;
        }
        if ($checkout->isSuccessfulAndPending() || $checkout->isSuccessful()) {
            $status = TransactionStatuses::CHARGE_WALLET_STATUS;
        }
        if ($checkout->isRejected() || $checkout->isRejectedByExternalBank()) {
            $status = TransactionStatuses::REJECTED_STATUS;
        }

        if (! $checkout->isSuccessful() && ! $checkout->isSuccessfulAndPending()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'balance' => 'Error: '. trans('hyperpay.'. $checkout->status),
                'result-code' => $checkout->status,
                'checkout_id' => $checkout->checkout_id,
                'amount' => $checkout->amout,
            ]);
        }

        $order = Order::where('checkout_id', $request->checkout_id)->first();
        $user->wallet()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'checkout_id' => $checkout->id,
            'identifier' => $checkout->transaction_identifier,
            'transaction' => priceHelper::adminCommission(),
            'status' => $status,
            'title' => 'deposit',
            'confirmed' => '1',
            'type' => Wallet::TRANSFER_STATUS,
        ]);
        $order->kitchen->user->wallet()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'checkout_id' => $checkout->id,
            'identifier' => $checkout->transaction_identifier,
            'transaction' => $checkout->amount - ( $order->system_profit + priceHelper::adminCommission()),
            'status' => $status,
            'title' => 'deposit',
            'confirmed' => '1',
            'type' => Wallet::TRANSFER_STATUS,
        ]);

        $order->update([
            'status' => Order::COOKING_STATUS
        ]);
        $order->active = User::CUSTOMER_TYPE;
        event(new OrderAcceptedEvent($order));
        return response()->json([
            'message' => 'done'
        ]);

        //DB::commit();

        //event(new WalletRechargeEvent($transaction));

    }


    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\AcceptOrderRequest $request
     * @param  Order $order
     * @return OrderResource
     */
    public function accept_order(AcceptOrderRequest $request, Order $order)
    {
        
        if ($order->status == Order::REQUEST_STATUS) {
            $order->update([
                'cooked_at' => Carbon::parse($request->validated()['cooked_at']),
                'status' => Order::PENDING_STATUS,
            ]);
        }
        $order->active = User::CHEF_TYPE;
        event(new OrderAcceptedEvent($order)); // TODO

        return new OrderResource($order->refresh());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order $order
     * @return OrderResource
     */
    public function walletPayment($order )
    {
        $wallet = new Wallet() ;
        $wallet_balance = auth()->user()->wallet()->Balance();
        if($wallet_balance < $order->total ) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.can_withdrew")]);
        $mony_system =($order->total_cost - $order->sub_total) + $order->system_profit ;
        $transaction = $wallet->transferMoney(auth()->user(),User::find(1),$mony_system);
        $money_kitchen = ($order->sub_total - $order->system_profit);
        $transaction = $wallet->transferMoney(auth()->user(),$order->kitchen->user,$money_kitchen);
        if (! $transaction) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.transaction-error")]);
    }





    
    public function working_order(Order $order, Request $request)
    {
        $request->validate([
            'checkout_id' => 'nullable|exists:checkouts,checkout_id',
        ]);
        $user = auth()->user(); 
        if ($user->type != 'customer' && $user->id != $order->user_id) return response()->json(["message"=>"Unuthorized"],422);
        if ($order->status != Order::PENDING_STATUS) return response()->json(["message" => trans('orders.messages.workingOrder')]);
        DB::transaction(function() use($order , $request) {
            if($order->payment_method == SpecialOrder::WALLET_PAYMENT) $this->walletPayment($order);
        });
        if($order->payment_method == Order::ONLINE_PAYMENT)
        {
            if (isset($request->checkout_id)) {
                $order->update(['checkout_id' => $request->checkout_id]);

                
                  $order->update([
            'status' => 2,
        ]);
                return new OrderResource($order->refresh());
            }
        }

        $order->update([
            'status' => 2,
        ]);
        $order->active = User::CUSTOMER_TYPE;
        event(new OrderAcceptedEvent($order));

        return new OrderResource($order->refresh());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\AcceptOrderRequest $request
     * @param  Order $order
     * @return OrderResource
     */
    public function prepare_order(Order $order)
    {
        if ($order->status != Order::COOKING_STATUS) {
            return response()->json(trans('orders.messages.workingOrder'));
        }
        auth()->user()->orders()->where('id', $order->id)->first()->update([
            'status' => Order::COOKED_STATUS,
        ]);
        try {
            event(new OrderPreparedEvent($order->refresh()));
        } catch (\Throwable $exception) {
            return response()->json(['message'=>"Something went wrong"], 422);
        }

        return new OrderResource($order->refresh());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\AcceptOrderRequest $request
     * @param  Order $order
     * @return OrderResource
     */
    public function deliver_to_order(Order $order)
    {
        if ($order->status != Order::COOKED_STATUS) {
            return response()->json(trans('orders.messages.workingOrder'),422);
        }
        auth()->user()->orders()->where('id', $order->id)->first()->update([
            'status' => Order::RECEIVED_STATUS,
        ]);
        event(new OrderAcceptedEvent($order)); // TODO

        return new OrderResource($order->refresh());
    }
    public function receive_order(Order $order)
    {
        if ($order->status != Order::RECEIVED_STATUS) {
            return response()->json(trans('orders.messages.workingOrder'),422);
        }
        auth()->user()->orders()->where('id', $order->id)->first()->update([
            'status' => Order::DELIVERED_STATUS,
        ]);
        event(new UserReceiveOrderEvent($order->refresh()));

        return new OrderResource($order->refresh());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        //if(! $this->orderRepository->can_cancel($order)) return response()->json(['message'=>trans("orders.messages.cannot_cancel")], 422);
        if($order->status >= 2) return response()->json(['message'=>trans("orders.messages.cannot_cancel")], 422);
        //$order->delete();
        if (auth()->user()->type == User::CUSTOMER_TYPE) {
            $order->update([
                'status' => Order::CUSTOMER_CANCEL
            ]);
            $order->type = User::CUSTOMER_TYPE;
        }
        if (auth()->user()->type == User::CHEF_TYPE) {
            $order->update([
                'status' => Order::CHEF_CANCEL
            ]);
            $order->type = User::CHEF_TYPE;
        };

        auth()->user()->cancel_order()->create([
            "order_id" => $order->id,
            "type" => 'manual'
        ]);

        event(new UserCancelOrderEvent($order));

        return response()->json(['message'=>trans('orders.messages.deleted')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function chef_cancel(){
        if (!auth()->type == 'chef')return response()->json(["message" => 'Unauthorized'], 401);
    }
}
