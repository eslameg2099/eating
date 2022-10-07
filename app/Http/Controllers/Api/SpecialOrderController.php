<?php

namespace App\Http\Controllers\Api;

use App\Events\ChefApproveSpecialOrderEvent;
use App\Events\ChefEndSpecialOrder;
use App\Events\SpecialOrderCreatedEvent;
use App\Events\UserApproveSpecialOrderEvent;
use App\Events\UserCancelSpecialOrderEvent;
use App\Models\Helpers\priceHelper;
use App\Models\Kitchen;
use App\Models\KitchenSponsor;
use App\Models\SpecialOrder;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\MakeSpecialOrderNotification;
use App\Support\Payment\Contracts\TransactionStatuses;
use App\Support\Payment\Facades\Cashier;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SpecialOrderResource;
use App\Http\Requests\Api\CreateSpecialOrder;
use App\Http\Requests\Api\UpdateSpecialOrder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

class SpecialOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $specialOrder = auth()->user()->special_orders()->filter()->latest()->simplePaginate();
        return  SpecialOrderResource::collection($specialOrder);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\CreateSpecialOrder  $request
     * @return SpecialOrderResource
     */
    public function store(CreateSpecialOrder $request, SpecialOrder $specialOrder)
    {
        $record = $request->validated();
        $kitchen = Kitchen::find($request->kitchen_id);
        if(! $kitchen->active_special) throw ValidationException::withMessages([
            'data' => trans("kitchen.messages.not-active")
        ]);

        $specialOrder = $specialOrder->create($record);
        event(new SpecialOrderCreatedEvent($specialOrder)); //TODO
        return new SpecialOrderResource($specialOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return SpecialOrderResource
     */
    public function show(SpecialOrder $specialOrder)
    {

        return new SpecialOrderResource($specialOrder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\UpdateSpecialOrder $request
     * @param  SpecialOrder $specialOrder
     * @return SpecialOrderResource
     */
    public function update(UpdateSpecialOrder $request, SpecialOrder $specialOrder)
    {
        $specialOrder->update([
            'cost' => $request->validated()['cost'],
            'time' => Carbon::parse($request->validated()['time']),
            'status' => 1,
        ]);
        event(new ChefApproveSpecialOrderEvent($specialOrder->refresh()));
        return new SpecialOrderResource($specialOrder->load('kitchen', 'customer')->refresh());
    }
    
    public function walletPayment($kitchenSponsor )
    {
        $wallet = new Wallet() ;
        $wallet_balance = auth()->user()->wallet()->Balance();
        if($wallet_balance < ($kitchenSponsor->cost + priceHelper::adminCommission())) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.can_withdrew")]);
        $transaction = $wallet->transferMoney(auth()->user(),User::find(1),priceHelper::adminCommission());
        $transaction = $wallet->transferMoney(auth()->user(),$kitchenSponsor->kitchen->user,$kitchenSponsor->cost);
        if (! $transaction) throw \Illuminate\Validation\ValidationException::withMessages(["message" => trans("wallets.messages.transaction-error")]);
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
            $status = TransactionStatuses::TRANSFER_STATUS;
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

        $special_order = SpecialOrder::where('checkout_id', $request->checkout_id)->first();
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
        $special_order->kitchen->user->wallet()->create([
            'user_id' => optional(Cashier::getActor())->id,
            'checkout_id' => $checkout->id,
            'identifier' => $checkout->transaction_identifier,
            'transaction' => $checkout->amount - priceHelper::adminCommission(),
            'status' => $status,
            'title' => 'deposit',
            'confirmed' => '1',
            'type' => Wallet::TRANSFER_STATUS,
        ]);

        $special_order->update([
            'status' => SpecialOrder::APPROVED_STATUS
        ]);
        event(new UserApproveSpecialOrderEvent($special_order->refresh()));
        return response()->json([
            'message' => 'done'
        ]);

        //DB::commit();

        //event(new WalletRechargeEvent($transaction));

    }
    public function accept(Request $request , SpecialOrder $specialOrder)
    {
        
        $request->validate([
            'checkout_id' => 'nullable|exists:checkouts,checkout_id',
        ]);
        DB::transaction(function() use($specialOrder , $request) {
            if($specialOrder->payment_method == SpecialOrder::WALLET_PAYMENT) $this->walletPayment($specialOrder);
        });
        if($specialOrder->payment_method == SpecialOrder::ONLINE_PAYMENT)
        {
            if (isset($request->checkout_id)) {
                $specialOrder->update(['checkout_id' => $request->checkout_id]);
                return new SpecialOrderResource($specialOrder->load('kitchen', 'customer')->refresh());
            }
        }
        $specialOrder->update([
            'status' => 2,
        ]);
        event(new UserApproveSpecialOrderEvent($specialOrder->refresh()));
        return new SpecialOrderResource($specialOrder->load('kitchen', 'customer')->refresh());
    }

    public function userCancel(SpecialOrder $specialOrder)
    {
        //if($specialOrder->status > SpecialOrder::APPROVED_STATUS) return response()->json(["data" => trans('specialOrders.messages.cannotCancel')]);
        $specialOrder->update([
            'status' => SpecialOrder::USER_CANCEL,
        ]);
        $specialOrder->type="customer";

        event(new UserCancelSpecialOrderEvent($specialOrder));

        return new SpecialOrderResource($specialOrder->load('kitchen', 'customer')->refresh());
    }
    public function chefCancel(SpecialOrder $specialOrder)
    {
        if($specialOrder->status > SpecialOrder::APPROVED_STATUS) return response()->json(["data" => trans('specialOrders.messages.cannotCancel')]);
        $specialOrder->update([
            'status' => SpecialOrder::CHEF_CANCEL,
        ]);
        $specialOrder->type="chef";
        event(new UserCancelSpecialOrderEvent($specialOrder));

        return new SpecialOrderResource($specialOrder->load('kitchen', 'customer')->refresh());
    }


    public function finish(SpecialOrder $specialOrder)
    {
        auth()->user()->special_orders()->where('special_orders.id', $specialOrder->id)->update([
            'status' => SpecialOrder::FINISHED_STATUS,
        ]);
        event(new ChefEndSpecialOrder($specialOrder));
        return new SpecialOrderResource($specialOrder->refresh());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
